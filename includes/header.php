<?php
/**
 * Common header and navigation bar for the Pan y Queque ERP.
 *
 * Implements the Atelier Architectural ERP design system:
 * - Opaque solid navigation (Zero-Glass Policy)
 * - Rectilinear architectural geometry (Zero-Pill Doctrine)
 * - Inter typography and JetBrains Mono for metrics and codes
 * - Google Material Symbols Outlined icons
 * Derived from templates in Plantilla/stitch_bakery_erp_system/
 */
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/config.php';
}
require_once __DIR__ . '/db.php';

$currentPage = $currentPage ?? 'inicio';
$pageTitle = $pageTitle ?? APP_NAME;
$isDarkTheme = ($currentPage === 'dashboard');
$dbConnected = DB::isConnected();
?>
<!DOCTYPE html>
<html lang="es" class="<?php echo $isDarkTheme ? 'h-full bg-zinc-950 dark' : 'h-full bg-slate-100'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle . ' | ' . APP_COMPANY); ?></title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Google Fonts: Inter, JetBrains Mono & Material Symbols Outlined -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="<?php echo $isDarkTheme ? 'min-h-full flex flex-col bg-zinc-950 text-zinc-100 antialiased selection:bg-amber-600 selection:text-white dark-theme' : 'min-h-full flex flex-col bg-slate-100 text-slate-900 antialiased selection:bg-slate-900 selection:text-white'; ?>">

    <!-- ====================================================================== -->
    <!-- 1. HEADER DEL ERP (SÓLIDO 100%, SIN BLUR NI TRANSPARENCIAS)            -->
    <!-- ====================================================================== -->
    <header class="<?php echo $isDarkTheme ? 'bg-zinc-900 border-b border-zinc-800 text-white' : 'bg-slate-900 border-b border-slate-800 text-white'; ?> shrink-0 sticky top-0 z-50">
        <div class="w-full px-4 sm:px-6 flex items-center justify-between h-16">
            
            <!-- Logo y Razón Social Corporativa -->
            <div class="flex items-center space-x-6">
                <a href="index.php" class="flex items-center space-x-3 group">
                    <div class="w-9 h-9 <?php echo $isDarkTheme ? 'bg-amber-600 text-white' : 'bg-amber-700 text-white'; ?> flex items-center justify-center font-bold text-lg rounded-none transition-none">
                        PQ
                    </div>
                    <div>
                        <div class="text-sm font-bold tracking-tight text-white leading-tight uppercase">Pan y Queque</div>
                        <div class="text-[11px] <?php echo $isDarkTheme ? 'text-zinc-400' : 'text-slate-400'; ?> font-mono">ERP OBRADOR V4.8</div>
                    </div>
                </a>

                <div class="h-6 w-px <?php echo $isDarkTheme ? 'bg-zinc-800' : 'bg-slate-800'; ?> hidden md:block"></div>

                <!-- Metadatos de Producción -->
                <div class="hidden xl:flex items-center space-x-2 text-xs font-mono <?php echo $isDarkTheme ? 'text-zinc-300' : 'text-slate-300'; ?>">
                    <span class="w-2 h-2 bg-emerald-500 rounded-none inline-block"></span>
                    <span class="font-semibold text-slate-200">PLANTA CENTRAL #01</span>
                    <span class="<?php echo $isDarkTheme ? 'text-zinc-600' : 'text-slate-600'; ?>">|</span>
                    <span>TURNO MATUTINO (04:00 - 13:00)</span>
                    <span class="<?php echo $isDarkTheme ? 'text-zinc-600' : 'text-slate-600'; ?>">|</span>
                    <span class="<?php echo $dbConnected ? 'text-emerald-400 font-semibold' : 'text-amber-400 font-semibold'; ?>">
                        <?php echo $dbConnected ? 'POSTGRESQL 15 ACTIVO' : 'MODO LOCAL ACTIVO'; ?>
                    </span>
                </div>
            </div>

            <!-- Navegación de 5 Pestañas Rectangulares (Zero-Pill) -->
            <nav class="hidden lg:flex items-center space-x-1" id="nav-tabs">
                <!-- 1. Inicio -->
                <a href="index.php" class="px-3.5 py-2 text-xs font-semibold uppercase tracking-wider rounded-none transition-none <?php
                    echo ($currentPage === 'inicio' || $currentPage === 'index')
                        ? ($isDarkTheme ? 'text-white bg-zinc-800 border-b-2 border-amber-500' : 'text-white bg-slate-800 border-b-2 border-amber-600')
                        : ($isDarkTheme ? 'text-zinc-400 hover:text-white hover:bg-zinc-800/80 border-b-2 border-transparent' : 'text-slate-300 hover:text-white hover:bg-slate-800 border-b-2 border-transparent');
                ?>">
                    1. Inicio &amp; Catálogo
                </a>

                <!-- 2. POS -->
                <a href="pos.php" class="px-3.5 py-2 text-xs font-semibold uppercase tracking-wider rounded-none transition-none <?php
                    echo ($currentPage === 'pos' || $currentPage === 'caja')
                        ? ($isDarkTheme ? 'text-white bg-zinc-800 border-b-2 border-amber-500' : 'text-white bg-slate-800 border-b-2 border-amber-600')
                        : ($isDarkTheme ? 'text-zinc-400 hover:text-white hover:bg-zinc-800/80 border-b-2 border-transparent' : 'text-slate-300 hover:text-white hover:bg-slate-800 border-b-2 border-transparent');
                ?>">
                    2. Punto de Venta (POS)
                </a>

                <!-- 3. Proveedores -->
                <a href="suppliers.php" class="px-3.5 py-2 text-xs font-semibold uppercase tracking-wider rounded-none transition-none <?php
                    echo ($currentPage === 'suppliers' || $currentPage === 'proveedores')
                        ? ($isDarkTheme ? 'text-white bg-zinc-800 border-b-2 border-amber-500' : 'text-white bg-slate-800 border-b-2 border-amber-600')
                        : ($isDarkTheme ? 'text-zinc-400 hover:text-white hover:bg-zinc-800/80 border-b-2 border-transparent' : 'text-slate-300 hover:text-white hover:bg-slate-800 border-b-2 border-transparent');
                ?>">
                    3. Proveedores &amp; Finanzas
                </a>

                <!-- 4. Logística -->
                <a href="dispatch.php" class="px-3.5 py-2 text-xs font-semibold uppercase tracking-wider rounded-none transition-none <?php
                    echo ($currentPage === 'dispatch' || $currentPage === 'reparto')
                        ? ($isDarkTheme ? 'text-white bg-zinc-800 border-b-2 border-amber-500' : 'text-white bg-slate-800 border-b-2 border-amber-600')
                        : ($isDarkTheme ? 'text-zinc-400 hover:text-white hover:bg-zinc-800/80 border-b-2 border-transparent' : 'text-slate-300 hover:text-white hover:bg-slate-800 border-b-2 border-transparent');
                ?>">
                    4. Logística &amp; Rutas
                </a>

                <!-- 5. Dashboard VIP -->
                <a href="dashboard.php" class="px-3.5 py-2 text-xs font-semibold uppercase tracking-wider rounded-none transition-none <?php
                    echo ($currentPage === 'dashboard')
                        ? 'text-amber-400 bg-zinc-800 border-b-2 border-amber-500 font-bold'
                        : ($isDarkTheme ? 'text-amber-400 hover:text-amber-300 hover:bg-zinc-800/80 border-b-2 border-transparent' : 'text-amber-400 hover:text-amber-300 hover:bg-slate-800 border-b-2 border-transparent');
                ?>">
                    5. Dashboard Ejecutivo [VIP]
                </a>
            </nav>

            <!-- Panel de Usuario y Estado -->
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <div class="text-xs font-semibold <?php echo $isDarkTheme ? 'text-zinc-200' : 'text-slate-200'; ?>">Ing. M. Valenzuela</div>
                    <div class="text-[11px] font-mono <?php echo $isDarkTheme ? 'text-amber-400' : 'text-slate-400'; ?>">
                        <?php echo ($currentPage === 'dashboard') ? '[Director General]' : 'ID: OBR-9402'; ?>
                    </div>
                </div>
                <div class="w-9 h-9 <?php echo $isDarkTheme ? 'bg-zinc-800 border border-zinc-700 text-zinc-200' : 'bg-slate-800 border border-slate-700 text-slate-300'; ?> flex items-center justify-center text-xs font-bold font-mono rounded-none">
                    MV
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" type="button" class="lg:hidden p-2 text-white hover:bg-slate-800 rounded-none focus:outline-none" aria-label="Abrir menú">
                    <span class="material-symbols-outlined text-xl" id="menu-icon-open">menu</span>
                    <span class="material-symbols-outlined text-xl hidden" id="menu-icon-close">close</span>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown Menu (Solid rectangular) -->
        <div id="mobile-menu" class="hidden lg:hidden <?php echo $isDarkTheme ? 'bg-zinc-900 border-t border-zinc-800 text-zinc-200' : 'bg-slate-900 border-t border-slate-800 text-slate-200'; ?> px-4 py-3 space-y-1 text-xs uppercase font-mono">
            <a href="index.php" class="block py-2.5 px-3 <?php echo ($currentPage === 'inicio') ? 'bg-slate-800 text-white font-bold' : 'hover:bg-slate-800'; ?> rounded-none">
                1. Inicio &amp; Catálogo
            </a>
            <a href="pos.php" class="block py-2.5 px-3 <?php echo ($currentPage === 'pos') ? 'bg-slate-800 text-white font-bold' : 'hover:bg-slate-800'; ?> rounded-none">
                2. Punto de Venta (POS)
            </a>
            <a href="suppliers.php" class="block py-2.5 px-3 <?php echo ($currentPage === 'suppliers') ? 'bg-slate-800 text-white font-bold' : 'hover:bg-slate-800'; ?> rounded-none">
                3. Proveedores &amp; Finanzas
            </a>
            <a href="dispatch.php" class="block py-2.5 px-3 <?php echo ($currentPage === 'dispatch') ? 'bg-slate-800 text-white font-bold' : 'hover:bg-slate-800'; ?> rounded-none">
                4. Logística &amp; Rutas
            </a>
            <a href="dashboard.php" class="block py-2.5 px-3 text-amber-400 font-bold hover:bg-slate-800 rounded-none">
                5. Dashboard Ejecutivo [VIP]
            </a>
        </div>
    </header>

    <!-- Script for mobile menu toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('menu-icon-open');
            const iconClose = document.getElementById('menu-icon-close');

            if (btn && menu) {
                btn.addEventListener('click', function () {
                    const isHidden = menu.classList.contains('hidden');
                    if (isHidden) {
                        menu.classList.remove('hidden');
                        if (iconOpen) iconOpen.classList.add('hidden');
                        if (iconClose) iconClose.classList.remove('hidden');
                    } else {
                        menu.classList.add('hidden');
                        if (iconOpen) iconOpen.classList.remove('hidden');
                        if (iconClose) iconClose.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    <!-- Main Content Wrapper -->
    <main class="flex-1 w-full overflow-y-auto">
