<?php
/**
 * ==============================================================================
 * Panadería y Pastelería Pan y Queque - Sistema ERP
 * Archivo de Configuración General y Parámetros de Red
 * ==============================================================================
 */

// Constantes institucionales requeridas
define('APP_NAME', 'Pan y Queque - Sistema ERP');
define('APP_VERSION', '1.0.0');
define('APP_COMPANY', 'Panadería y Pastelería Pan y Queque');
define('APP_YEAR', date('Y'));

// Direccionamiento IPv6 institucional (VLAN 30 - Servidores y Enlaces)
define('SERVER_WEB_ERP', '2001:db8:acad:30::80');
define('SERVER_BD', '2001:db8:acad:30::db');
define('SERVER_ARCHIVOS', '2001:db8:acad:30::21');

// Segmentos y VLANs de red corporativa
define('VLAN_ADMIN_ID', '10');
define('VLAN_ADMIN_NAME', 'VLAN 10 - Administración');
define('VLAN_CAJAS_ID', '20');
define('VLAN_CAJAS_NAME', 'VLAN 20 - Cajas_Ventas');
define('VLAN_SERVIDORES_ID', '30');
define('VLAN_SERVIDORES_NAME', 'VLAN 30 - Servidores');

// Direcciones VPN de clientes remotos
define('VPN_CHOFERES_IP', '2001:db8:wan::100');
define('VPN_GERENCIA_IP', '2001:db8:wan::200');

// Configuración de Base de Datos PostgreSQL
define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_PORT', getenv('DB_PORT') ?: '5432');
define('DB_NAME', getenv('DB_NAME') ?: 'panyqueque_erp');
define('DB_USER', getenv('DB_USER') ?: 'erp_user');
define('DB_PASS', getenv('DB_PASS') ?: 'erp_password_2026');

/**
 * Función auxiliar para formateo monetario en pesos chilenos (CLP)
 */
function formatoPesos($monto) {
    return '$' . number_format($monto, 0, ',', '.');
}
