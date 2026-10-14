<?php
/**
 * Product catalog service for the Pan y Queque ERP.
 *
 * Encapsulates data access and formatting logic for bakery and pastry
 * products, decoupling the Presentation Layer (POS) from database details.
 * Conforms to Single Responsibility Principle and Thin Controller rules
 * (Sections 2 and 7.1 of the Coding Standards Guide).
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

class ProductService
{
    /** @var array<string, string> Fallback category icons */
    private const CATEGORY_ICONS = [
        'Panadería'             => '🥖',
        'Panadería Tradicional' => '🥖',
        'Pastelería'            => '🎂',
        'Pastelería Fina'       => '🧁',
        'Rotisería'             => '🥟',
        'Bollería Caliente'     => '🥟',
    ];

    /** @var array Default fallback catalog when database is unreachable */
    private const DEFAULT_PRODUCTS = [
        [
            'id'          => 1,
            'nombre'      => 'Pan Marraqueta de Masa Madre',
            'categoria'   => 'Panadería Tradicional',
            'stock'       => 145,
            'precio'      => 1890,
            'unidad'      => 'kg',
            'icono'       => '🥖',
            'descripcion' => 'Crujiente, horneada 3 veces al día en horno chileno a leña.'
        ],
        [
            'id'          => 2,
            'nombre'      => 'Pan Hallulla Especial',
            'categoria'   => 'Panadería Tradicional',
            'stock'       => 82,
            'precio'      => 1890,
            'unidad'      => 'kg',
            'icono'       => '🥖',
            'descripcion' => 'Masa suave con manteca vegetal de primera calidad.'
        ],
        [
            'id'          => 3,
            'nombre'      => 'Torta Hojarasca Manjar Lúcuma',
            'categoria'   => 'Pastelería Fina',
            'stock'       => 8,
            'precio'      => 18500,
            'unidad'      => 'unid',
            'icono'       => '🎂',
            'descripcion' => '15 porciones con manjar de campo artesanal y crema lúcuma.'
        ],
        [
            'id'          => 4,
            'nombre'      => 'Empanadas de Pino al Horno',
            'categoria'   => 'Rotisería',
            'stock'       => 28,
            'precio'      => 2400,
            'unidad'      => 'unid',
            'icono'       => '🥟',
            'descripcion' => 'Carne picada de vacuno, cebolla caramelizada, huevo y aceituna.'
        ],
        [
            'id'          => 5,
            'nombre'      => 'Pasteles Surtidos de Vitrina',
            'categoria'   => 'Pastelería Fina',
            'stock'       => 45,
            'precio'      => 1650,
            'unidad'      => 'unid',
            'icono'       => '🧁',
            'descripcion' => 'Milhojas, tartas de frutas frescas, profiteroles y volcanes.'
        ],
        [
            'id'          => 6,
            'nombre'      => 'Croissant de Mantequilla',
            'categoria'   => 'Bollería Caliente',
            'stock'       => 18,
            'precio'      => 1450,
            'unidad'      => 'unid',
            'icono'       => '🥐',
            'descripcion' => '100% mantequilla de lechería sureña, fermentado 24 horas.'
        ]
    ];

    /**
     * Retrieve active products from database, falling back to default sample items.
     *
     * @return array List of product arrays formatted for the POS catalog.
     */
    public static function getActiveProducts(): array
    {
        if (!class_exists('DB')) {
            return self::DEFAULT_PRODUCTS;
        }

        $records = DB::select("SELECT * FROM products WHERE active = TRUE ORDER BY id ASC");
        if (empty($records)) {
            return self::DEFAULT_PRODUCTS;
        }

        return array_map([self::class, 'formatProductRecord'], $records);
    }

    /**
     * Map a raw database record to POS view domain structure.
     *
     * @param array $record Raw associative record from products table.
     * @return array Formatted product array for catalog rendering.
     */
    public static function formatProductRecord(array $record): array
    {
        $category = (string)($record['category'] ?? 'Panadería');
        $icon = self::CATEGORY_ICONS[$category] ?? '🍞';

        return [
            'id'          => (int)($record['id'] ?? 0),
            'nombre'      => (string)($record['name'] ?? ''),
            'descripcion' => (string)($record['description'] ?? 'Elaborado en obrador artesanal'),
            'unidad'      => (string)($record['unit'] ?? 'un'),
            'precio'      => (int)($record['price'] ?? 0),
            'icono'       => $icon,
            'stock'       => (int)($record['stock'] ?? 0),
            'categoria'   => $category,
        ];
    }
}
