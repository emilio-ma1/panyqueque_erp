<?php
/**
 * Portal Principal / Obrador Central y Catálogo de Producción
 * Panadería y Pastelería Pan y Queque
 * Diseñado bajo los estándares del Atelier Architectural ERP (Plantilla/stitch_bakery_erp_system)
 */
$currentPage = 'inicio';
$pageTitle = 'Obrador Central y Catálogo';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/ProductService.php';
require_once __DIR__ . '/../includes/AuthService.php';

AuthService::requireAuth();

$activeProducts = ProductService::getActiveProducts();
?>

<!-- CONTENEDOR PRINCIPAL: INICIO & CATÁLOGO GENERAL (MODO CLARO SÓLIDO) -->
<div class="p-4 sm:p-6 lg:p-8 max-w-[1536px] mx-auto space-y-6">

    <!-- 1. ENCABEZADO CORPORATIVO DIRECTO (SIN BADGES NI PÍLDORAS) -->
    <section class="bg-white border border-slate-200 p-6 sm:p-8 rounded-none shadow-none">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2.5 h-2.5 bg-amber-700 rounded-none inline-block"></span>
                    <span class="text-xs font-mono font-bold uppercase tracking-wider text-amber-700">PLANTA CENTRAL #01 // DIVISIÓN OPERATIVA</span>
                    <span class="text-slate-400 font-mono">/</span>
                    <span class="text-xs font-mono text-slate-600 font-medium">CATÁLOGO MAESTRO V4.8</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    Obrador Central y Catálogo de Producción
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 mt-2 max-w-4xl leading-relaxed">
                    Sistema de planificación y despacho mayorista para pastelería de autor y panadería tradicional con fermentación prolongada. Supervisión de recetas maestras, lotes de alta gama y abastecimiento HORECA.
                </p>
            </div>

            <!-- Botones Rectangulares de Acceso Directo (Zero-Pill) -->
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="pos.php" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold uppercase tracking-wider rounded-none flex items-center space-x-1.5 transition-none">
                    <span class="material-symbols-outlined text-sm">point_of_sale</span>
                    <span>Abrir Terminal Táctil (POS)</span>
                </a>
                <a href="dashboard.php" class="px-5 py-2.5 bg-amber-700 hover:bg-amber-800 text-white text-xs font-semibold uppercase tracking-wider rounded-none flex items-center space-x-1.5 transition-none">
                    <span class="material-symbols-outlined text-sm">insights</span>
                    <span>Dashboard Gerencial</span>
                </a>
            </div>
        </div>

        <!-- Indicadores Rápidos de la Mañana (Telemetría Sólida) -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 pt-6 border-t border-slate-200">
            <div class="bg-slate-50 border border-slate-200 p-4 rounded-none">
                <div class="text-xs font-mono text-slate-500 uppercase">Capacidad Actual</div>
                <div class="text-2xl font-bold text-slate-900 font-mono mt-1 tabular-nums">1.840 kg</div>
                <div class="text-xs text-slate-600 mt-1">Harinas procesadas hoy</div>
            </div>
            <div class="bg-slate-50 border border-slate-200 p-4 rounded-none">
                <div class="text-xs font-mono text-slate-500 uppercase">Lotes Fermentando</div>
                <div class="text-2xl font-bold text-slate-900 font-mono mt-1 tabular-nums">42 Lotes</div>
                <div class="text-xs text-slate-600 mt-1">Cámaras frías a 4°C</div>
            </div>
            <div class="bg-slate-50 border border-slate-200 p-4 rounded-none">
                <div class="text-xs font-mono text-slate-500 uppercase">Órdenes HORECA</div>
                <div class="text-2xl font-bold text-slate-900 font-mono mt-1 tabular-nums">28 Pedidos</div>
                <div class="text-xs text-slate-600 mt-1">Hoteles y restaurantes</div>
            </div>
            <div class="bg-slate-50 border border-slate-200 p-4 rounded-none">
                <div class="text-xs font-mono text-slate-500 uppercase">Eficiencia Térmica</div>
                <div class="text-2xl font-bold text-emerald-700 font-mono mt-1 tabular-nums">94.2%</div>
                <div class="text-xs text-slate-600 mt-1">Hornos de solera de piedra</div>
            </div>
        </div>
    </section>

    <!-- 2. MÓDULOS DEL SISTEMA: 4 PANELES ARQUITECTÓNICOS RECTILÍNEOS -->
    <section class="space-y-3">
        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
            <h2 class="text-xs font-mono uppercase tracking-wider text-slate-700 font-bold">
                Módulos Integrados del Sistema ERP
            </h2>
            <span class="text-xs font-mono text-slate-500">4 Unidades Funcionales Activas</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Módulo 01: POS -->
            <div class="bg-white border border-slate-200 p-5 rounded-none flex flex-col justify-between hover:border-slate-400 transition-none">
                <div>
                    <div class="flex items-center justify-between text-xs font-mono mb-2">
                        <span class="text-slate-500 font-semibold">MÓDULO 02</span>
                        <span class="bg-slate-100 text-slate-800 px-2 py-0.5 border border-slate-300 font-semibold">SALA DE VENTAS</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 tracking-tight">Punto de Venta (POS)</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Terminal táctil para mostrador con catálogo visual, emisión de boletas tributarias, lector de códigos y cuadratura de caja.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-mono text-emerald-700 font-semibold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-none inline-block"></span> Caja #02 Activa
                    </span>
                    <a href="pos.php" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-mono font-medium rounded-none">
                        Abrir POS ›
                    </a>
                </div>
            </div>

            <!-- Módulo 02: Proveedores -->
            <div class="bg-white border border-slate-200 p-5 rounded-none flex flex-col justify-between hover:border-slate-400 transition-none">
                <div>
                    <div class="flex items-center justify-between text-xs font-mono mb-2">
                        <span class="text-slate-500 font-semibold">MÓDULO 03</span>
                        <span class="bg-slate-100 text-slate-800 px-2 py-0.5 border border-slate-300 font-semibold">SUMINISTRO</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 tracking-tight">Proveedores &amp; Finanzas</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Control de materias primas críticas (harinas, levaduras, mantequillas), emisión de órdenes de compra y balances de devengo.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-mono text-slate-500">Gestión de Insumos</span>
                    <a href="suppliers.php" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-mono font-medium rounded-none">
                        Gestionar ›
                    </a>
                </div>
            </div>

            <!-- Módulo 03: Logística -->
            <div class="bg-white border border-slate-200 p-5 rounded-none flex flex-col justify-between hover:border-slate-400 transition-none">
                <div>
                    <div class="flex items-center justify-between text-xs font-mono mb-2">
                        <span class="text-slate-500 font-semibold">MÓDULO 04</span>
                        <span class="bg-slate-100 text-slate-800 px-2 py-0.5 border border-slate-300 font-semibold">DISTRIBUCIÓN</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 tracking-tight">Logística &amp; Rutas</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Monitoreo de hojas de ruta, trazabilidad de cadena de frío en furgones refrigerados y confirmación de albaranes HORECA.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-mono text-amber-700 font-semibold">+3.8°C Estable</span>
                    <a href="dispatch.php" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-mono font-medium rounded-none">
                        Ver Rutas ›
                    </a>
                </div>
            </div>

            <!-- Módulo 04: Dashboard Ejecutivo -->
            <div class="bg-zinc-900 border border-zinc-800 text-white p-5 rounded-none flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between text-xs font-mono mb-2">
                        <span class="text-amber-400 font-semibold">MÓDULO 05</span>
                        <span class="bg-amber-950 text-amber-300 border border-amber-800 px-2 py-0.5 font-semibold">ALTA DIRECCIÓN</span>
                    </div>
                    <h3 class="text-lg font-bold text-white tracking-tight">Dashboard Ejecutivo</h3>
                    <p class="text-xs text-zinc-400 mt-2 leading-relaxed">
                        Consolidado gerencial en tiempo real, márgenes de explotación, mermas de obrador y telemetría de hornos de solera.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-zinc-800 flex items-center justify-between">
                    <span class="text-xs font-mono text-emerald-400 font-bold">Métricas en Línea</span>
                    <a href="dashboard.php" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-mono font-bold rounded-none">
                        Abrir Dashboard ›
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. CATÁLOGO MAESTRO DE PRODUCTOS DINÁMICO (DESDE BASE DE DATOS) -->
    <section class="space-y-4">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-300 pb-3">
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-slate-900">Catálogo Maestro de Productos</h2>
                <p class="text-xs text-slate-500 mt-0.5">Control de SKU, stock disponible y precios mayoristas activos en base de datos</p>
            </div>
            <!-- Filtros de Categoría Rectangulares -->
            <div class="flex flex-wrap items-center gap-1.5" id="catalog-filters">
                <button type="button" onclick="filterCatalog('ALL', this)" class="catalog-filter-btn px-3 py-1.5 bg-slate-900 text-white text-xs font-mono font-semibold rounded-none border border-slate-900">
                    [TODOS]
                </button>
                <button type="button" onclick="filterCatalog('PAN', this)" class="catalog-filter-btn px-3 py-1.5 bg-white text-slate-700 hover:bg-slate-50 text-xs font-mono font-semibold rounded-none border border-slate-300">
                    [PANADERÍA]
                </button>
                <button type="button" onclick="filterCatalog('PAS', this)" class="catalog-filter-btn px-3 py-1.5 bg-white text-slate-700 hover:bg-slate-50 text-xs font-mono font-semibold rounded-none border border-slate-300">
                    [PASTELERÍA]
                </button>
                <button type="button" onclick="filterCatalog('ROT', this)" class="catalog-filter-btn px-3 py-1.5 bg-white text-slate-700 hover:bg-slate-50 text-xs font-mono font-semibold rounded-none border border-slate-300">
                    [ROTISERÍA &amp; SALADOS]
                </button>
            </div>
        </div>

        <!-- Grid de Tarjetas Sólidas Rectangulares (Zero-Pill) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="catalog-grid">
            <?php foreach ($activeProducts as $prod): 
                $catCode = 'PAN';
                if (stripos($prod['categoria'], 'Pastelería') !== false) $catCode = 'PAS';
                elseif (stripos($prod['categoria'], 'Rotisería') !== false || stripos($prod['categoria'], 'Bollería') !== false) $catCode = 'ROT';
                
                $skuCode = 'SKU: ' . $catCode . '-0' . str_pad((string)$prod['id'], 2, '0', STR_PAD_LEFT);
                $stockStatus = ($prod['stock'] > 50) ? 'STOCK ALTO' : (($prod['stock'] > 15) ? 'STOCK MEDIO' : 'STOCK LIMITADO');
                $stockColor = ($prod['stock'] > 50) ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : (($prod['stock'] > 15) ? 'bg-amber-50 text-amber-900 border-amber-300' : 'bg-rose-50 text-rose-800 border-rose-300');
            ?>
            <div class="catalog-card bg-white border border-slate-200 p-4 rounded-none flex flex-col justify-between hover:border-slate-400 transition-none" data-cat="<?php echo $catCode; ?>">
                <div>
                    <div class="flex items-center justify-between text-xs font-mono mb-2">
                        <span class="bg-slate-900 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-none"><?php echo $skuCode; ?></span>
                        <span class="<?php echo $stockColor; ?> border text-[10px] font-bold px-1.5 py-0.5 rounded-none"><?php echo $stockStatus; ?> (<?php echo $prod['stock']; ?> <?php echo htmlspecialchars($prod['unidad']); ?>)</span>
                    </div>
                    <div class="text-3xl my-2 p-3 bg-slate-50 border border-slate-100 text-center"><?php echo $prod['icono']; ?></div>
                    <h3 class="font-bold text-slate-900 text-sm leading-snug"><?php echo htmlspecialchars($prod['nombre']); ?></h3>
                    <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">
                        <?php echo htmlspecialchars($prod['descripcion']); ?>
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-slate-500 font-mono block uppercase">Precio</span>
                        <span class="text-base font-bold text-slate-900 font-mono tabular-nums">
                            <?php echo formatCurrency($prod['precio']); ?> / <?php echo htmlspecialchars($prod['unidad']); ?>
                        </span>
                    </div>
                    <a href="pos.php" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-mono font-semibold rounded-none">
                        Venta POS
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 4. FÓRMULAS MAESTRAS & PORCENTAJES DE PANADERO -->
    <section class="bg-white border border-slate-200 p-6 sm:p-8 rounded-none">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-200 pb-4 mb-6">
            <div>
                <div class="text-xs font-mono uppercase text-amber-700 font-bold tracking-wider">ESPECIFICACIONES DE FERMENTACIÓN &amp; MEZCLA</div>
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight mt-0.5">Fórmulas Maestras y Porcentajes de Panadero</h2>
                <p class="text-xs text-slate-500 mt-0.5">Parámetros reológicos, índice de hidratación y tiempos de fermentación controlada en bloque</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1.5 bg-slate-100 border border-slate-300 text-slate-800 text-xs font-mono font-semibold rounded-none">
                    Lotes en Cámara: 42 Lotes
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 font-mono uppercase font-semibold border-b border-slate-300">
                        <th class="py-3 px-4">Fórmula / Producto</th>
                        <th class="py-3 px-4">Tipo Harina</th>
                        <th class="py-3 px-3 text-right">Hidratación</th>
                        <th class="py-3 px-3 text-right">Masa Madre</th>
                        <th class="py-3 px-3 text-right">Sal</th>
                        <th class="py-3 px-4">Fermentación Bloque</th>
                        <th class="py-3 px-4">Temp. Horneado</th>
                        <th class="py-3 px-4 text-center">Estado Lote</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 font-mono">
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4 font-bold text-slate-900 font-sans">Marraqueta de Solera</td>
                        <td class="py-3 px-4 text-slate-600">Trigo Seleccionado T65</td>
                        <td class="py-3 px-3 text-right font-bold text-slate-900 tabular-nums">78.5%</td>
                        <td class="py-3 px-3 text-right text-slate-700 tabular-nums">25.0%</td>
                        <td class="py-3 px-3 text-right text-slate-700 tabular-nums">2.0%</td>
                        <td class="py-3 px-4 text-slate-600">36 horas (4°C)</td>
                        <td class="py-3 px-4 font-bold text-amber-800">245°C Vapor</td>
                        <td class="py-3 px-4 text-center"><span class="bg-emerald-50 text-emerald-800 border border-emerald-300 px-2 py-0.5 text-[10px] font-bold">HORNEANDO</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4 font-bold text-slate-900 font-sans">Hallulla Especial de Solera</td>
                        <td class="py-3 px-4 text-slate-600">Trigo Blanco Flor + Manteca</td>
                        <td class="py-3 px-3 text-right font-bold text-slate-900 tabular-nums">54.0%</td>
                        <td class="py-3 px-3 text-right text-slate-700 tabular-nums">15.0%</td>
                        <td class="py-3 px-3 text-right text-slate-700 tabular-nums">2.2%</td>
                        <td class="py-3 px-4 text-slate-600">12 horas (8°C)</td>
                        <td class="py-3 px-4 font-bold text-amber-800">230°C Seco</td>
                        <td class="py-3 px-4 text-center"><span class="bg-emerald-50 text-emerald-800 border border-emerald-300 px-2 py-0.5 text-[10px] font-bold">HORNEANDO</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4 font-bold text-slate-900 font-sans">Croissant AOP Isigny</td>
                        <td class="py-3 px-4 text-slate-600">Harina de Fuerza T45 + 84% MG</td>
                        <td class="py-3 px-3 text-right font-bold text-slate-900 tabular-nums">60.0%</td>
                        <td class="py-3 px-3 text-right text-slate-700 tabular-nums">Poolish 20%</td>
                        <td class="py-3 px-3 text-right text-slate-700 tabular-nums">1.8%</td>
                        <td class="py-3 px-4 text-slate-600">24 horas (2°C)</td>
                        <td class="py-3 px-4 font-bold text-amber-800">190°C Rotativo</td>
                        <td class="py-3 px-4 text-center"><span class="bg-amber-50 text-amber-800 border border-amber-300 px-2 py-0.5 text-[10px] font-bold">EN REPOSO</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4 font-bold text-slate-900 font-sans">Baguette Tradición Francesa</td>
                        <td class="py-3 px-4 text-slate-600">Harina T65 Label Rouge</td>
                        <td class="py-3 px-3 text-right font-bold text-slate-900 tabular-nums">75.0%</td>
                        <td class="py-3 px-3 text-right text-slate-700 tabular-nums">Levain 20%</td>
                        <td class="py-3 px-3 text-right text-slate-700 tabular-nums">1.9%</td>
                        <td class="py-3 px-4 text-slate-600">28 horas (5°C)</td>
                        <td class="py-3 px-4 font-bold text-amber-800">250°C Vapor</td>
                        <td class="py-3 px-4 text-center"><span class="bg-emerald-50 text-emerald-800 border border-emerald-300 px-2 py-0.5 text-[10px] font-bold">HORNEANDO</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

</div>

<!-- Script interactivo de filtrado de catálogo -->
<script>
    function filterCatalog(cat, btn) {
        document.querySelectorAll('.catalog-filter-btn').forEach(b => {
            b.classList.remove('bg-slate-900', 'text-white', 'border-slate-900');
            b.classList.add('bg-white', 'text-slate-700', 'border-slate-300');
        });
        btn.classList.remove('bg-white', 'text-slate-700', 'border-slate-300');
        btn.classList.add('bg-slate-900', 'text-white', 'border-slate-900');

        const cards = document.querySelectorAll('.catalog-card');
        cards.forEach(card => {
            if (cat === 'ALL' || card.getAttribute('data-cat') === cat) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
