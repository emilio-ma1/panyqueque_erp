<?php
/**
 * Resilient MariaDB / MySQL database connector via PDO (Singleton pattern).
 *
 * This module provides a centralized, singleton-based database access layer
 * for the Pan y Queque ERP. It wraps PDO with error handling that logs failures
 * to the server error log (in English, per Section 6.2 of the Coding Standards)
 * and exposes a safe, parameterised query interface.
 *
 * MariaDB 10.11 / MySQL 8.0 Compatible.
 */

require_once __DIR__ . '/config.php';

class DB
{
    /** @var PDO|null Singleton PDO instance */
    private static ?PDO $instance = null;

    /** @var string|null Last error message for diagnostic purposes */
    private static ?string $lastError = null;

    /** @var bool Flag indicating if connection has already been attempted */
    private static bool $connectionAttempted = false;

    /**
     * Return a singleton PDO connection to the MariaDB database.
     *
     * On first call, creates and caches the connection. Subsequent calls
     * return the cached instance. Returns null when the connection fails,
     * logging the technical error for server-side diagnostics.
     *
     * @return PDO|null The active PDO connection, or null on failure.
     */
    public static function getConnection(): ?PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        if (self::$connectionAttempted) {
            return null;
        }

        self::$connectionAttempted = true;

        $host   = DB_HOST;
        $port   = DB_PORT;
        $dbname = DB_NAME;
        $user   = DB_USER;
        $pass   = DB_PASS;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT            => 2,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
        ];

        // Attempt primary connection
        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
        try {
            self::$instance = new PDO($dsn, $user, $pass, $options);
            self::$lastError = null;
            return self::$instance;
        } catch (PDOException $e) {
            // If primary host was 'db' and failed (e.g. running outside Docker container), try 127.0.0.1 fallback
            if ($host === 'db') {
                try {
                    $fallbackDsn = "mysql:host=127.0.0.1;port={$port};dbname={$dbname};charset=utf8mb4";
                    self::$instance = new PDO($fallbackDsn, $user, $pass, $options);
                    self::$lastError = null;
                    return self::$instance;
                } catch (PDOException $fallbackEx) {
                    // Fall back to original error
                }
            }

            self::$lastError = $e->getMessage();
            error_log("[ERROR] MariaDB connection failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Check whether the MariaDB connection is alive.
     *
     * @return bool True when a valid PDO instance exists, false otherwise.
     */
    public static function isConnected(): bool
    {
        return self::getConnection() !== null;
    }

    /**
     * Reset the cached connection (useful for unit testing and reconnection).
     */
    public static function resetConnection(): void
    {
        self::$instance = null;
        self::$lastError = null;
    }

    /**
     * Return the last recorded error message, if any.
     *
     * @return string|null The error message string, or null when no error occurred.
     */
    public static function getLastError(): ?string
    {
        return self::$lastError;
    }

    /**
     * Execute a parameterised SELECT query and return all matching rows.
     *
     * @param string $query  The SQL SELECT statement (use ? or :named placeholders).
     * @param array  $params Bind values matching the placeholders in $query.
     * @return array An array of associative-array rows, or [] on failure.
     */
    public static function select(string $query, array $params = []): array
    {
        $pdo = self::getConnection();
        if (!$pdo) {
            return [];
        }

        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            self::$lastError = $e->getMessage();
            error_log("[ERROR] Database query failed: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Execute a parameterised SELECT query and return a single row or null.
     *
     * @param string $query  The SQL SELECT statement.
     * @param array  $params Bind values matching the placeholders.
     * @return array|null The row associative array, or null if not found or on failure.
     */
    public static function selectOne(string $query, array $params = []): ?array
    {
        $pdo = self::getConnection();
        if (!$pdo) {
            return null;
        }

        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            $row = $stmt->fetch();
            return $row !== false ? $row : null;
        } catch (PDOException $e) {
            self::$lastError = $e->getMessage();
            error_log("[ERROR] Database selectOne failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Execute a parameterised UPDATE, DELETE, or general SQL query.
     *
     * @param string $query  The SQL statement.
     * @param array  $params Bind values.
     * @return bool True on success, false on failure.
     */
    public static function execute(string $query, array $params = []): bool
    {
        $pdo = self::getConnection();
        if (!$pdo) {
            return false;
        }

        try {
            $stmt = $pdo->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            self::$lastError = $e->getMessage();
            error_log("[ERROR] Database execute failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Execute an INSERT query and return the last generated AUTO_INCREMENT ID.
     *
     * @param string $query  The SQL INSERT statement.
     * @param array  $params Bind values.
     * @return int The last inserted row ID, or 0 on failure.
     */
    public static function insert(string $query, array $params = []): int
    {
        $pdo = self::getConnection();
        if (!$pdo) {
            return 0;
        }

        try {
            $stmt = $pdo->prepare($query);
            $success = $stmt->execute($params);
            if ($success) {
                return (int)$pdo->lastInsertId();
            }
            return 0;
        } catch (PDOException $e) {
            self::$lastError = $e->getMessage();
            error_log("[ERROR] Database insert failed: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Begin a database transaction.
     */
    public static function beginTransaction(): bool
    {
        $pdo = self::getConnection();
        return $pdo ? $pdo->beginTransaction() : false;
    }

    /**
     * Commit the active transaction.
     */
    public static function commit(): bool
    {
        $pdo = self::getConnection();
        return $pdo ? $pdo->commit() : false;
    }

    /**
     * Roll back the active transaction.
     */
    public static function rollBack(): bool
    {
        $pdo = self::getConnection();
        return $pdo ? $pdo->rollBack() : false;
    }
}
