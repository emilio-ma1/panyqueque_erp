<?php
/**
 * Common header and navigation bar for the Pan y Queque ERP.
 *
 * Implements the Atelier Architectural ERP design system:
 * - Opaque solid navigation (Zero-Glass Policy)
 * - Rectilinear architectural geometry (Zero-Pill Doctrine)
 * - Inter typography and JetBrains Mono for metrics and codes
 * - Google Material Symbols Outlined icons
 * - Role-Based Access Control indicator and account switcher
 */
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/config.php';
}
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/AuthService.php';

AuthService::startSession();
if (!AuthService::isLoggedIn()) {
    // Default to 'gerente' demo account so application is immediately functional
    AuthService::login('gerente', 'admin123');
}

$currentUser = AuthService::getCurrentUser();
$currentPage = $currentPage ?? 'inicio';
$pageTitle = $pageTitle ?? APP_NAME;
$isDarkTheme = ($currentPage === 'dashboard');
$dbConnected = DB::isConnected();

$userRole = AuthService::getUserRole();
$userRoleLabel = AuthService::ROLE_LABELS[$userRole] ?? strtoupper($userRole);
$userInitials = 'MV';
if (!empty($currentUser['full_name'])) {
    $parts = explode(' ', trim($currentUser['full_name']));
    $first = $parts[0][0] ?? 'U';
    $last = isset($parts[1]) ? ($parts[1][0] ?? '') : '';
    $userInitials = strtoupper($first . $last);
}
?>
<!DOCTYPE html>
<html lang="es" class="<?php echo $isDarkTheme ? 'h-full bg-zinc-950 dark' : 'h-full bg-slate-100'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle . ' | ' . APP_COMPANY); ?></title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Preconnect to external CDNs -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Google Fonts: Inter, JetBrains Mono & Material Symbols Outlined -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Alpine.js (lightweight reactive framework - non-blocking defer) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- AutoAnimate (smooth list transitions via ESM) -->
    <script type="module">
        import autoAnimate from 'https://cdn.jsdelivr.net/npm/@formkit/auto-animate@0.8.2/+esm';
        window.autoAnimate = autoAnimate;
        window.dispatchEvent(new CustomEvent('autoAnimateReady'));
    </script>

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
                    <span>TURNO MATUTINO</span>
                    <span class="<?php echo $isDarkTheme ? 'text-zinc-600' : 'text-slate-600'; ?>">|</span>
                    <span class="<?php echo $dbConnected ? 'text-emerald-400 font-semibold' : 'text-amber-400 font-semibold'; ?>">
                        <?php echo $dbConnected ? 'MARIADB 10.11 ACTIVO' : 'MODO LOCAL ACTIVO'; ?>
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
                <?php $canPos = AuthService::canAccessModule('pos'); ?>
                <a href="pos.php" class="px-3.5 py-2 text-xs font-semibold uppercase tracking-wider rounded-none transition-none flex items-center space-x-1 <?php
                    echo ($currentPage === 'pos' || $currentPage === 'caja')
                        ? ($isDarkTheme ? 'text-white bg-zinc-800 border-b-2 border-amber-500' : 'text-white bg-slate-800 border-b-2 border-amber-600')
                        : ($isDarkTheme ? 'text-zinc-400 hover:text-white hover:bg-zinc-800/80 border-b-2 border-transparent' : 'text-slate-300 hover:text-white hover:bg-slate-800 border-b-2 border-transparent');
                    if (!$canPos) echo ' opacity-50';
                ?>">
                    <span>2. Punto de Venta (POS)</span>
                    <?php if (!$canPos): ?><span class="material-symbols-outlined text-xs">lock</span><?php endif; ?>
                </a>

                <!-- 3. Proveedores -->
                <?php $canSuppliers = AuthService::canAccessModule('suppliers'); ?>
                <a href="suppliers.php" class="px-3.5 py-2 text-xs font-semibold uppercase tracking-wider rounded-none transition-none flex items-center space-x-1 <?php
                    echo ($currentPage === 'suppliers' || $currentPage === 'proveedores')
                        ? ($isDarkTheme ? 'text-white bg-zinc-800 border-b-2 border-amber-500' : 'text-white bg-slate-800 border-b-2 border-amber-600')
                        : ($isDarkTheme ? 'text-zinc-400 hover:text-white hover:bg-zinc-800/80 border-b-2 border-transparent' : 'text-slate-300 hover:text-white hover:bg-slate-800 border-b-2 border-transparent');
                    if (!$canSuppliers) echo ' opacity-50';
                ?>">
                    <span>3. Proveedores &amp; Finanzas</span>
                    <?php if (!$canSuppliers): ?><span class="material-symbols-outlined text-xs">lock</span><?php endif; ?>
                </a>

                <!-- 4. Logística -->
                <?php $canDispatch = AuthService::canAccessModule('dispatch'); ?>
                <a href="dispatch.php" class="px-3.5 py-2 text-xs font-semibold uppercase tracking-wider rounded-none transition-none flex items-center space-x-1 <?php
                    echo ($currentPage === 'dispatch' || $currentPage === 'reparto')
                        ? ($isDarkTheme ? 'text-white bg-zinc-800 border-b-2 border-amber-500' : 'text-white bg-slate-800 border-b-2 border-amber-600')
                        : ($isDarkTheme ? 'text-zinc-400 hover:text-white hover:bg-zinc-800/80 border-b-2 border-transparent' : 'text-slate-300 hover:text-white hover:bg-slate-800 border-b-2 border-transparent');
                    if (!$canDispatch) echo ' opacity-50';
                ?>">
                    <span>4. Logística &amp; Rutas</span>
                    <?php if (!$canDispatch): ?><span class="material-symbols-outlined text-xs">lock</span><?php endif; ?>
                </a>

                <!-- 5. Dashboard Ejecutivo -->
                <?php $canDash = AuthService::canAccessModule('dashboard'); ?>
                <a href="dashboard.php" class="px-3.5 py-2 text-xs font-semibold uppercase tracking-wider rounded-none transition-none flex items-center space-x-1 <?php
                    echo ($currentPage === 'dashboard')
                        ? 'text-amber-400 bg-zinc-800 border-b-2 border-amber-500 font-bold'
                        : ($isDarkTheme ? 'text-amber-400 hover:text-amber-300 hover:bg-zinc-800/80 border-b-2 border-transparent' : 'text-amber-400 hover:text-amber-300 hover:bg-slate-800 border-b-2 border-transparent');
                    if (!$canDash) echo ' opacity-50';
                ?>">
                    <span>5. Dashboard Ejecutivo</span>
                    <?php if (!$canDash): ?><span class="material-symbols-outlined text-xs">lock</span><?php endif; ?>
                </a>
            </nav>

            <!-- Panel de Usuario y Control de Acceso -->
            <div class="flex items-center space-x-3">
                <div class="text-right hidden sm:block">
                    <div class="text-xs font-semibold <?php echo $isDarkTheme ? 'text-zinc-200' : 'text-slate-200'; ?>">
                        <?php echo htmlspecialchars($currentUser['full_name']); ?>
                    </div>
                    <div class="text-[10px] font-mono <?php echo $isDarkTheme ? 'text-amber-400' : 'text-amber-300'; ?> flex items-center justify-end space-x-1">
                        <span class="w-1.5 h-1.5 bg-emerald-400 inline-block rounded-none"></span>
                        <span>[<?php echo strtoupper($userRole); ?>]</span>
                    </div>
                </div>

                <!-- Avatar con Iniciales -->
                <div class="w-9 h-9 <?php echo $isDarkTheme ? 'bg-zinc-800 border border-zinc-700 text-zinc-200' : 'bg-slate-800 border border-slate-700 text-slate-300'; ?> flex items-center justify-center text-xs font-bold font-mono rounded-none">
                    <?php echo $userInitials; ?>
                </div>

                <!-- Botón Cambiar Rol / Cerrar Sesión -->
                <a href="login.php" title="Cambiar de Rol / Cuenta" class="p-2 text-zinc-400 hover:text-amber-400 hover:bg-zinc-800 rounded-none transition-none flex items-center" aria-label="Cambiar cuenta">
                    <span class="material-symbols-outlined text-lg">switch_account</span>
                </a>

                <a href="logout.php" title="Cerrar Sesión" class="p-2 text-zinc-400 hover:text-rose-400 hover:bg-zinc-800 rounded-none transition-none flex items-center" aria-label="Cerrar sesión">
                    <span class="material-symbols-outlined text-lg">logout</span>
                </a>

                <!-- Mobile Menu Button (Alpine.js) -->
                <div x-data="{ mobileOpen: false }" class="lg:hidden">
                    <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 text-white hover:bg-slate-800 rounded-none focus:outline-none" aria-label="Abrir menú">
                        <span class="material-symbols-outlined text-xl" x-show="!mobileOpen">menu</span>
                        <span class="material-symbols-outlined text-xl" x-show="mobileOpen" x-cloak>close</span>
                    </button>

                    <!-- Mobile Dropdown Menu (Solid rectangular, Alpine.js controlled) -->
                    <div x-show="mobileOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         x-cloak
                         @click.outside="mobileOpen = false"
                         class="absolute left-0 right-0 top-16 z-40 <?php echo $isDarkTheme ? 'bg-zinc-900 border-t border-zinc-800 text-zinc-200' : 'bg-slate-900 border-t border-slate-800 text-slate-200'; ?> px-4 py-3 space-y-1 text-xs uppercase font-mono">
                        <a href="index.php" class="block py-2.5 px-3 <?php echo ($currentPage === 'inicio') ? 'bg-slate-800 text-white font-bold' : 'hover:bg-slate-800'; ?> rounded-none">
                            1. Inicio &amp; Catálogo
                        </a>
                        <a href="pos.php" class="block py-2.5 px-3 <?php echo ($currentPage === 'pos') ? 'bg-slate-800 text-white font-bold' : 'hover:bg-slate-800'; ?> rounded-none">
                            2. Punto de Venta (POS) <?php if (!AuthService::canAccessModule('pos')) echo '[RESTRINGIDO]'; ?>
                        </a>
                        <a href="suppliers.php" class="block py-2.5 px-3 <?php echo ($currentPage === 'suppliers') ? 'bg-slate-800 text-white font-bold' : 'hover:bg-slate-800'; ?> rounded-none">
                            3. Proveedores &amp; Finanzas <?php if (!AuthService::canAccessModule('suppliers')) echo '[RESTRINGIDO]'; ?>
                        </a>
                        <a href="dispatch.php" class="block py-2.5 px-3 <?php echo ($currentPage === 'dispatch') ? 'bg-slate-800 text-white font-bold' : 'hover:bg-slate-800'; ?> rounded-none">
                            4. Logística &amp; Rutas <?php if (!AuthService::canAccessModule('dispatch')) echo '[RESTRINGIDO]'; ?>
                        </a>
                        <a href="dashboard.php" class="block py-2.5 px-3 text-amber-400 font-bold hover:bg-slate-800 rounded-none">
                            5. Dashboard Ejecutivo <?php if (!AuthService::canAccessModule('dashboard')) echo '[RESTRINGIDO]'; ?>
                        </a>
                        <div class="pt-2 border-t border-zinc-800 flex justify-between items-center text-xs">
                            <span>Cuenta: <?php echo htmlspecialchars($currentUser['username']); ?> (<?php echo strtoupper($userRole); ?>)</span>
                            <a href="login.php" class="text-amber-400 hover:underline">Cambiar Rol</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Alpine.js x-cloak: hide elements until Alpine initializes -->
    <style>[x-cloak] { display: none !important; }</style>

    <!-- Main Content Wrapper -->
    <main class="flex-1 w-full overflow-y-auto">
