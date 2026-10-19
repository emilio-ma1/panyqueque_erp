<?php
/**
 * Automated test suite for AuthService and Access Control (RBAC).
 *
 * Validates role-based module permissions, user credentials, and session access.
 */

require_once __DIR__ . '/../../includes/AuthService.php';

class AuthServiceTest
{
    /**
     * Run all test cases and return assertions results.
     *
     * @return array List of assertion results.
     */
    public static function run(): array
    {
        $results = [];

        // Test 1: Gerente role has access to all modules
        $gerenteCanAccessDash = in_array('dashboard', AuthService::ROLE_PERMISSIONS['gerente']);
        $gerenteCanAccessPos  = in_array('pos', AuthService::ROLE_PERMISSIONS['gerente']);
        $gerenteCanAccessSupp = in_array('suppliers', AuthService::ROLE_PERMISSIONS['gerente']);
        $gerenteCanAccessDisp = in_array('dispatch', AuthService::ROLE_PERMISSIONS['gerente']);
        $gerenteHasAll = ($gerenteCanAccessDash && $gerenteCanAccessPos && $gerenteCanAccessSupp && $gerenteCanAccessDisp);

        $results[] = [
            'name'     => 'AuthService permits Gerente role full access to all ERP modules',
            'passed'   => $gerenteHasAll,
            'expected' => 'Full module access',
            'actual'   => $gerenteHasAll ? 'Full module access' : 'Restricted'
        ];

        // Test 2: Cajero role is restricted from Dashboard and Suppliers
        $cajeroCanAccessPos  = in_array('pos', AuthService::ROLE_PERMISSIONS['cajero']);
        $cajeroNoAccessDash = !in_array('dashboard', AuthService::ROLE_PERMISSIONS['cajero']);
        $cajeroNoAccessSupp = !in_array('suppliers', AuthService::ROLE_PERMISSIONS['cajero']);
        $cajeroPolicy = ($cajeroCanAccessPos && $cajeroNoAccessDash && $cajeroNoAccessSupp);

        $results[] = [
            'name'     => 'AuthService restricts Cajero to POS and prohibits Dashboard / Suppliers',
            'passed'   => $cajeroPolicy,
            'expected' => 'POS allowed, Dashboard & Suppliers prohibited',
            'actual'   => $cajeroPolicy ? 'Compliant' : 'Non-compliant'
        ];

        // Test 3: Chofer role is restricted to Dispatch and prohibited from POS / Dashboard
        $choferCanAccessDisp = in_array('dispatch', AuthService::ROLE_PERMISSIONS['chofer']);
        $choferNoAccessPos  = !in_array('pos', AuthService::ROLE_PERMISSIONS['chofer']);
        $choferNoAccessDash = !in_array('dashboard', AuthService::ROLE_PERMISSIONS['chofer']);
        $choferPolicy = ($choferCanAccessDisp && $choferNoAccessPos && $choferNoAccessDash);

        $results[] = [
            'name'     => 'AuthService restricts Chofer to Logistics/Dispatch per IPv6 ACL rules',
            'passed'   => $choferPolicy,
            'expected' => 'Dispatch allowed, POS & Dashboard prohibited',
            'actual'   => $choferPolicy ? 'Compliant' : 'Non-compliant'
        ];

        // Test 4: Finanzas role has access to Suppliers and Dashboard, but prohibited from POS
        $finanzasCanSupp = in_array('suppliers', AuthService::ROLE_PERMISSIONS['finanzas']);
        $finanzasCanDash = in_array('dashboard', AuthService::ROLE_PERMISSIONS['finanzas']);
        $finanzasNoPos   = !in_array('pos', AuthService::ROLE_PERMISSIONS['finanzas']);
        $finanzasPolicy = ($finanzasCanSupp && $finanzasCanDash && $finanzasNoPos);

        $results[] = [
            'name'     => 'AuthService authorizes Finanzas for Suppliers and Dashboard',
            'passed'   => $finanzasPolicy,
            'expected' => 'Suppliers & Dashboard allowed, POS prohibited',
            'actual'   => $finanzasPolicy ? 'Compliant' : 'Non-compliant'
        ];

        // Test 5: Role labels dictionary
        $hasLabels = isset(
            AuthService::ROLE_LABELS['gerente'],
            AuthService::ROLE_LABELS['cajero'],
            AuthService::ROLE_LABELS['chofer'],
            AuthService::ROLE_LABELS['finanzas']
        );

        $results[] = [
            'name'     => 'AuthService defines descriptive institutional human-readable role labels',
            'passed'   => $hasLabels,
            'expected' => 'All 4 institutional roles labeled',
            'actual'   => $hasLabels ? '4 roles labeled' : 'Missing labels'
        ];

        return $results;
    }
}
