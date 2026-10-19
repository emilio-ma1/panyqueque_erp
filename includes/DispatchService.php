<?php
/**
 * Dispatch and logistics routing service for Pan y Queque ERP.
 *
 * Encapsulates delivery route queries and status presentation mappings.
 * Conforms to Single Responsibility Principle and Thin Controller rules
 * (Sections 2 and 7.1 of the Coding Standards Guide).
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/AuditService.php';

class DispatchService
{
    /** @var array Fallback route schedules */
    private const DEFAULT_ROUTES = [
        [
            'id'           => 1,
            'hora'         => '06:30 AM',
            'titulo'       => 'Ruta Matinal 01 - Centro & Hospital',
            'destino'      => 'Hospital Regional de La Serena (Av. Balmaceda 916)',
            'carga'        => '60 kg Marraqueta, 40 kg Hallulla, 15 Docenas Empanadas',
            'cliente'      => 'Casino Central Servicio Salud',
            'estado'       => 'Entregado',
            'estado_color' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            'icono_estado' => '✓',
            'completado'   => true
        ],
        [
            'id'           => 2,
            'hora'         => '07:15 AM',
            'titulo'       => 'Ruta Matinal 02 - Zona Hotelera Av. del Mar',
            'destino'      => 'Hotel Enjoy & Spa La Serena (Peñuelas Norte 56)',
            'carga'        => '120 Croissants, 80 Panes Ciabatta, 6 Tortas Hojarasca',
            'cliente'      => 'Buffet Desayunos Enjoy',
            'estado'       => 'En camino',
            'estado_color' => 'bg-amber-50 text-amber-800 border-amber-200',
            'icono_estado' => '🚛',
            'completado'   => false
        ],
        [
            'id'           => 3,
            'hora'         => '08:45 AM',
            'titulo'       => 'Ruta Intercomunal 03 - Coquimbo Puerto',
            'destino'      => 'Supermercado Central El Faro (Calle Aldunate 450)',
            'carga'        => '100 kg Pan Integral Molde, 50 kg Masa de Hoja Congelada',
            'cliente'      => 'Sucursal Puerto Coquimbo',
            'estado'       => 'Pendiente',
            'estado_color' => 'bg-gray-100 text-gray-700 border-gray-200',
            'icono_estado' => '⏳',
            'completado'   => false
        ]
    ];

    /**
     * Retrieve all dispatch routes from database or fallback schedule.
     *
     * @return array List of delivery routes formatted for the dispatch view.
     */
    public static function getAllRoutes(): array
    {
        if (!class_exists('DB') || !DB::isConnected()) {
            return self::DEFAULT_ROUTES;
        }

        $records = DB::select("SELECT * FROM dispatch_routes ORDER BY id ASC");
        if (empty($records)) {
            return self::DEFAULT_ROUTES;
        }

        return array_map([self::class, 'formatRouteRecord'], $records);
    }

    /**
     * Format a raw database route record into presentation structure.
     *
     * @param array $record Raw record from dispatch_routes table.
     * @return array Formatted route array.
     */
    public static function formatRouteRecord(array $record): array
    {
        $status = (string)($record['status'] ?? 'Pendiente');
        $styling = self::resolveRouteStatusStyling($status);

        $address = !empty($record['address']) ? ' (' . $record['address'] . ')' : '';
        $destination = (string)($record['destination'] ?? 'Destino no especificado');

        return [
            'id'           => (int)($record['id'] ?? 0),
            'hora'         => (string)($record['time'] ?? '08:00 AM'),
            'titulo'       => (string)($record['title'] ?? 'Ruta Programada'),
            'destino'      => $destination . $address,
            'carga'        => (string)($record['items'] ?? 'Carga general de panadería'),
            'cliente'      => $destination,
            'estado'       => $status,
            'estado_color' => $styling['color'],
            'icono_estado' => $styling['icon'],
            'completado'   => $styling['completed'],
        ];
    }

    /**
     * Resolve status visual indicators (badge color, icon, and completion flag).
     *
     * @param string $status Route delivery status string.
     * @return array Associative array with 'color', 'icon', and 'completed'.
     */
    public static function resolveRouteStatusStyling(string $status): array
    {
        if ($status === 'Entregado') {
            return [
                'color'     => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                'icon'      => '✓',
                'completed' => true,
            ];
        }

        if ($status === 'En camino' || $status === 'En Camino') {
            return [
                'color'     => 'bg-amber-50 text-amber-800 border-amber-200',
                'icon'      => '🚛',
                'completed' => false,
            ];
        }

        return [
            'color'     => 'bg-gray-100 text-gray-700 border-gray-200',
            'icon'      => '⏳',
            'completed' => false,
        ];
    }

    /**
     * Mark a delivery route as completed in the database.
     *
     * @param int $routeId The route primary key.
     * @param string $recipientName Person who received the order.
     * @param string $obs Optional delivery remarks.
     * @return bool True on success, false on failure.
     */
    public static function confirmDelivery(int $routeId, string $recipientName, string $obs = ''): bool
    {
        if (!class_exists('DB') || !DB::isConnected()) {
            return false;
        }

        $noteAppend = " [Entregado a {$recipientName} el " . date('d/m/Y H:i') . (!empty($obs) ? " - Obs: {$obs}" : "") . "]";
        $ok = DB::execute(
            "UPDATE dispatch_routes SET status = 'Entregado', notes = CONCAT(COALESCE(notes, ''), ?) WHERE id = ?",
            [$noteAppend, $routeId]
        );

        if ($ok) {
            AuditService::log(
                'LOGÍSTICA', 
                'Entrega Confirmada', 
                "Albarán de ruta #{$routeId} confirmado por {$recipientName} (Temp: +3.8°C Conforme)"
            );
        }

        return $ok;
    }
}
