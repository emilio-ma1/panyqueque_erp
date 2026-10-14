<?php
/**
 * Resilient PostgreSQL database connector via PDO (Singleton pattern).
 *
 * This module provides a centralized, singleton-based database access layer
 * for the Pan y Queque ERP. It wraps PDO with error handling that logs failures
 * to the server error log (in English, per Section 6.2 of the Coding Standards)
 * and exposes a safe query interface.
 *
 * Design decision: Exceptions are caught, logged with technical detail for
 * ops/QA diagnostics, and converted to predictable return values (null / [])
 * so the UI layer can gracefully degrade without exposing internal details.
 */

require_once __DIR__ . '/config.php';

class DB
{
    /** @var PDO|null Singleton PDO instance */
    private static ?PDO $instance = null;

    /** @var string|null Last error message for diagnostic purposes */
    private static ?string $lastError = null;

    /**
     * Return a singleton PDO connection to the PostgreSQL database.
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

        $host   = DB_HOST;
        $port   = DB_PORT;
        $dbname = DB_NAME;
        $user   = DB_USER;
        $pass   = DB_PASS;

        $dsn = "pgsql:host={$host};port={$port};dbname={$dbname};options='--client_encoding=UTF8'";

        try {
            self::$instance = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT            => 3,
            ]);
            self::$lastError = null;
            return self::$instance;
        } catch (PDOException $e) {
            self::$lastError = $e->getMessage();
            error_log("[ERROR] Database connection failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Check whether the PostgreSQL connection is alive.
     *
     * @return bool True when a valid PDO instance exists, false otherwise.
     */
    public static function isConnected(): bool
    {
        return self::getConnection() !== null;
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
     * Uses prepared statements to prevent SQL injection. On failure the error
     * is logged server-side and an empty array is returned so the caller can
     * degrade gracefully.
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
}
