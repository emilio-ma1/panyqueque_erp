<?php
/**
 * Dashboard Gerencial - Dirección General
 * Panadería y Pastelería Pan y Queque
 * Basado en la estética ejecutiva oscura de la plantilla Haute Boulangerie (Plantilla/code.html)
 */
$currentPage = 'dashboard';
$pageTitle = 'Dashboard Gerencial';
require_once __DIR__ . '/../includes/header.php';

// Métricas clave del día
$ventasDelDia = 1420500;
$margenNeto = 38.5;
$cuentasPorPagar = 450000;

// Capacidad diaria de hornos y producción
$produccionHorno = [
    [
        'producto' => 'Pan Marraqueta de Masa Madre',
        'cantidad_actual' => 750,
        'capacidad_pct' => 94,
        'meta' => '800 kg',
        'color' => 'bg-brand-gold'
    ],
    [
        'producto' => 'Hallullas Especiales de Solera',
        'cantidad_actual' => 580,
        'capacidad_pct' => 88,
        'meta' => '650 kg',
        'color' => 'bg-amber-600'
    ],
    [
        'producto' => 'Empanadas de Pino al Horno',
        'cantidad_actual' => 420,
        'capacidad_pct' => 93,
        'meta' => '450 unid',
        'color' => 'bg-emerald-500'
    ],
    [
        'producto' => 'Viennoiserie & Pastelería Fina',
        'cantidad_actual' => 318,
        'capacidad_pct' => 82,
        'meta' => '390 unid',
        'color' => 'bg-sky-500'
    ]
];

// Top 5 productos más demandados
$top5Productos = [
    [
        'rank' => 1,
        'nombre' => 'Pan Marraqueta Tradicional',
        'categoria' => 'Panadería',
        'unidades' => '750 kg',
        'ingresos' => 1417500,
        'tendencia' => '+12.4%'
    ],
    [
        'rank' => 2,
        'nombre' => 'Pan Hallulla Especial',
        'categoria' => 'Panadería',
        'unidades' => '580 kg',
        'ingresos' => 1096200,
        'tendencia' => '+8.1%'
    ],
    [
        'rank' => 3,
        'nombre' => 'Empanadas de Pino Horno',
        'categoria' => 'Bollería Caliente',
        'unidades' => '420 unid',
        'ingresos' => 1008000,
        'tendencia' => '+15.3%'
    ],
    [
        'rank' => 4,
        'nombre' => 'Torta de Chocolate Grand Cru',
        'categoria' => 'Pastelería Fina',
        'unidades' => '28 unid',
        'ingresos' => 518000,
        'tendencia' => '+4.7%'
    ],
    [
        'rank' => 5,
        'nombre' => 'Pasteles Surtidos de Vitrina',
        'categoria' => 'Pastelería Fina',
        'unidades' => '290 unid',
        'ingresos' => 478500,
        'tendencia' => '+6.2%'
    ]
];
?>

<div class="max-w-7xl mx-auto px-6 lg:px-12 py-8 sm:py-12">

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav mb-6 flex items-center text-xs text-gray-500 space-x-2 uppercase tracking-wider">
        <a href="index.php" class="hover:text-brand-gold flex items-center space-x-1 font-medium transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Inicio</span>
        </a>
        <span>/</span>
        <span class="text-brand-gold font-semibold">Dashboard Gerencial</span>
    </nav>

    <!-- Header Section (Plantilla Haute Boulangerie Dark Card) -->
    <div class="bg-[#1c1c1c] rounded-2xl p-6 sm:p-8 border border-gray-800 shadow-xl mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-full border border-brand-gold/50 flex items-center justify-center text-brand-gold bg-brand-gold/10">
                    <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0h.5m-1 0h-9.5m0 0h-.5" />
                    </svg>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl font-normal text-white tracking-tight">
                    Analítica &amp; Dirección General
                </h1>
            </div>
            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-400">
                <span class="bg-brand-gold/20 text-brand-gold border border-brand-gold/30 font-semibold px-2.5 py-0.5 rounded-full uppercase tracking-wider text-[10px]">
                    Perfil Ejecutivo VIP
                </span>
                <span>&bull;</span>
                <span>Rol: <strong class="text-white">Gerente General</strong></span>
                <span>&bull;</span>
                <span>Consolidado Financiero &amp; Operativo</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" onclick="alert('Exportando informe gerencial consolidado en PDF...');" class="inline-flex items-center px-4 py-2.5 rounded-lg bg-brand-gold hover:bg-brand-goldHover text-white text-xs uppercase tracking-widest font-semibold shadow-sm transition-all hover:scale-105">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Descargar Informe</span>
            </button>
        </div>
    </div>

    <!-- Stats Grid: 3 Columns -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Stat 1: Ventas del Día -->
        <div class="bg-[#1c1c1c] rounded-2xl p-6 border border-gray-800 shadow-md hover:border-brand-gold/50 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs uppercase tracking-widest text-gray-400 font-medium">Ventas Acumuladas Hoy</span>
                <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 font-semibold">+14.2%</span>
            </div>
            <p class="font-serif text-3xl sm:text-4xl font-bold text-white mb-1">
                $1.420.500
            </p>
            <p class="text-xs text-gray-500 font-light">Facturación total en sala mostrador y despachos</p>
        </div>

        <!-- Stat 2: Margen Neto de Utilidad -->
        <div class="bg-[#1c1c1c] rounded-2xl p-6 border border-brand-gold/40 shadow-md hover:border-brand-gold transition-colors bg-gradient-to-br from-[#1c1c1c] to-[#25201a]">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs uppercase tracking-widest text-brand-gold font-semibold">Margen Neto de Utilidad</span>
                <span class="text-xs px-2 py-0.5 rounded-full bg-brand-gold/20 text-brand-gold border border-brand-gold/40 font-semibold">Meta 35%</span>
            </div>
            <p class="font-serif text-3xl sm:text-4xl font-bold text-brand-gold mb-1">
                38.5%
            </p>
            <p class="text-xs text-gray-400 font-light">Superávit tras descontar harinas, insumos y energía</p>
        </div>

        <!-- Stat 3: Cuentas por Pagar -->
        <div class="bg-[#1c1c1c] rounded-2xl p-6 border border-gray-800 shadow-md hover:border-brand-gold/50 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs uppercase tracking-widest text-gray-400 font-medium">Compromisos con Proveedores</span>
                <span class="text-xs px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/30 font-medium">Al Día</span>
            </div>
            <p class="font-serif text-3xl sm:text-4xl font-bold text-amber-400 mb-1">
                $450.000
            </p>
            <p class="text-xs text-gray-500 font-light">Liquidaciones de harina y manteca programadas a 15 días</p>
        </div>

    </div>

    <!-- Production & Top 5 Grid (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-8">
        
        <!-- Left: Capacidad Diaria de Hornos (7 cols) -->
        <div class="lg:col-span-7 bg-[#1c1c1c] rounded-2xl border border-gray-800 shadow-md p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-800">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.2em] text-brand-gold font-semibold block">Obrador Central</span>
                    <h2 class="font-serif text-2xl text-white font-medium">Capacidad de Horneado Diario</h2>
                </div>
                <div class="text-xs text-gray-400">
                    Capacidad General: <span class="font-serif font-bold text-brand-gold text-sm">89%</span>
                </div>
            </div>

            <div class="space-y-5">
                <?php foreach ($produccionHorno as $p): ?>
                <div>
                    <div class="flex justify-between text-xs mb-1.5">
                        <span class="font-semibold text-gray-200"><?php echo htmlspecialchars($p['producto']); ?></span>
                        <span class="text-gray-400 font-mono"><?php echo $p['cantidad_actual']; ?> / <?php echo $p['meta']; ?> (<span class="text-brand-gold font-bold"><?php echo $p['capacidad_pct']; ?>%</span>)</span>
                    </div>
                    <div class="w-full h-2.5 bg-gray-800 rounded-full overflow-hidden">
                        <div class="h-full rounded-full <?php echo $p['color']; ?> transition-all duration-500" style="width: <?php echo $p['capacidad_pct']; ?>%;"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-800 flex items-center justify-between text-xs text-gray-400">
                <span>Hornos de solera refractaria operando en temperatura óptima.</span>
                <span class="text-brand-gold font-medium">Turno Matutino</span>
            </div>
        </div>

        <!-- Right: Top 5 Productos Más Vendidos (5 cols) -->
        <div class="lg:col-span-5 bg-[#1c1c1c] rounded-2xl border border-gray-800 shadow-md p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-800">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.2em] text-brand-gold font-semibold block">Demanda en Mostrador</span>
                    <h2 class="font-serif text-2xl text-white font-medium">Top 5 Más Vendidos</h2>
                </div>
            </div>

            <div class="space-y-3">
                <?php foreach ($top5Productos as $tp): ?>
                <div class="p-3 bg-[#141414] rounded-xl border border-gray-800 flex items-center justify-between hover:border-gray-700 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 rounded-full bg-brand-gold/10 border border-brand-gold/30 flex items-center justify-center font-serif text-xs font-bold text-brand-gold">
                            #<?php echo $tp['rank']; ?>
                        </div>
                        <div>
                            <div class="font-semibold text-xs text-white"><?php echo htmlspecialchars($tp['nombre']); ?></div>
                            <div class="text-[11px] text-gray-500 font-light"><?php echo $tp['unidades']; ?> despachadas</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-serif font-bold text-xs text-brand-gold"><?php echo formatoPesos($tp['ingresos']); ?></div>
                        <div class="text-[10px] text-emerald-400 font-mono"><?php echo $tp['tendencia']; ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <!-- Registro de Actividad Reciente -->
    <div class="bg-[#1c1c1c] rounded-2xl p-6 border border-gray-800 text-xs text-gray-300 shadow-sm">
        <div class="flex items-center justify-between pb-3 border-b border-gray-800 mb-4">
            <div class="flex items-center space-x-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                <span class="font-serif text-base font-semibold text-white">Registro de Actividad Comercial en Tiempo Real</span>
            </div>
            <span class="text-[11px] text-brand-gold font-medium uppercase tracking-wider">Modo Local Activo</span>
        </div>
        <div class="space-y-2 text-xs text-gray-400">
            <?php 
            $dbLogs = (class_exists('DB')) ? DB::select("SELECT * FROM auditoria_logs ORDER BY created_at DESC LIMIT 4") : [];
            if (!empty($dbLogs)):
                foreach ($dbLogs as $log): 
                    $logTime = date('H:i:s', strtotime($log['created_at']));
            ?>
                <p><span class="text-gray-500 font-mono">[<?php echo $logTime; ?>]</span> <strong class="text-brand-gold font-medium">[<?php echo htmlspecialchars($log['modulo']); ?>]</strong> <?php echo htmlspecialchars($log['accion'] . ': ' . $log['detalle']); ?></p>
            <?php 
                endforeach; 
            else: 
            ?>
                <p><span class="text-gray-500 font-mono">[<?php echo date('H:i:s'); ?>]</span> Venta registrada en Mostrador 1: Boleta electrónica #004892 emitida por $18.500 CLP.</p>
                <p><span class="text-gray-500 font-mono">[<?php echo date('H:i:s', strtotime('-12 minutes')); ?>]</span> Despacho de 50 kg marraqueta confirmado en Supermercado Central.</p>
                <p><span class="text-gray-500 font-mono">[<?php echo date('H:i:s', strtotime('-35 minutes')); ?>]</span> Orden de compra por 500 kg de harina generada para Harina Los Andes S.A.</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
