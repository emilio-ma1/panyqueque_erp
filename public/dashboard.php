<?php
/**
 * Dashboard Ejecutivo VIP - Dirección General
 * Panadería y Pastelería Pan y Queque
 * Diseñado bajo los estándares del Atelier Architectural ERP (Plantilla/stitch_bakery_erp_system/dashboard_ejecutivo_vip/)
 */
$currentPage = 'dashboard';
$pageTitle = 'Dashboard Ejecutivo VIP';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/AuditService.php';

// Métricas clave del día
$ventasDelDia = 1420500;
$margenNeto = 38.5;
$cuentasPorPagar = 450000;

// Capacidad diaria de hornos y maquinaria pesada
$maquinariaHorno = [
    [
        'nombre' => 'Hornos de Solera de Piedra (Deck)',
        'porcentaje' => 88,
        'detalle' => '6 módulos a 245°C. Masa madre rústica y baguettes de tradición.',
        'telemetria' => 'ESTABLE ±1.2°C',
        'color' => 'bg-amber-500'
    ],
    [
        'nombre' => 'Hornos Rotativos de Convección',
        'porcentaje' => 74,
        'detalle' => 'Viennoiserie y brioches laminados. Inyección de vapor regulada a 90s.',
        'telemetria' => '1.400 RPM NORMAL',
        'color' => 'bg-amber-600'
    ],
    [
        'nombre' => 'Cámaras de Frío Lento (4°C)',
        'porcentaje' => 92,
        'detalle' => '42 Lotes en maduración retardada (36h). pH masa madre en 4.15.',
        'telemetria' => '84% HUMEDAD',
        'color' => 'bg-emerald-500'
    ],
    [
        'nombre' => 'Amasadoras de Espiral Industrial',
        'porcentaje' => 65,
        'detalle' => '320 kg harina/hora en turno matutino. 14 maestros en línea.',
        'telemetria' => 'RITMO ALTO',
        'color' => 'bg-sky-500'
    ]
];

// Top 5 productos más demandados
$top5Productos = [
    [
        'rank' => 1,
        'nombre' => 'Pan Marraqueta Tradicional',
        'categoria' => 'Panadería Masa Madre',
        'unidades' => '750 kg',
        'ingresos' => 1417500,
        'tendencia' => '+12.4%'
    ],
    [
        'rank' => 2,
        'nombre' => 'Pan Hallulla Especial de Solera',
        'categoria' => 'Panadería Tradicional',
        'unidades' => '580 kg',
        'ingresos' => 1096200,
        'tendencia' => '+8.1%'
    ],
    [
        'rank' => 3,
        'nombre' => 'Empanadas de Pino al Horno',
        'categoria' => 'Bollería Caliente',
        'unidades' => '420 unid',
        'ingresos' => 1008000,
        'tendencia' => '+15.3%'
    ],
    [
        'rank' => 4,
        'nombre' => 'Croissant Mantequilla AOP Isigny',
        'categoria' => 'Viennoiserie Fina',
        'unidades' => '320 unid',
        'ingresos' => 768000,
        'tendencia' => '+9.8%'
    ],
    [
        'rank' => 5,
        'nombre' => 'Tarta Ópera Grand Cru 70%',
        'categoria' => 'Pastelería de Autor',
        'unidades' => '28 unid',
        'ingresos' => 518000,
        'tendencia' => '+4.7%'
    ]
];
?>

<!-- CONTENEDOR PRINCIPAL: EXECUTIVE VIP MODE (DARK ZINC-950) -->
<div class="flex flex-col w-full bg-zinc-950 text-zinc-100 min-w-0">

    <!-- 1. ENCABEZADO DE DIRECCIÓN VIP -->
    <div class="w-full bg-zinc-900 border-b border-zinc-800 px-4 sm:px-8 py-6">
        <div class="max-w-[1536px] mx-auto flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <div class="flex items-center space-x-3 mb-1.5">
                    <span class="w-2.5 h-2.5 bg-amber-500 rounded-none inline-block"></span>
                    <span class="text-xs font-mono font-bold tracking-widest uppercase text-amber-500">MÓDULO DE ALTA DIRECCIÓN • ACCESO RESTRINGIDO</span>
                    <span class="text-zinc-600 font-mono text-xs">/</span>
                    <span class="text-xs font-mono text-zinc-400">LEDGER-FIN-2026-Q1</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                    Módulo 05 // Panel de Control Ejecutivo &amp; Métricas de Dirección (VIP)
                </h1>
                <p class="text-xs sm:text-sm text-zinc-400 mt-1">
                    Consolidado financiero en tiempo real, rendimiento del obrador y balance operativo de las plantas.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Selector de Período -->
                <div class="flex items-center bg-zinc-950 border border-zinc-800 p-1">
                    <button type="button" class="px-3 py-1.5 text-xs font-mono font-semibold uppercase tracking-wider text-amber-400 bg-zinc-800 border-b-2 border-amber-500 rounded-none transition-none">
                        HOY • TIEMPO REAL
                    </button>
                    <button type="button" class="px-3 py-1.5 text-xs font-mono font-semibold uppercase tracking-wider text-zinc-400 hover:text-white rounded-none transition-none">
                        7 DÍAS
                    </button>
                    <button type="button" class="px-3 py-1.5 text-xs font-mono font-semibold uppercase tracking-wider text-zinc-400 hover:text-white rounded-none transition-none">
                        MES EN CURSO
                    </button>
                </div>

                <!-- Botón Exportar PDF -->
                <button type="button" onclick="window.print()" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-mono font-bold uppercase tracking-wider border border-amber-500 rounded-none flex items-center space-x-2 transition-none">
                    <span class="material-symbols-outlined text-sm leading-none">download</span>
                    <span>DESCARGAR REPORTE EJECUTIVO PDF</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 2. CONTENIDO CENTRAL VIP -->
    <div class="w-full max-w-[1536px] mx-auto p-4 sm:p-8 space-y-8">

        <!-- 3. KPIS FINANCIEROS PRINCIPALES (GRID DE 4 TARJETAS SÓLIDAS) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- KPI 1: Facturación Neta -->
            <div class="bg-zinc-900 border border-zinc-800 p-5 rounded-none flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-mono uppercase tracking-wider text-zinc-400 font-medium">Facturación Neta del Día</span>
                    <span class="px-2 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-emerald-950 text-emerald-300 border border-emerald-800 rounded-none">
                        EN LÍNEA
                    </span>
                </div>
                <div class="my-4">
                    <div class="text-3xl font-bold font-mono tracking-tight text-white tabular-nums">
                        $1.420.500
                    </div>
                    <div class="flex items-center mt-2 text-xs font-mono font-semibold text-emerald-400 space-x-1">
                        <span class="material-symbols-outlined text-sm leading-none">arrow_upward</span>
                        <span>+12.4% vs promedio diario</span>
                    </div>
                </div>
                <div class="pt-3 border-t border-zinc-800 text-[11px] font-mono text-zinc-400 flex justify-between">
                    <span>Meta: $1.250.000</span>
                    <span class="text-zinc-300 font-semibold">Cumplimiento: 113.6%</span>
                </div>
            </div>

            <!-- KPI 2: Ticket Promedio Mayorista -->
            <div class="bg-zinc-900 border border-zinc-800 p-5 rounded-none flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-mono uppercase tracking-wider text-zinc-400 font-medium">Ticket Promedio Mayorista</span>
                    <span class="px-2 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-zinc-950 text-zinc-300 border border-zinc-800 rounded-none">
                        B2B / HORECA
                    </span>
                </div>
                <div class="my-4">
                    <div class="text-3xl font-bold font-mono tracking-tight text-white tabular-nums">
                        $32.450
                    </div>
                    <div class="mt-2 text-xs font-mono text-zinc-400">
                        Base de <span class="text-white font-bold">46 despachos</span> HORECA activos
                    </div>
                </div>
                <div class="pt-3 border-t border-zinc-800 text-[11px] font-mono text-zinc-400 flex justify-between">
                    <span>Despacho Mayor: $142.000</span>
                    <span class="text-amber-400 font-semibold">Rutas: 100% Ok</span>
                </div>
            </div>

            <!-- KPI 3: Margen Bruto Explotación -->
            <div class="bg-zinc-900 border border-zinc-800 p-5 rounded-none flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-mono uppercase tracking-wider text-zinc-400 font-medium">Margen Bruto Explotación</span>
                    <span class="px-2 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-amber-950 text-amber-300 border border-amber-800 rounded-none">
                        TARGET &gt; 35%
                    </span>
                </div>
                <div class="my-4">
                    <div class="text-3xl font-bold font-mono tracking-tight text-amber-400 tabular-nums">
                        38.5%
                    </div>
                    <div class="mt-2 text-xs font-mono text-zinc-400">
                        Costo de materia prima optimizado a <span class="text-zinc-200 font-bold">31.6%</span>
                    </div>
                </div>
                <div class="pt-3 border-t border-zinc-800 text-[11px] font-mono text-zinc-400 flex justify-between">
                    <span>Harina Seleccionada T65</span>
                    <span class="text-emerald-400 font-semibold">+1.2% eficiencia</span>
                </div>
            </div>

            <!-- KPI 4: Merma Técnica -->
            <div class="bg-zinc-900 border border-zinc-800 p-5 rounded-none flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-mono uppercase tracking-wider text-zinc-400 font-medium">Merma Técnica Controlada</span>
                    <span class="px-2 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-emerald-950 text-emerald-300 border border-emerald-800 rounded-none">
                        BAJO CONTROL
                    </span>
                </div>
                <div class="my-4">
                    <div class="text-3xl font-bold font-mono tracking-tight text-white tabular-nums">
                        1.82%
                    </div>
                    <div class="mt-2 text-xs font-mono text-emerald-400">
                        Por debajo del umbral crítico de 2.50%
                    </div>
                </div>
                <div class="pt-3 border-t border-zinc-800 text-[11px] font-mono text-zinc-400 flex justify-between">
                    <span>Masa Retenida: 14.2 kg</span>
                    <span class="text-zinc-300 font-semibold">Recuperación: 92%</span>
                </div>
            </div>

        </div>

        <!-- 4. MONITOR DE CAPACIDAD OPERATIVA Y EFICIENCIA DE HORNEADO -->
        <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-none">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-5 border-b border-zinc-800 gap-2">
                <div>
                    <h2 class="text-base font-bold tracking-tight text-white uppercase flex items-center space-x-2">
                        <span class="material-symbols-outlined text-amber-500 text-xl leading-none">precision_manufacturing</span>
                        <span>Capacidad Operativa y Eficiencia de Horneado</span>
                    </h2>
                    <p class="text-xs font-mono text-zinc-400 mt-0.5">
                        Telemetría de maquinaria pesada, estufas térmicas y control fermentativo (Planta Central #01)
                    </p>
                </div>
                <div class="text-right">
                    <span class="px-2.5 py-1 text-xs font-mono font-bold uppercase bg-zinc-950 border border-zinc-800 text-amber-400 rounded-none inline-block">
                        FASE TÉRMICA: ACTIVA
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-6">
                <?php foreach ($maquinariaHorno as $m): ?>
                <div class="bg-zinc-950 border border-zinc-800 p-4 rounded-none flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-xs font-mono mb-2">
                            <span class="text-zinc-300 font-semibold uppercase"><?php echo htmlspecialchars($m['nombre']); ?></span>
                            <span class="text-amber-400 font-bold"><?php echo $m['porcentaje']; ?>%</span>
                        </div>
                        <div class="w-full bg-zinc-800 h-2.5 rounded-none overflow-hidden">
                            <div class="<?php echo $m['color']; ?> h-full rounded-none" style="width: <?php echo $m['porcentaje']; ?>%;"></div>
                        </div>
                        <p class="text-[11px] font-mono text-zinc-400 mt-2.5 leading-relaxed">
                            <?php echo htmlspecialchars($m['detalle']); ?>
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-zinc-800 flex items-center justify-between text-[11px] font-mono text-zinc-400">
                        <span>Sensores Térmicos</span>
                        <span class="text-emerald-400 font-semibold"><?php echo $m['telemetria']; ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 5. GRÁFICA COMPARATIVA SEMANAL Y EBITDA CONSOLIDADO -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- COLUMNA IZQUIERDA: GRÁFICA SEMANAL DE BARRAS SÓLIDAS TAILWIND (7 COLS) -->
            <div class="lg:col-span-7 bg-zinc-900 border border-zinc-800 p-6 rounded-none flex flex-col justify-between">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-4 border-b border-zinc-800 gap-2">
                        <div>
                            <h3 class="text-base font-bold tracking-tight text-white uppercase">
                                Rendimiento Financiero Semanal
                            </h3>
                            <p class="text-xs font-mono text-zinc-400 mt-0.5">
                                Ingresos Brutos vs Costes Operativos Directos (Semana 12)
                            </p>
                        </div>
                        <div class="flex items-center space-x-4 text-xs font-mono">
                            <div class="flex items-center space-x-1.5">
                                <span class="w-3 h-3 bg-amber-500 rounded-none inline-block"></span>
                                <span class="text-zinc-300 font-medium">Ingresos ($)</span>
                            </div>
                            <div class="flex items-center space-x-1.5">
                                <span class="w-3 h-3 bg-zinc-700 rounded-none inline-block"></span>
                                <span class="text-zinc-400 font-medium">Costes ($)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Barras Sólidas Semanales -->
                    <div class="pt-8 pb-4">
                        <div class="h-60 flex items-end justify-between gap-2 sm:gap-4 border-b border-zinc-800 px-2">
                            <!-- LUN -->
                            <div class="flex-1 flex flex-col items-center h-full justify-end">
                                <div class="text-[10px] font-mono text-zinc-400 mb-1">$1.12M</div>
                                <div class="w-full flex items-end justify-center space-x-1 h-full">
                                    <div class="w-1/2 bg-amber-500 rounded-none" style="height: 59%;"></div>
                                    <div class="w-1/2 bg-zinc-700 rounded-none" style="height: 25%;"></div>
                                </div>
                                <span class="mt-2 text-xs font-mono text-zinc-400 font-semibold">LUN</span>
                            </div>
                            <!-- MAR -->
                            <div class="flex-1 flex flex-col items-center h-full justify-end">
                                <div class="text-[10px] font-mono text-zinc-400 mb-1">$1.28M</div>
                                <div class="w-full flex items-end justify-center space-x-1 h-full">
                                    <div class="w-1/2 bg-amber-500 rounded-none" style="height: 68%;"></div>
                                    <div class="w-1/2 bg-zinc-700 rounded-none" style="height: 27%;"></div>
                                </div>
                                <span class="mt-2 text-xs font-mono text-zinc-400 font-semibold">MAR</span>
                            </div>
                            <!-- MIÉ -->
                            <div class="flex-1 flex flex-col items-center h-full justify-end">
                                <div class="text-[10px] font-mono text-zinc-400 mb-1">$1.34M</div>
                                <div class="w-full flex items-end justify-center space-x-1 h-full">
                                    <div class="w-1/2 bg-amber-500 rounded-none" style="height: 71%;"></div>
                                    <div class="w-1/2 bg-zinc-700 rounded-none" style="height: 28%;"></div>
                                </div>
                                <span class="mt-2 text-xs font-mono text-zinc-400 font-semibold">MIÉ</span>
                            </div>
                            <!-- JUE -->
                            <div class="flex-1 flex flex-col items-center h-full justify-end">
                                <div class="text-[10px] font-mono text-zinc-400 mb-1">$1.41M</div>
                                <div class="w-full flex items-end justify-center space-x-1 h-full">
                                    <div class="w-1/2 bg-amber-500 rounded-none" style="height: 75%;"></div>
                                    <div class="w-1/2 bg-zinc-700 rounded-none" style="height: 30%;"></div>
                                </div>
                                <span class="mt-2 text-xs font-mono text-zinc-400 font-semibold">JUE</span>
                            </div>
                            <!-- VIE -->
                            <div class="flex-1 flex flex-col items-center h-full justify-end">
                                <div class="text-[10px] font-mono text-amber-400 font-bold mb-1">$1.89M</div>
                                <div class="w-full flex items-end justify-center space-x-1 h-full">
                                    <div class="w-1/2 bg-amber-400 rounded-none" style="height: 100%;"></div>
                                    <div class="w-1/2 bg-zinc-700 rounded-none" style="height: 36%;"></div>
                                </div>
                                <span class="mt-2 text-xs font-mono text-amber-400 font-bold">VIE</span>
                            </div>
                            <!-- SÁB -->
                            <div class="flex-1 flex flex-col items-center h-full justify-end">
                                <div class="text-[10px] font-mono text-zinc-400 mb-1">$1.65M</div>
                                <div class="w-full flex items-end justify-center space-x-1 h-full">
                                    <div class="w-1/2 bg-amber-500 rounded-none" style="height: 87%;"></div>
                                    <div class="w-1/2 bg-zinc-700 rounded-none" style="height: 32%;"></div>
                                </div>
                                <span class="mt-2 text-xs font-mono text-zinc-400 font-semibold">SÁB</span>
                            </div>
                            <!-- DOM -->
                            <div class="flex-1 flex flex-col items-center h-full justify-end">
                                <div class="text-[10px] font-mono text-zinc-400 mb-1">$1.42M</div>
                                <div class="w-full flex items-end justify-center space-x-1 h-full">
                                    <div class="w-1/2 bg-amber-500 rounded-none" style="height: 79%;"></div>
                                    <div class="w-1/2 bg-zinc-700 rounded-none" style="height: 31%;"></div>
                                </div>
                                <span class="mt-2 text-xs font-mono text-zinc-400 font-semibold">DOM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-zinc-800 text-xs font-mono text-zinc-400 flex flex-wrap justify-between items-center gap-2">
                    <span>Ingreso Semanal: <strong class="text-white font-mono">$10.186.000</strong></span>
                    <span>Coste Operativo: <strong class="text-zinc-200 font-mono">$3.962.000</strong></span>
                    <span class="text-emerald-400 font-semibold">Margen Neto: 61.1%</span>
                </div>
            </div>

            <!-- COLUMNA DERECHA: TABLA DESGLOSE EBITDA (5 COLS) -->
            <div class="lg:col-span-5 bg-zinc-900 border border-zinc-800 p-6 rounded-none flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                        <div>
                            <h3 class="text-base font-bold tracking-tight text-white uppercase flex items-center space-x-2">
                                <span class="material-symbols-outlined text-amber-400 text-lg leading-none">account_balance</span>
                                <span>EBITDA Consolidado &amp; Flujo</span>
                            </h3>
                            <p class="text-xs font-mono text-zinc-400 mt-0.5">
                                Proyección, flujo operativo y auditoría semanal
                            </p>
                        </div>
                        <span class="text-xs font-mono font-bold text-amber-400 px-2 py-0.5 bg-zinc-950 border border-zinc-800 rounded-none">
                            AUDITADO • Q1
                        </span>
                    </div>

                    <!-- Cuadro EBITDA -->
                    <div class="my-4 p-4 bg-zinc-950 border border-zinc-800 rounded-none flex items-center justify-between">
                        <div>
                            <div class="text-[11px] font-mono uppercase text-zinc-400 font-semibold">EBITDA Estimado Semanal</div>
                            <div class="text-2xl font-mono font-bold text-amber-400 tabular-nums mt-0.5">$2.874.000</div>
                            <div class="text-[11px] font-mono text-zinc-400 mt-1">Margen EBITDA: <span class="text-emerald-400 font-semibold">28.2%</span></div>
                        </div>
                        <div class="text-right font-mono text-xs text-emerald-400">
                            <div class="font-bold text-base">+8.6%</div>
                            <div class="text-[10px] text-zinc-400">vs presupuesto</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs font-mono">
                            <thead>
                                <tr class="text-zinc-400 border-b border-zinc-800">
                                    <th class="py-2 font-semibold">Rubro Financiero</th>
                                    <th class="py-2 text-right font-semibold">Monto</th>
                                    <th class="py-2 text-right font-semibold">% Fact.</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-800 text-zinc-300">
                                <tr>
                                    <td class="py-2 text-white font-medium">Ventas Brutas Totales</td>
                                    <td class="py-2 text-right text-white font-bold tabular-nums">$10.186.000</td>
                                    <td class="py-2 text-right text-zinc-400">100.0%</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-zinc-400">(-) Harinas &amp; Insumos Bio</td>
                                    <td class="py-2 text-right text-rose-400 tabular-nums">-$3.218.700</td>
                                    <td class="py-2 text-right text-zinc-400">31.6%</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-zinc-400">(-) Nómina Obrador &amp; 3 Turnos</td>
                                    <td class="py-2 text-right text-rose-400 tabular-nums">-$2.444.600</td>
                                    <td class="py-2 text-right text-zinc-400">24.0%</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-zinc-400">(-) Electricidad &amp; Gas Hornos</td>
                                    <td class="py-2 text-right text-rose-400 tabular-nums">-$1.018.600</td>
                                    <td class="py-2 text-right text-zinc-400">10.0%</td>
                                </tr>
                                <tr class="bg-zinc-950 font-bold text-white border-t border-zinc-700">
                                    <td class="py-2.5 px-2 text-amber-300">RESULTADO EBITDA OPERACIONAL</td>
                                    <td class="py-2.5 text-right px-2 text-amber-400 tabular-nums">$2.874.000</td>
                                    <td class="py-2.5 text-right px-2 text-amber-400">28.2%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pt-4 border-t border-zinc-800 text-[11px] font-mono text-zinc-400 flex items-center justify-between">
                    <span>Auditoría Contable: PwC Hub</span>
                    <span class="text-zinc-200">ID: VIP-AUD-773</span>
                </div>
            </div>

        </div>

        <!-- 6. TOP 5 MÁS VENDIDOS & DEMANDA EN MOSTRADOR -->
        <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-none">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800 mb-5">
                <div>
                    <h3 class="text-base font-bold tracking-tight text-white uppercase flex items-center space-x-2">
                        <span class="material-symbols-outlined text-amber-400 text-lg leading-none">trending_up</span>
                        <span>Ranking de Productos de Alta Rotación (Top 5 del Obrador)</span>
                    </h3>
                    <p class="text-xs font-mono text-zinc-400 mt-0.5">
                        Volumen despachado, facturación bruta acumulada y tendencia de demanda
                    </p>
                </div>
                <span class="text-xs font-mono text-emerald-400 font-bold px-2.5 py-1 bg-zinc-950 border border-zinc-800">
                    SALA MOSTRADOR + HORECA
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs font-mono">
                    <thead>
                        <tr class="text-zinc-400 border-b border-zinc-800 uppercase tracking-wider text-[11px]">
                            <th class="py-2.5 px-3">Rank</th>
                            <th class="py-2.5 px-4">Producto Maestro</th>
                            <th class="py-2.5 px-4">Categoría</th>
                            <th class="py-2.5 px-4 text-right">Volumen Despachado</th>
                            <th class="py-2.5 px-4 text-right">Facturación Bruta</th>
                            <th class="py-2.5 px-3 text-center">Tendencia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800 text-zinc-200">
                        <?php foreach ($top5Productos as $tp): ?>
                        <tr class="hover:bg-zinc-800/50 transition-none">
                            <td class="py-3 px-3">
                                <span class="w-6 h-6 bg-zinc-800 border border-zinc-700 text-amber-400 font-bold flex items-center justify-center text-xs rounded-none">
                                    #<?php echo $tp['rank']; ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 font-bold text-white">
                                <?php echo htmlspecialchars($tp['nombre']); ?>
                            </td>
                            <td class="py-3 px-4 text-zinc-400 font-sans">
                                <?php echo htmlspecialchars($tp['categoria']); ?>
                            </td>
                            <td class="py-3 px-4 text-right font-bold text-zinc-100 tabular-nums">
                                <?php echo $tp['unidades']; ?>
                            </td>
                            <td class="py-3 px-4 text-right font-bold text-amber-400 tabular-nums">
                                <?php echo formatCurrency($tp['ingresos']); ?>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <span class="px-2 py-0.5 bg-emerald-950 text-emerald-300 border border-emerald-800 text-[10px] font-bold">
                                    <?php echo $tp['tendencia']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 7. REGISTRO DE AUDITORÍA Y ACTIVIDAD OPERACIONAL EN TIEMPO REAL -->
        <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-none text-xs text-zinc-300">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800 mb-4">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 bg-emerald-400 rounded-none"></span>
                    <span class="font-bold text-white uppercase font-mono tracking-wider">Bitácora de Auditoría y Eventos Críticos</span>
                </div>
                <span class="text-[11px] font-mono text-zinc-400">PostgreSQL 15 / Sincronizado</span>
            </div>
            <div class="space-y-2 text-xs font-mono text-zinc-400">
                <?php 
                $dbLogs = AuditService::getRecentLogs(4);
                foreach ($dbLogs as $log): 
                ?>
                <p class="flex items-center space-x-2">
                    <span class="text-zinc-500 font-bold">[<?php echo htmlspecialchars($log['time']); ?>]</span>
                    <span class="text-amber-400 font-semibold">[<?php echo htmlspecialchars($log['module']); ?>]</span>
                    <span class="text-zinc-200"><?php echo htmlspecialchars($log['detail']); ?></span>
                </p>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
