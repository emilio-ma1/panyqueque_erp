<?php
/**
 * Automated test suite for formatCurrency helper function.
 *
 * Validates Chilean Peso formatting, thousands separators, and edge cases.
 */

require_once __DIR__ . '/../../includes/config.php';

class FormatCurrencyTest
{
    /**
     * Run all test cases and return assertions results.
     *
     * @return array List of assertion results.
     */
    public static function run(): array
    {
        $results = [];

        // Test 1: Standard amount formatting
        $val1 = formatCurrency(18500);
        $results[] = [
            'name'   => 'Format standard thousands amount (18500 -> $18.500)',
            'passed' => ($val1 === '$18.500'),
            'expected' => '$18.500',
            'actual' => $val1
        ];

        // Test 2: Millions amount formatting
        $val2 = formatCurrency(5470000);
        $results[] = [
            'name'   => 'Format millions amount (5470000 -> $5.470.000)',
            'passed' => ($val2 === '$5.470.000'),
            'expected' => '$5.470.000',
            'actual' => $val2
        ];

        // Test 3: Zero amount
        $val3 = formatCurrency(0);
        $results[] = [
            'name'   => 'Format zero amount (0 -> $0)',
            'passed' => ($val3 === '$0'),
            'expected' => '$0',
            'actual' => $val3
        ];

        // Test 4: Small amount under one thousand
        $val4 = formatCurrency(990);
        $results[] = [
            'name'   => 'Format amount under 1000 (990 -> $990)',
            'passed' => ($val4 === '$990'),
            'expected' => '$990',
            'actual' => $val4
        ];

        return $results;
    }
}
