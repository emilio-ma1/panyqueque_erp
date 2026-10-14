<?php
/**
 * Automated test suite for AuditService.
 *
 * Validates formatting of security and operational audit log entries.
 */

require_once __DIR__ . '/../../includes/AuditService.php';

class AuditServiceTest
{
    /**
     * Run all test cases and return assertions results.
     *
     * @return array List of assertion results.
     */
    public static function run(): array
    {
        $results = [];

        // Test 1: formatLogRecord with explicit action and detail
        $raw = [
            'id'         => 1,
            'module'     => 'POS',
            'action'     => 'VENTA_REGISTRADA',
            'detail'     => 'Boleta #004892 emitida por $18.500 CLP.',
            'created_at' => '2026-10-14 08:30:15'
        ];
        $formatted = AuditService::formatLogRecord($raw);

        $results[] = [
            'name'     => 'AuditService formats action and detail into combined string',
            'passed'   => (str_contains($formatted['detail'], 'VENTA_REGISTRADA: Boleta #004892') && $formatted['module'] === 'POS'),
            'expected' => 'detail contains action + detail, module=POS',
            'actual'   => "module={$formatted['module']}, detail={$formatted['detail']}"
        ];

        // Test 2: Time extraction from timestamp
        $results[] = [
            'name'     => 'AuditService extracts H:i:s time from created_at timestamp',
            'passed'   => ($formatted['time'] === '08:30:15'),
            'expected' => '08:30:15',
            'actual'   => $formatted['time']
        ];

        // Test 3: getRecentLogs returns default list when DB is unreachable
        $logs = AuditService::getRecentLogs(3);
        $results[] = [
            'name'     => 'AuditService returns non-empty recent logs',
            'passed'   => (is_array($logs) && count($logs) >= 1),
            'expected' => 'Count >= 1',
            'actual'   => 'Count: ' . count($logs)
        ];

        return $results;
    }
}
