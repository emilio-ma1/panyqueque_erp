<?php
/**
 * ==============================================================================
 * Panadería y Pastelería Pan y Queque - Conector PostgreSQL (PDO)
 * Conexión resiliente a base de datos con soporte de contingencia
 * ==============================================================================
 */

require_once __DIR__ . '/config.php';

class DB {
    private static ?PDO $instance = null;
    private static ?string $lastError = null;

    /**
     * Retorna una instancia singleton de conexión PDO PostgreSQL
     */
    public static function getConnection(): ?PDO {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $host = DB_HOST;
        $port = DB_PORT;
        $dbname = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;

        $dsn = "pgsql:host={$host};port={$port};dbname={$dbname};options='--client_encoding=UTF8'";

        try {
            self::$instance = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 3
            ]);
            self::$lastError = null;
            return self::$instance;
        } catch (PDOException $e) {
            self::$lastError = $e->getMessage();
            return null;
        }
    }

    /**
     * Verifica si la conexión con PostgreSQL está activa
     */
    public static function isConnected(): bool {
        return self::getConnection() !== null;
    }

    /**
     * Retorna el último mensaje de error o null si no hubo fallos
     */
    public static function getLastError(): ?string {
        return self::$lastError;
    }

    /**
     * Ejecuta una consulta SELECT y retorna los registros o un arreglo vacío en caso de fallo
     */
    public static function select(string $query, array $params = []): array {
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
            return [];
        }
    }
}
