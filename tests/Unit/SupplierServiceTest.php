<?php
/**
 * Automated test suite for SupplierService.
 *
 * Validates status badge resolution, supplier mapping, and financial metrics.
 */

require_once __DIR__ . '/../../includes/SupplierService.php';

class SupplierServiceTest
{
    /**
     * Run all test cases and return assertions results.
     *
     * @return array List of assertion results.
     */
    public static function run(): array
    {
        $results = [];

        // Test 1: Resolve status badge for Pendiente
        $badgePending = SupplierService::resolveStatusBadge('Pendiente');
        $results[] = [
            'name'     => 'SupplierService resolves Pendiente status to amber badge',
            'passed'   => (str_contains($badgePending, 'amber')),
            'expected' => 'Contains amber',
            'actual'   => $badgePending
        ];

        // Test 2: Resolve status badge for En proceso
        $badgeInProcess = SupplierService::resolveStatusBadge('En proceso');
        $results[] = [
            'name'     => 'SupplierService resolves En proceso status to sky badge',
            'passed'   => (str_contains($badgeInProcess, 'sky')),
            'expected' => 'Contains sky',
            'actual'   => $badgeInProcess
        ];

        // Test 3: Resolve default status badge (Al día / Pagado)
        $badgePaid = SupplierService::resolveStatusBadge('Al día');
        $results[] = [
            'name'     => 'SupplierService resolves default status to emerald badge',
            'passed'   => (str_contains($badgePaid, 'emerald')),
            'expected' => 'Contains emerald',
            'actual'   => $badgePaid
        ];

        // Test 4: Financial metrics structure
        $metrics = SupplierService::getFinancialMetrics();
        $hasKeys = isset($metrics['accountsPayable'], $metrics['accountsReceivable'], $metrics['generalBalance']);
        $results[] = [
            'name'     => 'SupplierService returns valid financial metrics array',
            'passed'   => $hasKeys && ($metrics['generalBalance'] > 0),
            'expected' => 'Keys present and balance > 0',
            'actual'   => 'Keys: ' . implode(', ', array_keys($metrics))
        ];

        // Test 5: formatSupplierRecord maps database row
        $raw = [
            'id'                 => 7,
            'name'               => 'Molino Central',
            'rut'                => '76.123.456-7',
            'category'           => 'Harinas',
            'status'             => 'Pendiente',
            'purchase_amount'    => 540000,
            'last_purchase_date' => '2026-10-01'
        ];
        $formatted = SupplierService::formatSupplierRecord($raw);
        $results[] = [
            'name'     => 'SupplierService formats supplier record correctly',
            'passed'   => ($formatted['nombre'] === 'Molino Central' && $formatted['monto'] === 540000 && $formatted['estado'] === 'Pendiente'),
            'expected' => 'nombre=Molino Central, monto=540000, estado=Pendiente',
            'actual'   => "nombre={$formatted['nombre']}, monto={$formatted['monto']}, estado={$formatted['estado']}"
        ];

        return $results;
    }
}
