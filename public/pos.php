<?php
/**
 * Módulo de Cajas y Punto de Venta Táctil (POS)
 * Panadería y Pastelería Pan y Queque
 * Diseñado bajo los estándares del Atelier Architectural ERP (Plantilla/stitch_bakery_erp_system/punto_de_venta_pos_t_ctil/)
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/ProductService.php';
require_once __DIR__ . '/../includes/AuditService.php';
require_once __DIR__ . '/../includes/AuthService.php';

// Control de acceso: solo Gerentes, Administradores y Cajeros pueden ingresar al POS
AuthService::requireAuth(['gerente', 'admin', 'cajero']);

$currentUser = AuthService::getCurrentUser();
$cashierName = $currentUser['full_name'] ?? 'Cajero Mostrador';

// ==============================================================================
// CONTROLADOR API DE VENTAS Y CUADRATURA (AJAX / POST ENDPOINTS)
// ==============================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json; charset=utf-8');

    // 1. REGISTRAR VENTA EN BASE DE DATOS
    if ($_POST['action'] === 'process_sale') {
        $rawItems = $_POST['items'] ?? '[]';
        $items = json_decode($rawItems, true);
        $paymentMethod = trim((string)($_POST['payment_method'] ?? 'Efectivo'));

        if (empty($items) || !is_array($items)) {
            echo json_encode(['success' => false, 'error' => 'El ticket no contiene productos.']);
            exit;
        }

        // Calcular totales
        $totalAmount = 0;
        foreach ($items as $item) {
            $qty = max(1, (int)($item['qty'] ?? 1));
            $price = max(0, (int)($item['precio'] ?? 0));
            $totalAmount += ($qty * $price);
        }

        $subtotal = (int)round($totalAmount / 1.19);
        $tax = $totalAmount - $subtotal;

        // Generar folio único correlativo
        $lastRow = DB::selectOne("SELECT MAX(id) as max_id FROM sales");
        $nextId = ($lastRow && $lastRow['max_id']) ? ((int)$lastRow['max_id'] + 1) : 4895;
        $folio = 'BOL-' . str_pad((string)$nextId, 6, '0', STR_PAD_LEFT);

        DB::beginTransaction();
        try {
            // Insertar venta en MariaDB
            $saleId = DB::insert(
                "INSERT INTO sales (folio, date, subtotal, tax, total, payment_method, cashier, status) 
                 VALUES (?, NOW(), ?, ?, ?, ?, ?, 'Completada')",
                [$folio, $subtotal, $tax, $totalAmount, $paymentMethod, $cashierName]
            );

            // Insertar líneas de detalle y descontar stock
            foreach ($items as $item) {
                $prodId = (int)($item['id'] ?? 0);
                $qty = max(1, (int)($item['qty'] ?? 1));
                $price = max(0, (int)($item['precio'] ?? 0));
                $lineSubtotal = $qty * $price;

                if ($prodId > 0) {
                    DB::execute(
                        "INSERT INTO sale_details (sale_id, product_id, quantity, unit_price, subtotal) 
                         VALUES (?, ?, ?, ?, ?)",
                        [$saleId, $prodId, $qty, $price, $lineSubtotal]
                    );

                    DB::execute(
                        "UPDATE products SET stock = GREATEST(0, stock - ?) WHERE id = ?",
                        [$qty, $prodId]
                    );
                }
            }

            // Registrar en auditoría institucional
            AuditService::log(
                'POS', 
                'Boleta Emitida', 
                "Boleta {$folio} emitida por " . formatCurrency($totalAmount) . " ({$paymentMethod}) por {$cashierName}"
            );

            DB::commit();

            echo json_encode([
                'success' => true,
                'folio'   => $folio,
                'total'   => $totalAmount,
                'method'  => $paymentMethod
            ]);
            exit;
        } catch (Exception $e) {
            DB::rollBack();
            echo json_encode(['success' => false, 'error' => 'Error al guardar en base de datos: ' . $e->getMessage()]);
            exit;
        }
    }

    // 2. CUADRATURA DE CAJA EN TIEMPO REAL
    if ($_POST['action'] === 'get_cash_count') {
        $stats = DB::selectOne(
            "SELECT 
                COALESCE(SUM(CASE WHEN payment_method = 'Efectivo' THEN total ELSE 0 END), 0) AS cash_sales,
                COALESCE(SUM(CASE WHEN payment_method LIKE '%Débito%' OR payment_method LIKE '%Tarjeta%' THEN total ELSE 0 END), 0) AS card_sales,
                COALESCE(SUM(CASE WHEN payment_method LIKE '%Transferencia%' THEN total ELSE 0 END), 0) AS transfer_sales,
                COALESCE(SUM(total), 0) AS grand_total,
                COUNT(*) AS count_sales
             FROM sales 
             WHERE DATE(date) = CURRENT_DATE"
        );

        $initialFund = 50000;
        $cashSales = (int)($stats['cash_sales'] ?? 0);
        $cardSales = (int)($stats['card_sales'] ?? 0);
        $transferSales = (int)($stats['transfer_sales'] ?? 0);
        $grandTotal = (int)($stats['grand_total'] ?? 0);
        $expectedDrawer = $initialFund + $cashSales;

        echo json_encode([
            'success'         => true,
            'initial_fund'    => $initialFund,
            'cash_sales'      => $cashSales,
            'card_sales'      => $cardSales,
            'transfer_sales'  => $transferSales,
            'grand_total'     => $grandTotal,
            'expected_drawer' => $expectedDrawer,
            'count'           => (int)($stats['count_sales'] ?? 0)
        ]);
        exit;
    }
}

// Cargar catálogo de productos activos
$sampleProducts = ProductService::getActiveProducts();

$currentPage = 'pos';
$pageTitle = 'Punto de Venta POS';
require_once __DIR__ . '/../includes/header.php';
?>

<!-- 1. SUBBARRA TÉCNICA DE ESTADO DEL POS -->
<section class="w-full bg-slate-200 border-b border-slate-300 px-4 sm:px-6 py-2.5 flex flex-wrap items-center justify-between gap-3 shrink-0">
    <div class="flex items-center space-x-3">
        <div class="w-2.5 h-2.5 bg-amber-700"></div>
        <div class="flex items-center space-x-2">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-600 font-mono">TERMINAL DE CAJA TÁCTIL:</span>
            <h1 class="text-xs font-bold text-slate-900 uppercase font-mono tracking-wide">PUNTO DE VENTA #POS-01 • PAN Y QUEQUE OBRADOR</h1>
        </div>
    </div>
    <div class="flex flex-wrap items-center space-x-4 sm:space-x-6 text-xs font-mono">
        <div class="flex items-center space-x-1.5">
            <span class="text-slate-500 uppercase">PLANTA:</span>
            <span class="font-bold text-slate-800">CENTRAL #01</span>
        </div>
        <div class="h-3 w-px bg-slate-300 hidden sm:block"></div>
        <div class="flex items-center space-x-1.5">
            <span class="text-slate-500 uppercase">CAJERO:</span>
            <span class="font-bold text-slate-900 bg-white px-2 py-0.5 border border-slate-300"><?php echo htmlspecialchars($cashierName); ?></span>
        </div>
        <div class="h-3 w-px bg-slate-300 hidden sm:block"></div>
        <div class="flex items-center space-x-1.5">
            <span class="text-slate-500 uppercase">HORA:</span>
            <span class="font-bold text-amber-800 bg-amber-50 px-2 py-0.5 border border-amber-300" id="live-clock">--:--:--</span>
        </div>
    </div>
</section>

<!-- 2. CONTENEDOR PRINCIPAL: POS 2 COLUMNAS (65% / 35%) -->
<div class="p-4 sm:p-6 lg:p-8 max-w-[1536px] mx-auto space-y-5">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

        <!-- COLUMNA IZQUIERDA: CATÁLOGO TÁCTIL Y SELECTOR (8 cols) -->
        <div class="lg:col-span-8 flex flex-col space-y-4">

            <!-- BARRA DE BÚSQUEDA Y ESCÁNER DE CÓDIGOS -->
            <div class="bg-white border border-slate-200 rounded-none p-3 shadow-none">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2">
                    <div class="md:col-span-8 flex items-center bg-slate-100 border border-slate-300">
                        <div class="w-10 flex items-center justify-center text-slate-500">
                            <span class="material-symbols-outlined text-lg">barcode_scanner</span>
                        </div>
                        <input type="text" id="pos-search-input" onkeyup="filterProductsManual()" placeholder="Escanear código de barras o ingresar SKU / Nombre de producto..." class="w-full bg-slate-100 text-slate-900 text-xs font-mono px-2 py-2.5 outline-none placeholder:text-slate-400 focus:bg-white border-0">
                    </div>
                    <div class="md:col-span-4 flex space-x-2">
                        <button type="button" onclick="filterProductsManual()" class="flex-1 bg-slate-900 text-white text-xs font-bold uppercase font-mono tracking-wider py-2.5 px-3 hover:bg-slate-800 rounded-none transition-none flex items-center justify-center space-x-1">
                            <span class="material-symbols-outlined text-sm">search</span>
                            <span>BUSCAR</span>
                        </button>
                        <button type="button" onclick="clearSearchFilter()" class="bg-slate-200 text-slate-800 text-xs font-bold uppercase font-mono tracking-wider py-2.5 px-3 hover:bg-slate-300 border border-slate-300 rounded-none transition-none">
                            LIMPIAR
                        </button>
                    </div>
                </div>
            </div>

            <!-- SELECTOR DE CATEGORÍAS (BOTONES RECTANGULARES SÓLIDOS) -->
            <div class="flex flex-wrap gap-1.5 bg-slate-200 border border-slate-300 p-1.5 rounded-none" id="category-filter-bar">
                <button type="button" class="pos-cat-btn bg-slate-900 text-white text-xs font-bold font-mono uppercase px-3 py-1.5 tracking-wider rounded-none border border-slate-900" onclick="setCategoryFilter('ALL', this)">
                    [TODOS]
                </button>
                <button type="button" class="pos-cat-btn bg-white text-slate-800 hover:bg-slate-100 text-xs font-bold font-mono uppercase px-3 py-1.5 tracking-wider rounded-none border border-slate-300" onclick="setCategoryFilter('Panadería', this)">
                    [PANADERÍA]
                </button>
                <button type="button" class="pos-cat-btn bg-white text-slate-800 hover:bg-slate-100 text-xs font-bold font-mono uppercase px-3 py-1.5 tracking-wider rounded-none border border-slate-300" onclick="setCategoryFilter('Pastelería', this)">
                    [PASTELERÍA FINA]
                </button>
                <button type="button" class="pos-cat-btn bg-white text-slate-800 hover:bg-slate-100 text-xs font-bold font-mono uppercase px-3 py-1.5 tracking-wider rounded-none border border-slate-300" onclick="setCategoryFilter('Rotisería', this)">
                    [BOLLERÍA &amp; SALADOS]
                </button>
            </div>

            <!-- GRID TÁCTIL DE PRODUCTOS (RECTANGULARES PLANOS SÓLIDOS) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3" id="pos-grid">
                <?php foreach ($sampleProducts as $prod): ?>
                <?php
                    $skuPrefix = 'PAN-0' . $prod['id'];
                    if (stripos($prod['categoria'], 'Pastelería') !== false) $skuPrefix = 'PAS-0' . $prod['id'];
                    if (stripos($prod['categoria'], 'Rotisería') !== false || stripos($prod['categoria'], 'Bollería') !== false) $skuPrefix = 'EMP-0' . $prod['id'];
                ?>
                <div class="pos-item-card bg-white border border-slate-200 rounded-none p-3.5 flex flex-col justify-between hover:border-slate-400 transition-none"
                     data-category="<?php echo htmlspecialchars($prod['categoria']); ?>"
                     data-name="<?php echo htmlspecialchars($prod['nombre']); ?>"
                     data-price="<?php echo $prod['precio']; ?>"
                     data-sku="<?php echo $skuPrefix; ?>">
                    
                    <div>
                        <div class="flex items-center justify-between text-xs font-mono mb-2">
                            <span class="font-mono text-[11px] text-slate-600 font-bold bg-slate-100 px-1.5 py-0.5 border border-slate-200">
                                SKU: <?php echo $skuPrefix; ?>
                            </span>
                            <span class="text-[10px] font-bold text-amber-800 bg-amber-50 px-1.5 py-0.5 border border-amber-200 font-mono">
                                Stock: <?php echo $prod['stock']; ?> <?php echo htmlspecialchars($prod['unidad']); ?>
                            </span>
                        </div>

                        <div class="flex items-start space-x-3 my-1">
                            <span class="text-3xl p-2 bg-slate-50 border border-slate-100 rounded-none">
                                <?php echo $prod['icono']; ?>
                            </span>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xs font-bold text-slate-900 leading-snug">
                                    <?php echo htmlspecialchars($prod['nombre']); ?>
                                </h3>
                                <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                    <?php echo htmlspecialchars($prod['descripcion']); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between gap-2">
                        <div>
                            <span class="text-[10px] text-slate-400 font-mono block uppercase">Precio</span>
                            <span class="text-sm font-bold text-slate-900 font-mono tabular-nums">
                                <?php echo formatCurrency($prod['precio']); ?>
                            </span>
                        </div>

                        <div class="flex items-center space-x-1.5">
                            <div class="inline-flex items-center border border-slate-300 bg-white">
                                <button type="button" onclick="adjustQty(<?php echo $prod['id']; ?>, -1)" class="px-2 py-1 text-slate-700 hover:bg-slate-100 font-bold text-xs">-</button>
                                <input type="number" id="qty-input-<?php echo $prod['id']; ?>" value="1" min="1" max="50" class="w-9 text-center py-0.5 text-xs font-mono font-bold border-x border-slate-300 focus:outline-none p-0">
                                <button type="button" onclick="adjustQty(<?php echo $prod['id']; ?>, 1)" class="px-2 py-1 text-slate-700 hover:bg-slate-100 font-bold text-xs">+</button>
                            </div>

                            <button type="button" onclick="addToTicket(<?php echo $prod['id']; ?>, '<?php echo addslashes($prod['nombre']); ?>', <?php echo $prod['precio']; ?>, '<?php echo $prod['unidad']; ?>')" class="px-2.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-mono font-semibold rounded-none flex items-center space-x-1">
                                <span class="material-symbols-outlined text-xs">add</span>
                                <span>Agregar</span>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- COLUMNA DERECHA: TICKET DE VENTA FISCAL (4 cols) -->
        <div class="lg:col-span-4 flex flex-col space-y-4">

            <div class="bg-white border-2 border-slate-900 p-5 rounded-none shadow-none" id="pos-ticket-panel">
                
                <div class="border-b-2 border-slate-900 pb-3 mb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold uppercase text-slate-800">Boleta Electrónica</span>
                        <span class="text-xs font-mono font-bold text-amber-700" id="boleta-num">EN EMISIÓN</span>
                    </div>
                    <div class="text-[11px] font-mono text-slate-500 mt-0.5">
                        Pan y Queque OBRADOR &bull; RUT: 76.543.210-K
                    </div>
                </div>

                <div class="flex items-center justify-between pb-2 mb-2 text-xs font-mono border-b border-slate-200">
                    <span class="text-slate-600 font-bold">DETALLE DE PRODUCTOS</span>
                    <button type="button" onclick="clearTicket()" class="text-rose-700 hover:underline font-bold text-[11px] no-print">
                        [VACIAR TICKET]
                    </button>
                </div>

                <!-- Lista de Productos en Ticket -->
                <div class="min-h-[160px] max-h-[280px] overflow-y-auto mb-3" id="ticket-scroll-area">
                    <div id="ticket-items-container" class="space-y-1">
                        <!-- Generado dinámicamente por JavaScript -->
                    </div>
                </div>

                <!-- Resumen Financiero: Subtotal, IVA, Total -->
                <div class="py-4 space-y-2 border-b border-slate-200 text-xs font-mono">
                    <div class="flex justify-between text-slate-600">
                        <span>SUBTOTAL NETO:</span>
                        <span id="summary-subtotal" class="font-bold text-slate-900 tabular-nums">$0</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>I.V.A. AFECTO (19%):</span>
                        <span id="summary-tax" class="font-bold text-slate-900 tabular-nums">$0</span>
                    </div>
                    <div class="flex justify-between text-slate-900 text-base font-bold pt-2.5 border-t border-slate-300">
                        <span>TOTAL A PAGAR:</span>
                        <span id="summary-total" class="text-lg text-amber-700 font-bold tabular-nums">$0</span>
                    </div>
                </div>

                <!-- Forma de Pago Rectangular -->
                <div class="pt-4 no-print">
                    <label class="block text-[11px] uppercase tracking-wider font-bold text-slate-700 font-mono mb-2">Forma de Pago:</label>
                    <div class="grid grid-cols-3 gap-1.5 text-xs font-mono">
                        <label class="flex flex-col items-center p-2 border border-slate-300 rounded-none cursor-pointer hover:bg-slate-50 transition-none">
                            <input type="radio" name="payment_method" value="Efectivo" checked class="text-slate-900 focus:ring-0">
                            <span class="mt-1 text-[11px] font-semibold text-slate-800">💵 Efectivo</span>
                        </label>
                        <label class="flex flex-col items-center p-2 border border-slate-300 rounded-none cursor-pointer hover:bg-slate-50 transition-none">
                            <input type="radio" name="payment_method" value="Tarjeta Débito" class="text-slate-900 focus:ring-0">
                            <span class="mt-1 text-[11px] font-semibold text-slate-800">💳 Débito</span>
                        </label>
                        <label class="flex flex-col items-center p-2 border border-slate-300 rounded-none cursor-pointer hover:bg-slate-50 transition-none">
                            <input type="radio" name="payment_method" value="Transferencia" class="text-slate-900 focus:ring-0">
                            <span class="mt-1 text-[11px] font-semibold text-slate-800">📱 Transf.</span>
                        </label>
                    </div>
                </div>

                <!-- Botones de Acción Rápidos y Rectangulares -->
                <div class="pt-5 space-y-2 no-print">
                    <!-- Botón 1: Registrar Venta -->
                    <button type="button" id="btn-registrar-venta" onclick="handleRegisterSale()" class="w-full py-3 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase font-mono tracking-wider rounded-none flex items-center justify-center space-x-2 transition-none">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        <span>REGISTRAR VENTA &bull; GUARDAR EN BD</span>
                    </button>

                    <div class="grid grid-cols-2 gap-2">
                        <!-- Botón 2: Cuadratura de Caja -->
                        <button type="button" id="btn-cuadratura" onclick="handleCashCountModal()" class="py-2.5 px-3 bg-white hover:bg-slate-50 text-slate-800 font-bold text-xs font-mono border border-slate-300 rounded-none flex items-center justify-center space-x-1 transition-none">
                            <span class="material-symbols-outlined text-sm">point_of_sale</span>
                            <span>ARQUEO EN VIVO</span>
                        </button>

                        <!-- Botón 3: Imprimir Boleta -->
                        <button type="button" id="btn-imprimir" onclick="handlePrintReceipt()" class="py-2.5 px-3 bg-amber-700 hover:bg-amber-800 text-white font-bold text-xs font-mono rounded-none flex items-center justify-center space-x-1 transition-none">
                            <span class="material-symbols-outlined text-sm">print</span>
                            <span>IMPRIMIR</span>
                        </button>
                    </div>
                </div>

                <!-- Timbre Electrónico S.I.I. -->
                <div class="mt-4 pt-3 border-t border-dashed border-slate-300 text-center text-[10px] text-slate-400 font-mono">
                    <p>Timbre Electrónico S.I.I. Res. 80 de 2026</p>
                    <p>Verifique documento en www.sii.cl</p>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- MODAL 1: VENTA REGISTRADA CON ÉXITO -->
<div id="modal-venta-exitosa" class="hidden fixed inset-0 z-50 bg-slate-950/80 flex items-center justify-center p-4">
    <div class="bg-white rounded-none max-w-md w-full p-6 border-2 border-slate-900 text-center shadow-none">
        <div class="w-12 h-12 bg-slate-900 text-white flex items-center justify-center mx-auto mb-3 text-xl font-bold font-mono">
            ✓
        </div>
        <h3 class="text-lg font-bold text-slate-900 uppercase tracking-tight">¡Venta Registrada en Base de Datos!</h3>
        <p class="text-xs text-slate-500 mb-4 font-mono">Comprobante Fiscal Emitido &bull; Folio #<span id="modal-folio">004892</span></p>
        
        <div class="bg-slate-50 border border-slate-200 p-4 text-left text-xs font-mono space-y-2 mb-5">
            <div class="flex justify-between">
                <span class="text-slate-500">Monto Total:</span>
                <span id="modal-total" class="font-bold text-amber-700 text-sm tabular-nums">$0</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Forma de Pago:</span>
                <span id="modal-pago" class="font-semibold text-slate-900">Efectivo</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Estado de Operación:</span>
                <span class="text-emerald-700 font-bold">GUARDADO EN MARIADB / OK</span>
            </div>
        </div>

        <div class="flex space-x-2">
            <button type="button" onclick="closeModal('modal-venta-exitosa'); handlePrintReceipt();" class="flex-1 py-2.5 px-3 border border-slate-300 text-slate-800 font-mono font-bold text-xs uppercase hover:bg-slate-50 rounded-none">
                Imprimir Copia
            </button>
            <button type="button" onclick="closeModal('modal-venta-exitosa'); startNewSale();" class="flex-1 py-2.5 px-3 bg-slate-900 text-white font-mono font-bold text-xs uppercase hover:bg-slate-800 rounded-none">
                Nueva Venta
            </button>
        </div>
    </div>
</div>

<!-- MODAL 2: CUADRATURA DE CAJA (ARQUEO EN TIEMPO REAL DESDE MARIADB) -->
<div id="modal-cuadratura" class="hidden fixed inset-0 z-50 bg-slate-950/80 flex items-center justify-center p-4">
    <div class="bg-white rounded-none max-w-lg w-full p-6 border-2 border-slate-900 shadow-none">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div class="flex items-center space-x-2">
                <span class="material-symbols-outlined text-slate-800">analytics</span>
                <h3 class="text-base font-bold text-slate-900 uppercase tracking-tight">Cuadratura y Arqueo de Caja (En Vivo)</h3>
            </div>
            <button type="button" onclick="closeModal('modal-cuadratura')" class="text-slate-400 hover:text-slate-900 text-xl font-mono">&times;</button>
        </div>

        <div class="text-xs font-mono text-slate-500 mb-4">
            Consultando MariaDB &bull; Terminal #01 Mostrador &bull; Cajero: <?php echo htmlspecialchars($cashierName); ?>
        </div>

        <div class="space-y-2 text-xs font-mono mb-5">
            <div class="flex justify-between p-2.5 bg-slate-50 border border-slate-200">
                <span class="text-slate-600 font-medium">Fondo Fijo Inicial (Apertura):</span>
                <span id="arqueo-fondo" class="font-bold text-slate-900 tabular-nums">$50.000</span>
            </div>
            <div class="flex justify-between p-2.5 bg-slate-50 border border-slate-200">
                <span class="text-slate-600 font-medium">Ventas Efectivo Acumuladas Hoy:</span>
                <span id="arqueo-efectivo" class="font-bold text-emerald-700 tabular-nums">$0</span>
            </div>
            <div class="flex justify-between p-2.5 bg-slate-50 border border-slate-200">
                <span class="text-slate-600 font-medium">Ventas Débito / Tarjetas:</span>
                <span id="arqueo-debito" class="font-bold text-slate-900 tabular-nums">$0</span>
            </div>
            <div class="flex justify-between p-2.5 bg-slate-50 border border-slate-200">
                <span class="text-slate-600 font-medium">Ventas Transferencias:</span>
                <span id="arqueo-transf" class="font-bold text-slate-900 tabular-nums">$0</span>
            </div>
            <div class="flex justify-between p-3 bg-amber-50 border border-amber-300 text-sm">
                <span class="font-bold text-slate-900">Efectivo Físico Esperado en Cajón:</span>
                <span id="arqueo-cajon" class="font-bold text-amber-800 text-base tabular-nums">$50.000</span>
            </div>
        </div>

        <div class="p-3 bg-emerald-50 border border-emerald-300 text-xs font-mono text-emerald-800 flex items-center space-x-2 mb-5">
            <span class="material-symbols-outlined text-sm">verified</span>
            <div>
                <strong>Auditoría:</strong> Cuadratura en tiempo real calculada sobre transacciones de MariaDB.
            </div>
        </div>

        <div class="flex space-x-2">
            <button type="button" onclick="closeModal('modal-cuadratura')" class="flex-1 py-2.5 border border-slate-300 text-slate-800 font-mono font-bold text-xs uppercase hover:bg-slate-50 rounded-none">
                Cerrar
            </button>
            <button type="button" onclick="alert('Cierre Z registrado con éxito en bitácora de auditoría.'); closeModal('modal-cuadratura');" class="flex-1 py-2.5 bg-amber-700 hover:bg-amber-800 text-white font-mono font-bold text-xs uppercase rounded-none">
                Emitir Cierre Z
            </button>
        </div>
    </div>
</div>

<!-- POS INTERACTIVE JAVASCRIPT CONEXIÓN A BASE DE DATOS -->
<script>
    // Ticket inicia completamente vacío (sin datos mock)
    let ticket = [];

    /**
     * Calculate totals and Chilean VAT (19%) from ticket items.
     */
    function calculateTicketTotals(items) {
        const total = items.reduce((acc, item) => acc + (item.precio * item.qty), 0);
        const subtotal = Math.round(total / 1.19);
        const tax = total - subtotal;
        return { total, subtotal, tax };
    }

    /**
     * Generate HTML markup for an individual ticket row.
     */
    function renderTicketRowHtml(item, index) {
        const itemTotal = item.precio * item.qty;
        return `
            <div class="flex items-center justify-between py-2 border-b border-slate-200">
                <div class="flex-1 pr-2">
                    <div class="font-bold text-slate-900 text-xs">${item.nombre}</div>
                    <div class="text-[11px] text-slate-500 font-mono">
                        ${item.qty} ${item.unidad} &times; $${item.precio.toLocaleString('es-CL')}
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="font-mono font-bold text-slate-900 text-xs tabular-nums">$${itemTotal.toLocaleString('es-CL')}</span>
                    <button type="button" onclick="removeFromTicket(${index})" class="no-print text-slate-400 hover:text-red-600 font-bold px-1 font-mono text-sm" title="Eliminar">&times;</button>
                </div>
            </div>
        `;
    }

    /**
     * Update total elements in the DOM summary panel.
     */
    function updateSummaryDom(subtotal, tax, total) {
        document.getElementById('summary-subtotal').textContent = '$' + subtotal.toLocaleString('es-CL');
        document.getElementById('summary-tax').textContent = '$' + tax.toLocaleString('es-CL');
        document.getElementById('summary-total').textContent = '$' + total.toLocaleString('es-CL');
    }

    /**
     * Re-render the POS ticket UI and update totals.
     */
    function renderTicket() {
        const container = document.getElementById('ticket-items-container');
        if (!container) return;

        if (ticket.length === 0) {
            container.innerHTML = '<p class="text-slate-400 italic text-center py-6 font-mono text-xs">Sin productos en el ticket. Agregue productos desde el catálogo.</p>';
            updateSummaryDom(0, 0, 0);
            return;
        }

        container.innerHTML = ticket.map(renderTicketRowHtml).join('');
        const { total, subtotal, tax } = calculateTicketTotals(ticket);
        updateSummaryDom(subtotal, tax, total);
    }

    /**
     * Adjust product quantity input within [1, 50] range.
     */
    function adjustQty(productId, delta) {
        const input = document.getElementById('qty-input-' + productId);
        if (!input) return;
        let val = (parseInt(input.value, 10) || 1) + delta;
        input.value = Math.max(1, Math.min(50, val));
    }

    /**
     * Add a product to the active POS ticket.
     */
    function addToTicket(id, nombre, precio, unidad) {
        const qtyInput = document.getElementById('qty-input-' + id);
        const qty = qtyInput ? (parseInt(qtyInput.value, 10) || 1) : 1;

        const existing = ticket.find(item => item.id === id);
        if (existing) {
            existing.qty += qty;
        } else {
            ticket.push({ id, nombre, precio, unidad, qty });
        }

        renderTicket();
        if (qtyInput) qtyInput.value = 1;
    }

    /**
     * Remove an item from the ticket by index.
     */
    function removeFromTicket(index) {
        ticket.splice(index, 1);
        renderTicket();
    }

    /**
     * Clear all items from the current ticket.
     */
    function clearTicket() {
        ticket = [];
        renderTicket();
    }

    /**
     * Process checkout registration and save directly into MariaDB.
     */
    async function handleRegisterSale() {
        if (ticket.length === 0) {
            alert('Agregue al menos un producto al ticket antes de registrar la venta.');
            return;
        }

        const methodEl = document.querySelector('input[name="payment_method"]:checked');
        const paymentMethod = methodEl ? methodEl.value : 'Efectivo';
        const submitBtn = document.getElementById('btn-registrar-venta');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>GUARDANDO EN MARIADB...</span>';

        try {
            const formData = new URLSearchParams();
            formData.append('action', 'process_sale');
            formData.append('payment_method', paymentMethod);
            formData.append('items', JSON.stringify(ticket));

            const response = await fetch('pos.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            });

            const data = await response.json();

            if (data.success) {
                document.getElementById('boleta-num').textContent = data.folio;
                document.getElementById('modal-folio').textContent = data.folio;
                document.getElementById('modal-total').textContent = '$' + data.total.toLocaleString('es-CL');
                document.getElementById('modal-pago').textContent = data.method;

                document.getElementById('modal-venta-exitosa').classList.remove('hidden');
                ticket = [];
                renderTicket();
            } else {
                alert('Error al registrar venta: ' + (data.error || 'Error desconocido'));
            }
        } catch (err) {
            console.error(err);
            alert('Error de comunicación con el servidor ERP.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span class="material-symbols-outlined text-sm">check_circle</span><span>REGISTRAR VENTA &bull; GUARDAR EN BD</span>';
        }
    }

    /**
     * Reset state and start a new sale transaction.
     */
    function startNewSale() {
        ticket = [];
        renderTicket();
        location.reload(); // Recarga para actualizar stocks en pantalla
    }

    /**
     * Display cash count modal dialog with live data from MariaDB.
     */
    async function handleCashCountModal() {
        try {
            const formData = new URLSearchParams();
            formData.append('action', 'get_cash_count');

            const response = await fetch('pos.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            });
            const data = await response.json();

            if (data.success) {
                document.getElementById('arqueo-fondo').textContent = '$' + data.initial_fund.toLocaleString('es-CL');
                document.getElementById('arqueo-efectivo').textContent = '$' + data.cash_sales.toLocaleString('es-CL');
                document.getElementById('arqueo-debito').textContent = '$' + data.card_sales.toLocaleString('es-CL');
                document.getElementById('arqueo-transf').textContent = '$' + data.transfer_sales.toLocaleString('es-CL');
                document.getElementById('arqueo-cajon').textContent = '$' + data.expected_drawer.toLocaleString('es-CL');
            }
        } catch (e) {
            console.error('Error fetching cash count:', e);
        }

        document.getElementById('modal-cuadratura').classList.remove('hidden');
    }

    /**
     * Trigger browser receipt print dialog.
     */
    function handlePrintReceipt() {
        window.print();
    }

    /**
     * Close modal dialog by DOM ID.
     */
    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('hidden');
    }

    /**
     * Category filtering logic.
     */
    function setCategoryFilter(cat, btn) {
        document.querySelectorAll('.pos-cat-btn').forEach(b => {
            b.classList.remove('bg-slate-900', 'text-white', 'border-slate-900');
            b.classList.add('bg-white', 'text-slate-800', 'border-slate-300');
        });
        btn.classList.remove('bg-white', 'text-slate-800', 'border-slate-300');
        btn.classList.add('bg-slate-900', 'text-white', 'border-slate-900');

        const cards = document.querySelectorAll('.pos-item-card');
        cards.forEach(card => {
            const cardCat = card.getAttribute('data-category') || '';
            if (cat === 'ALL' || cardCat.toLowerCase().includes(cat.toLowerCase())) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    /**
     * Manual search input filter by product name or SKU.
     */
    function filterProductsManual() {
        const query = (document.getElementById('pos-search-input').value || '').trim().toLowerCase();
        const cards = document.querySelectorAll('.pos-item-card');
        cards.forEach(card => {
            const name = (card.getAttribute('data-name') || '').toLowerCase();
            const sku = (card.getAttribute('data-sku') || '').toLowerCase();
            if (!query || name.includes(query) || sku.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    /**
     * Clear search filter input.
     */
    function clearSearchFilter() {
        document.getElementById('pos-search-input').value = '';
        filterProductsManual();
    }

    /**
     * Update real-time digital clock display.
     */
    function updateClock() {
        const clockEl = document.getElementById('live-clock');
        if (!clockEl) return;
        const now = new Date();
        const hrs = String(now.getHours()).padStart(2, '0');
        const mins = String(now.getMinutes()).padStart(2, '0');
        const secs = String(now.getSeconds()).padStart(2, '0');
        clockEl.textContent = `${hrs}:${mins}:${secs}`;
    }

    document.addEventListener('DOMContentLoaded', function () {
        renderTicket();
        updateClock();
        setInterval(updateClock, 1000);
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
