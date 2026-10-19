<?php
/**
 * System audit and event logging service for Pan y Queque ERP.
 *
 * Encapsulates access to security and operational audit logs for dashboard display.
 * Conforms to Single Responsibility Principle and Thin Controller rules
 * (Sections 2 and 7.1 of the Coding Standards Guide).
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

class AuditService
{
    /** @var array Default sample logs for dashboard display when DB is empty */
    private const DEFAULT_LOGS = [
        [
            'time'   => '08:15:00',
            'module' => 'POS',
            'detail' => 'Venta registrada en Mostrador 1: Boleta electrónica #004892 emitida por $18.500 CLP.'
        ],
        [
            'time'   => '08:03:00',
            'module' => 'LOGÍSTICA',
            'detail' => 'Despacho de 50 kg marraqueta confirmado en Supermercado Central.'
        ],
        [
            'time'   => '07:40:00',
            'module' => 'PROVEEDORES',
            'detail' => 'Orden de compra por 500 kg de harina generada para Harina Los Andes S.A.'
        ]
    ];

    /**
     * Insert a new entry into the audit_logs table.
     *
     * @param string $module Module name (e.g. 'POS', 'Seguridad', 'Logística').
     * @param string $action Action description (e.g. 'Venta emitida', 'Inicio de sesión').
     * @param string $detail Technical and descriptive event detail.
     * @return bool True on success, false on failure.
     */
    public static function log(string $module, string $action, string $detail): bool
    {
        if (!class_exists('DB') || !DB::isConnected()) {
            return false;
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        return DB::execute(
            "INSERT INTO audit_logs (module, action, detail, source_ip) VALUES (?, ?, ?, ?)",
            [$module, $action, $detail, $ip]
        );
    }

    /**
     * Retrieve recent system audit logs.
     *
     * @param int $limit Maximum number of log records to return.
     * @return array List of formatted audit log entries.
     */
    public static function getRecentLogs(int $limit = 4): array
    {
        if (!class_exists('DB') || !DB::isConnected()) {
            return self::DEFAULT_LOGS;
        }

        $records = DB::select("SELECT * FROM audit_logs ORDER BY id DESC LIMIT " . (int)$limit);
        if (empty($records)) {
            return self::DEFAULT_LOGS;
        }

        return array_map([self::class, 'formatLogRecord'], $records);
    }

    /**
     * Format a raw database audit record for display.
     *
     * @param array $record Raw record from audit_logs table.
     * @return array Formatted log entry.
     */
    public static function formatLogRecord(array $record): array
    {
        $logTime = !empty($record['created_at'])
            ? date('H:i:s', strtotime($record['created_at']))
            : date('H:i:s');

        $action = (string)($record['action'] ?? '');
        $detail = (string)($record['detail'] ?? '');
        $fullDetail = !empty($action) ? "{$action}: {$detail}" : $detail;

        return [
            'time'   => $logTime,
            'module' => (string)($record['module'] ?? 'SISTEMA'),
            'detail' => $fullDetail,
        ];
    }
}
