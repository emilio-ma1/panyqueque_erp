<?php
/**
 * Supplier management and procurement service for Pan y Queque ERP.
 *
 * Encapsulates supplier queries, status styling logic, and financial metrics.
 * Conforms to Single Responsibility Principle and Thin Controller rules
 * (Sections 2 and 7.1 of the Coding Standards Guide).
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

class SupplierService
{
    /** @var array Fallback suppliers when database is unavailable */
    private const DEFAULT_SUPPLIERS = [
        [
            'id'            => 1,
            'nombre'        => 'Molino La Estampa S.A.',
            'rubro'         => 'Harina Especial Flor (Sacos 50kg)',
            'rut'           => '96.541.230-4',
            'ultima_compra' => '12/10/2026',
            'monto'         => 1850000,
            'estado'        => 'Al día',
            'badge'         => 'bg-emerald-50 text-emerald-800 border-emerald-200'
        ],
        [
            'id'            => 2,
            'nombre'        => 'Levaduras & Mejoradores del Sur',
            'rubro'         => 'Levadura Fresca Prensada (Cajas 10kg)',
            'rut'           => '78.982.110-K',
            'ultima_compra' => '08/10/2026',
            'monto'         => 420000,
            'estado'        => 'Al día',
            'badge'         => 'bg-emerald-50 text-emerald-800 border-emerald-200'
        ],
        [
            'id'            => 3,
            'nombre'        => 'Lácteos & Mantecas San Pedro',
            'rubro'         => 'Mantequilla 82% MG y Manteca Hojaldre',
            'rut'           => '81.234.567-8',
            'ultima_compra' => '14/10/2026',
            'monto'         => 680000,
            'estado'        => 'Pendiente',
            'badge'         => 'bg-amber-50 text-amber-800 border-amber-200'
        ],
        [
            'id'            => 4,
            'nombre'        => 'Envases Bio-Degradables Chile',
            'rubro'         => 'Bolsas Kraft de Papel y Cajas para Torta',
            'rut'           => '76.890.123-5',
            'ultima_compra' => '02/10/2026',
            'monto'         => 320000,
            'estado'        => 'En proceso',
            'badge'         => 'bg-sky-50 text-sky-800 border-sky-200'
        ],
        [
            'id'            => 5,
            'nombre'        => 'Distribuidora Huevo Granja Real',
            'rubro'         => 'Bandejas Huevo Fresco Primera (30 un)',
            'rut'           => '85.678.901-2',
            'ultima_compra' => '11/10/2026',
            'monto'         => 180000,
            'estado'        => 'Al día',
            'badge'         => 'bg-emerald-50 text-emerald-800 border-emerald-200'
        ]
    ];

    /**
     * Retrieve all suppliers from database or default list.
     *
     * @return array List of formatted supplier domain records.
     */
    public static function getAllSuppliers(): array
    {
        if (!class_exists('DB')) {
            return self::DEFAULT_SUPPLIERS;
        }

        $records = DB::select("SELECT * FROM suppliers ORDER BY id ASC");
        if (empty($records)) {
            return self::DEFAULT_SUPPLIERS;
        }

        return array_map([self::class, 'formatSupplierRecord'], $records);
    }

    /**
     * Format a raw database supplier record into presentation-ready domain structure.
     *
     * @param array $record Raw record from PostgreSQL suppliers table.
     * @return array Domain-formatted supplier array.
     */
    public static function formatSupplierRecord(array $record): array
    {
        $status = (string)($record['status'] ?? 'Al día');
        $badgeClass = self::resolveStatusBadge($status);

        $lastDate = !empty($record['last_purchase_date'])
            ? date('d/m/Y', strtotime($record['last_purchase_date']))
            : '10/10/2026';

        return [
            'id'            => (int)($record['id'] ?? 0),
            'nombre'        => (string)($record['name'] ?? ''),
            'rubro'         => (string)($record['category'] ?? 'Materia prima artesanal'),
            'rut'           => (string)($record['rut'] ?? ''),
            'ultima_compra' => $lastDate,
            'monto'         => (int)($record['purchase_amount'] ?? 0),
            'estado'        => ($status === 'Al día') ? 'Pagado' : $status,
            'badge'         => $badgeClass,
        ];
    }

    /**
     * Resolve badge styling for supplier payment status.
     *
     * @param string $status Payment status string.
     * @return string CSS class string for badge styling.
     */
    public static function resolveStatusBadge(string $status): string
    {
        if ($status === 'Pendiente') {
            return 'bg-amber-50 text-amber-800 border-amber-200';
        }

        if ($status === 'En proceso' || $status === 'En Proceso') {
            return 'bg-sky-50 text-sky-800 border-sky-200';
        }

        return 'bg-emerald-50 text-emerald-800 border-emerald-200';
    }

    /**
     * Return key financial summary metrics for the procurement dashboard.
     *
     * @return array Associative array with accountsPayable, accountsReceivable, and generalBalance.
     */
    public static function getFinancialMetrics(): array
    {
        return [
            'accountsPayable'    => 1000000,
            'accountsReceivable' => 8920000,
            'generalBalance'     => 5470000,
        ];
    }
}
