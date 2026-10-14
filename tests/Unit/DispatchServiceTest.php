<?php
/**
 * Automated test suite for DispatchService.
 *
 * Validates route styling, icon resolution, and delivery data formatting.
 */

require_once __DIR__ . '/../../includes/DispatchService.php';

class DispatchServiceTest
{
    /**
     * Run all test cases and return assertions results.
     *
     * @return array List of assertion results.
     */
    public static function run(): array
    {
        $results = [];

        // Test 1: Resolve route status styling for Entregado
        $styleDelivered = DispatchService::resolveRouteStatusStyling('Entregado');
        $results[] = [
            'name'     => 'DispatchService resolves Entregado to completed=true and checkmark',
            'passed'   => ($styleDelivered['completed'] === true && $styleDelivered['icon'] === '✓'),
            'expected' => 'completed=true, icon=✓',
            'actual'   => "completed=" . json_encode($styleDelivered['completed']) . ", icon={$styleDelivered['icon']}"
        ];

        // Test 2: Resolve route status styling for En camino
        $styleEnRoute = DispatchService::resolveRouteStatusStyling('En camino');
        $results[] = [
            'name'     => 'DispatchService resolves En camino to truck icon',
            'passed'   => ($styleEnRoute['completed'] === false && $styleEnRoute['icon'] === '🚛'),
            'expected' => 'completed=false, icon=🚛',
            'actual'   => "completed=" . json_encode($styleEnRoute['completed']) . ", icon={$styleEnRoute['icon']}"
        ];

        // Test 3: Resolve route status styling for Pendiente
        $stylePending = DispatchService::resolveRouteStatusStyling('Pendiente');
        $results[] = [
            'name'     => 'DispatchService resolves Pendiente to hourglass icon',
            'passed'   => ($stylePending['completed'] === false && $stylePending['icon'] === '⏳'),
            'expected' => 'completed=false, icon=⏳',
            'actual'   => "completed=" . json_encode($stylePending['completed']) . ", icon={$stylePending['icon']}"
        ];

        // Test 4: formatRouteRecord maps database row
        $raw = [
            'id'          => 15,
            'time'        => '09:00 AM',
            'title'       => 'Ruta Norte 05',
            'destination' => 'Clínica Elqui',
            'address'     => 'Av. Balmaceda 120',
            'items'       => '30 kg Pan Marraqueta',
            'status'      => 'Entregado'
        ];
        $formatted = DispatchService::formatRouteRecord($raw);
        $results[] = [
            'name'     => 'DispatchService formats route record including address concatenation',
            'passed'   => ($formatted['hora'] === '09:00 AM' && str_contains($formatted['destino'], 'Av. Balmaceda 120') && $formatted['completado'] === true),
            'expected' => 'hora=09:00 AM, destination contains address, completed=true',
            'actual'   => "hora={$formatted['hora']}, destino={$formatted['destino']}, completado=" . json_encode($formatted['completado'])
        ];

        return $results;
    }
}
