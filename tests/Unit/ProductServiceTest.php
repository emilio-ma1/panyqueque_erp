<?php
/**
 * Automated test suite for ProductService.
 *
 * Validates domain record formatting, category icons mapping, and catalog fallback.
 */

require_once __DIR__ . '/../../includes/ProductService.php';

class ProductServiceTest
{
    /**
     * Run all test cases and return assertions results.
     *
     * @return array List of assertion results.
     */
    public static function run(): array
    {
        $results = [];

        // Test 1: formatProductRecord mapping
        $raw = [
            'id'          => 42,
            'name'        => 'Pan Campesino Rústico',
            'category'    => 'Panadería Tradicional',
            'stock'       => 50,
            'price'       => 2100,
            'unit'        => 'kg',
            'description' => 'Miga alveolar y corteza dorada.',
            'active'      => true
        ];
        $formatted = ProductService::formatProductRecord($raw);

        $results[] = [
            'name'     => 'ProductService formats raw DB record with correct fields',
            'passed'   => ($formatted['id'] === 42 && $formatted['nombre'] === 'Pan Campesino Rústico' && $formatted['precio'] === 2100),
            'expected' => 'id=42, nombre=Pan Campesino Rústico, precio=2100',
            'actual'   => "id={$formatted['id']}, nombre={$formatted['nombre']}, precio={$formatted['precio']}"
        ];

        // Test 2: Icon mapping for Pastelería Fina
        $rawCake = [
            'id'       => 10,
            'name'     => 'Selva Negra',
            'category' => 'Pastelería Fina',
            'stock'    => 5,
            'price'    => 19500
        ];
        $formattedCake = ProductService::formatProductRecord($rawCake);
        $results[] = [
            'name'     => 'ProductService maps Pastelería Fina icon to 🧁',
            'passed'   => ($formattedCake['icono'] === '🧁'),
            'expected' => '🧁',
            'actual'   => $formattedCake['icono']
        ];

        // Test 3: Fallback description when null
        $rawNoDesc = [
            'id'       => 11,
            'name'     => 'Pan de Molde',
            'category' => 'Panadería',
            'price'    => 2500
        ];
        $formattedNoDesc = ProductService::formatProductRecord($rawNoDesc);
        $results[] = [
            'name'     => 'ProductService supplies default description when missing',
            'passed'   => (!empty($formattedNoDesc['descripcion'])),
            'expected' => 'Non-empty default description',
            'actual'   => $formattedNoDesc['descripcion']
        ];

        // Test 4: Default catalog returns non-empty list
        $catalog = ProductService::getActiveProducts();
        $results[] = [
            'name'     => 'ProductService returns non-empty product catalog',
            'passed'   => (is_array($catalog) && count($catalog) >= 1),
            'expected' => 'Count >= 1',
            'actual'   => 'Count: ' . count($catalog)
        ];

        return $results;
    }
}
