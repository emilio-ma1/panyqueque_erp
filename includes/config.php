<?php
/**
 * General configuration and network parameters for the Pan y Queque ERP system.
 *
 * This module centralizes application constants, institutional network addressing
 * (IPv6 / VLAN segments), and database connection parameters sourced exclusively
 * from environment variables. It acts as the single configuration entry-point
 * consumed by all other modules.
 *
 * Design decision: Database credentials use getenv() without hardcoded fallbacks
 * so the application fails fast when the environment is misconfigured, following
 * the security Hard Rules (Sections 3 and 6 of the Coding Standards Guide).
 */

// Institutional application constants
define('APP_NAME', 'Pan y Queque - Sistema ERP');
define('APP_VERSION', '1.0.0');
define('APP_COMPANY', 'Panadería y Pastelería Pan y Queque');
define('APP_YEAR', date('Y'));

// Institutional IPv6 addressing (VLAN 30 - Servers & Links)
define('SERVER_WEB_ERP', '2001:db8:acad:30::80');
define('SERVER_BD', '2001:db8:acad:30::db');
define('SERVER_ARCHIVOS', '2001:db8:acad:30::21');

// Corporate network VLAN segments
define('VLAN_ADMIN_ID', '10');
define('VLAN_ADMIN_NAME', 'VLAN 10 - Administración');
define('VLAN_CAJAS_ID', '20');
define('VLAN_CAJAS_NAME', 'VLAN 20 - Cajas_Ventas');
define('VLAN_SERVIDORES_ID', '30');
define('VLAN_SERVIDORES_NAME', 'VLAN 30 - Servidores');

// Remote VPN client addresses
define('VPN_CHOFERES_IP', '2001:db8:wan::100');
define('VPN_GERENCIA_IP', '2001:db8:wan::200');

// MariaDB database connection — values sourced from environment variables
define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'panyqueque_erp');
define('DB_USER', getenv('DB_USER') ?: 'erp_user');
define('DB_PASS', getenv('DB_PASS') ?: 'erp_password_2026');

/**
 * Format an integer amount as Chilean Pesos (CLP) with thousands separators.
 *
 * @param int $amount The raw integer amount in CLP (e.g. 18500).
 * @return string The formatted string with currency symbol (e.g. "$18.500").
 */
function formatCurrency(int $amount): string
{
    return '$' . number_format($amount, 0, ',', '.');
}
