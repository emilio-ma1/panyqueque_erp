<?php
/**
 * Header común para el Sistema ERP - Panadería y Pastelería Pan y Queque
 * Basado en la plantilla elegante de Haute Boulangerie (Plantilla/code.html)
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
<html lang="es" class="scroll-smooth <?php echo $isDarkTheme ? 'dark' : ''; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle . ' — ' . APP_COMPANY); ?></title>

    <!-- Google Fonts: Cormorant Garamond & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            gold: '#B89758',
                            goldHover: '#A48446',
                            sand: '#F9F8F5',
                            charcoal: '#1A1A1A',
                            muted: '#71717A',
                            surface: '#FCFBF9'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body class="<?php echo $isDarkTheme ? 'bg-[#141414] text-gray-100 dark-theme' : 'bg-white text-brand-charcoal'; ?> font-sans antialiased selection:bg-brand-gold selection:text-white min-h-screen flex flex-col">

    <!-- ====================================================================== -->
    <!-- HEADER: Fijo / Sticky con backdrop-blur inspirado en la plantilla -->
    <!-- ====================================================================== -->
    <header class="sticky top-0 z-50 <?php echo $isDarkTheme ? 'bg-[#181818]/95 border-b border-gray-800' : 'bg-white/95 border-b border-gray-100'; ?> backdrop-blur-md transition-all shadow-sm">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 h-20 flex items-center justify-between">
            
            <!-- Logo / Identidad de la Panadería -->
            <a href="index.php" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full border border-brand-gold/50 flex items-center justify-center text-brand-gold group-hover:border-brand-gold group-hover:scale-105 transition-all shadow-sm bg-brand-sand/50">
                    <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m0-18c-2.5 0-5 3.5-5 9s2.5 9 5 9m0-18c2.5 0 5 3.5 5 9s-2.5 9-5 9" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18" />
                    </svg>
                </div>
                <div>
                    <span class="font-serif text-xl md:text-2xl font-semibold tracking-wide <?php echo $isDarkTheme ? 'text-white' : 'text-brand-charcoal'; ?> block leading-none">
                        Pan y Queque
                    </span>
                    <span class="text-[10px] uppercase tracking-[0.25em] text-brand-gold font-medium block mt-1">
                        Haute Boulangerie &bull; ERP
                    </span>
                </div>
            </a>

            <!-- Menú Central -->
            <nav class="hidden md:flex items-center gap-8 text-xs uppercase tracking-widest font-medium <?php echo $isDarkTheme ? 'text-gray-300' : 'text-gray-600'; ?>">
                <a href="index.php" class="<?php echo $currentPage === 'inicio' ? ($isDarkTheme ? 'text-white border-b-2 border-brand-gold font-bold' : 'text-brand-charcoal border-b-2 border-brand-gold font-semibold') : 'hover:text-brand-gold hover:border-b hover:border-brand-gold/60'; ?> pb-1 transition-all">
                    Inicio
                </a>
                <a href="caja.php" class="<?php echo $currentPage === 'caja' ? ($isDarkTheme ? 'text-white border-b-2 border-brand-gold font-bold' : 'text-brand-charcoal border-b-2 border-brand-gold font-semibold') : 'hover:text-brand-gold hover:border-b hover:border-brand-gold/60'; ?> pb-1 transition-all">
                    Punto de Venta
                </a>
                <a href="proveedores.php" class="<?php echo $currentPage === 'proveedores' ? ($isDarkTheme ? 'text-white border-b-2 border-brand-gold font-bold' : 'text-brand-charcoal border-b-2 border-brand-gold font-semibold') : 'hover:text-brand-gold hover:border-b hover:border-brand-gold/60'; ?> pb-1 transition-all">
                    Proveedores &amp; Finanzas
                </a>
                <a href="reparto.php" class="<?php echo $currentPage === 'reparto' ? ($isDarkTheme ? 'text-white border-b-2 border-brand-gold font-bold' : 'text-brand-charcoal border-b-2 border-brand-gold font-semibold') : 'hover:text-brand-gold hover:border-b hover:border-brand-gold/60'; ?> pb-1 transition-all">
                    Logística &amp; Rutas
                </a>
                <a href="dashboard.php" class="<?php echo $currentPage === 'dashboard' ? 'text-brand-gold border-b-2 border-brand-gold font-bold' : 'hover:text-brand-gold hover:border-b hover:border-brand-gold/60'; ?> pb-1 transition-all flex items-center gap-1.5">
                    <span>Dashboard</span>
                    <span class="text-[9px] bg-brand-gold/20 text-brand-gold border border-brand-gold/30 px-1.5 py-0.2 rounded font-sans uppercase">VIP</span>
                </a>
            </nav>

            <!-- CTA Derecha: Estado de Sistema Local -->
            <div class="flex items-center gap-3">
                <div class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-full <?php echo $isDarkTheme ? 'bg-gray-800 border-gray-700 text-gray-200' : 'bg-brand-sand border-brand-gold/30 text-brand-charcoal'; ?> border text-[11px] uppercase tracking-widest font-medium">
                    <span class="w-1.5 h-1.5 rounded-full <?php echo $dbConnected ? 'bg-emerald-500' : 'bg-brand-gold'; ?>"></span>
                    <span><?php echo $dbConnected ? 'PostgreSQL 15 Conectado' : 'Modo Local Activo'; ?></span>
                </div>

                <!-- Botón Menú Móvil -->
                <button id="mobile-menu-btn" type="button" class="md:hidden p-2 rounded-lg text-brand-charcoal hover:text-brand-gold focus:outline-none" aria-label="Abrir menú">
                    <svg id="menu-icon-open" class="w-6 h-6 block <?php echo $isDarkTheme ? 'text-white' : 'text-brand-charcoal'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg id="menu-icon-close" class="w-6 h-6 hidden <?php echo $isDarkTheme ? 'text-white' : 'text-brand-charcoal'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Menú Móvil Desplegable -->
        <div id="mobile-menu" class="hidden md:hidden <?php echo $isDarkTheme ? 'bg-[#181818] border-gray-800' : 'bg-white border-gray-200'; ?> border-t px-6 py-4 space-y-3 text-xs uppercase tracking-widest">
            <a href="index.php" class="block py-2 <?php echo $currentPage === 'inicio' ? 'text-brand-gold font-bold' : 'text-gray-600'; ?>">
                Inicio
            </a>
            <a href="caja.php" class="block py-2 <?php echo $currentPage === 'caja' ? 'text-brand-gold font-bold' : 'text-gray-600'; ?>">
                Punto de Venta (Cajas)
            </a>
            <a href="proveedores.php" class="block py-2 <?php echo $currentPage === 'proveedores' ? 'text-brand-gold font-bold' : 'text-gray-600'; ?>">
                Proveedores &amp; Finanzas
            </a>
            <a href="reparto.php" class="block py-2 <?php echo $currentPage === 'reparto' ? 'text-brand-gold font-bold' : 'text-gray-600'; ?>">
                Logística &amp; Reparto
            </a>
            <a href="dashboard.php" class="block py-2 text-brand-gold font-bold">
                Dashboard Gerencial (VIP)
            </a>
        </div>
    </header>

    <!-- Script para menú móvil -->
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
                        iconOpen.classList.add('hidden');
                        iconClose.classList.remove('hidden');
                    } else {
                        menu.classList.add('hidden');
                        iconOpen.classList.remove('hidden');
                        iconClose.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    <!-- Main Content Wrapper -->
    <main class="flex-grow">
