<?php
/**
 * Módulo de Cajas y Punto de Venta Táctil (POS)
 * Panadería y Pastelería Pan y Queque
 * Diseñado bajo los estándares del Atelier Architectural ERP (Plantilla/stitch_bakery_erp_system/punto_de_venta_pos_t_ctil/)
 */
$currentPage = 'pos';
$pageTitle = 'Punto de Venta POS';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/ProductService.php';

// Cargar catálogo activo desde ProductService
$sampleProducts = ProductService::getActiveProducts();
?>

<!-- 1. SUBBARRA TÉCNICA DE ESTADO DEL POS -->
<section class="w-full bg-slate-200 border-b border-slate-300 px-4 sm:px-6 py-2.5 flex flex-wrap items-center justify-between gap-3 shrink-0">
    <div class="flex items-center space-x-3">
        <div class="w-2.5 h-2.5 bg-amber-700"></div>
        <div class="flex items-center space-x-2">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-600 font-mono">TERMINAL DE CAJA TÁCTIL:</span>
            <h1 class="text-xs font-bold text-slate-900 uppercase font-mono tracking-wide">PUNTO DE VENTA #POS-02 • PAN Y QUEQUE OBRADOR</h1>
        </div>
    </div>
    <div class="flex flex-wrap items-center space-x-4 sm:space-x-6 text-xs font-mono">
        <div class="flex items-center space-x-1.5">
            <span class="text-slate-500 uppercase">PLANTA:</span>
            <span class="font-bold text-slate-800">CENTRAL #01</span>
        </div>
        <div class="h-3 w-px bg-slate-300 hidden sm:block"></div>
        <div class="flex items-center space-x-1.5">
            <span class="text-slate-500 uppercase">TURNO:</span>
            <span class="font-bold text-slate-800">MATUTINO (04:00 - 13:00)</span>
        </div>
        <div class="h-3 w-px bg-slate-300 hidden sm:block"></div>
        <div class="flex items-center space-x-1.5">
            <span class="text-slate-500 uppercase">OPERADOR:</span>
            <span class="font-bold text-slate-900 bg-white px-2 py-0.5 border border-slate-300">MARCELA SOTO [ID: OP-412]</span>
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
                    [PANADERÍA MASA MADRE]
                </button>
                <button type="button" class="pos-cat-btn bg-white text-slate-800 hover:bg-slate-100 text-xs font-bold font-mono uppercase px-3 py-1.5 tracking-wider rounded-none border border-slate-300" onclick="setCategoryFilter('Viennoiserie', this)">
                    [VIENNOISERIE]
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
                                <?php echo htmlspecialchars($prod['unidad']); ?>
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
                                <span>AÑADIR</span>
                            </button>
                        </div>
                    </div>

                </div>
                <?php endforeach; ?>
            </div>

            <!-- TERMINAL TELEMETRÍA INFERIOR -->
            <div class="bg-slate-50 border border-slate-200 p-3 text-xs font-mono flex flex-wrap items-center justify-between gap-2 text-slate-600">
                <div class="flex items-center space-x-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-none inline-block"></span>
                    <span>Lector USB &bull; Gaveta de Efectivo Conectada &bull; Impresora Térmica 80mm Sincronizada</span>
                </div>
                <button type="button" onclick="resetDefaultItems()" class="text-amber-700 hover:underline font-semibold">
                    [Cargar Ticket de Demostración]
                </button>
            </div>

        </div>

        <!-- COLUMNA DERECHA: BOLETA ELECTRÓNICA & TICKET CONTABLE (4 cols) -->
        <div class="lg:col-span-4 space-y-4">

            <div class="bg-white border border-slate-300 p-5 rounded-none shadow-none printable-area">
                
                <!-- Encabezado Boleta Fiscal -->
                <div class="text-center pb-4 border-b border-dashed border-slate-300">
                    <div class="w-8 h-8 mx-auto mb-1.5 bg-slate-900 text-white flex items-center justify-center font-bold text-xs font-mono rounded-none">
                        PQ
                    </div>
                    <div class="font-bold text-xs uppercase tracking-wider text-slate-900"><?php echo APP_COMPANY; ?></div>
                    <p class="text-[10px] text-slate-500 font-mono mt-0.5">R.U.T.: 76.543.210-K &bull; GIRO: PANADERÍA Y PASTELERÍA</p>
                    <p class="text-[10px] text-slate-500 font-mono">PLANTA CENTRAL #01 &bull; AV. CENTRAL #1024</p>
                    <div class="mt-2.5 inline-block bg-slate-100 text-slate-800 text-[11px] font-mono font-bold px-2.5 py-1 border border-slate-300">
                        BOLETA ELECTRÓNICA N° <span id="boleta-num">004892</span>
                    </div>
                </div>

                <!-- Lista de Ítems en el Ticket -->
                <div class="py-4 border-b border-dashed border-slate-300">
                    <div class="text-[11px] font-bold text-slate-700 uppercase font-mono tracking-wider mb-2.5 flex justify-between items-center">
                        <span>DETALLE DE CONSUMO</span>
                        <button type="button" onclick="clearTicket()" class="no-print text-slate-400 hover:text-red-600 text-[10px] font-mono underline">Vaciar</button>
                    </div>

                    <div id="ticket-items-container" class="space-y-2 text-xs font-mono max-h-64 overflow-y-auto">
                        <!-- Generado por JavaScript -->
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
                            <input type="radio" name="payment_method" value="Débito / Transbank" class="text-slate-900 focus:ring-0">
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
                        <span>REGISTRAR VENTA &bull; EMITIR BOLETA</span>
                    </button>

                    <div class="grid grid-cols-2 gap-2">
                        <!-- Botón 2: Cuadratura de Caja -->
                        <button type="button" id="btn-cuadratura" onclick="handleCashCountModal()" class="py-2.5 px-3 bg-white hover:bg-slate-50 text-slate-800 font-bold text-xs font-mono border border-slate-300 rounded-none flex items-center justify-center space-x-1 transition-none">
                            <span class="material-symbols-outlined text-sm">point_of_sale</span>
                            <span>CUADRATURA</span>
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

<!-- MODAL 1: VENTA REGISTRADA CON ÉXITO (PLANAR RECTANGULAR SÓLIDO) -->
<div id="modal-venta-exitosa" class="hidden fixed inset-0 z-50 bg-slate-950/80 flex items-center justify-center p-4">
    <div class="bg-white rounded-none max-w-md w-full p-6 border-2 border-slate-900 text-center shadow-none">
        <div class="w-12 h-12 bg-slate-900 text-white flex items-center justify-center mx-auto mb-3 text-xl font-bold font-mono">
            ✓
        </div>
        <h3 class="text-lg font-bold text-slate-900 uppercase tracking-tight">¡Venta Registrada con Éxito!</h3>
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
                <span class="text-emerald-700 font-bold">ALMACENADO / OK</span>
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

<!-- MODAL 2: CUADRATURA DE CAJA (ARQUEO RECTANGULAR SÓLIDO) -->
<div id="modal-cuadratura" class="hidden fixed inset-0 z-50 bg-slate-950/80 flex items-center justify-center p-4">
    <div class="bg-white rounded-none max-w-lg w-full p-6 border-2 border-slate-900 shadow-none">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div class="flex items-center space-x-2">
                <span class="material-symbols-outlined text-slate-800">analytics</span>
                <h3 class="text-base font-bold text-slate-900 uppercase tracking-tight">Cuadratura y Arqueo de Caja</h3>
            </div>
            <button type="button" onclick="closeModal('modal-cuadratura')" class="text-slate-400 hover:text-slate-900 text-xl font-mono">&times;</button>
        </div>

        <div class="text-xs font-mono text-slate-500 mb-4">
            Turno Matutino &bull; Terminal #02 Sala Mostrador &bull; Cajero: Marcela Soto
        </div>

        <div class="space-y-2 text-xs font-mono mb-5">
            <div class="flex justify-between p-2.5 bg-slate-50 border border-slate-200">
                <span class="text-slate-600 font-medium">Fondo Fijo Inicial (Apertura):</span>
                <span class="font-bold text-slate-900 tabular-nums">$50.000</span>
            </div>
            <div class="flex justify-between p-2.5 bg-slate-50 border border-slate-200">
                <span class="text-slate-600 font-medium">Ventas Efectivo Acumuladas:</span>
                <span class="font-bold text-emerald-700 tabular-nums">$324.800</span>
            </div>
            <div class="flex justify-between p-2.5 bg-slate-50 border border-slate-200">
                <span class="text-slate-600 font-medium">Ventas Débito / Tarjetas:</span>
                <span class="font-bold text-slate-900 tabular-nums">$542.100</span>
            </div>
            <div class="flex justify-between p-2.5 bg-slate-50 border border-slate-200">
                <span class="text-slate-600 font-medium">Ventas Transferencias:</span>
                <span class="font-bold text-slate-900 tabular-nums">$118.500</span>
            </div>
            <div class="flex justify-between p-3 bg-amber-50 border border-amber-300 text-sm">
                <span class="font-bold text-slate-900">Efectivo Físico Esperado en Cajón:</span>
                <span class="font-bold text-amber-800 text-base tabular-nums">$374.800</span>
            </div>
        </div>

        <div class="p-3 bg-emerald-50 border border-emerald-300 text-xs font-mono text-emerald-800 flex items-center space-x-2 mb-5">
            <span class="material-symbols-outlined text-sm">verified</span>
            <div>
                <strong>Estado:</strong> Cuadratura preliminar conforme. Balance exacto sin descuadres.
            </div>
        </div>

        <div class="flex space-x-2">
            <button type="button" onclick="closeModal('modal-cuadratura')" class="flex-1 py-2.5 border border-slate-300 text-slate-800 font-mono font-bold text-xs uppercase hover:bg-slate-50 rounded-none">
                Cerrar
            </button>
            <button type="button" onclick="alert('Cierre de turno Z emitido conforme y registrado.'); closeModal('modal-cuadratura');" class="flex-1 py-2.5 bg-amber-700 hover:bg-amber-800 text-white font-mono font-bold text-xs uppercase rounded-none">
                Emitir Cierre Z
            </button>
        </div>
    </div>
</div>

<!-- POS INTERACTIVE JAVASCRIPT (ZERO-PILL & JETBRAINS MONO FORMULAS) -->
<script>
    let ticket = [
        { id: 1, nombre: 'Pan Marraqueta de Masa Madre', precio: 1890, unidad: 'kg', qty: 2 },
        { id: 4, nombre: 'Empanadas de Pino al Horno', precio: 2400, unidad: 'unid', qty: 3 },
        { id: 5, nombre: 'Pasteles Surtidos de Vitrina', precio: 1650, unidad: 'unid', qty: 4 }
    ];

    let receiptNumber = 4892;

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
            container.innerHTML = '<p class="text-slate-400 italic text-center py-4 font-mono text-xs">Sin productos en el ticket.</p>';
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
     * Reset ticket to default items.
     */
    function resetDefaultItems() {
        ticket = [
            { id: 1, nombre: 'Pan Marraqueta de Masa Madre', precio: 1890, unidad: 'kg', qty: 2 },
            { id: 4, nombre: 'Empanadas de Pino al Horno', precio: 2400, unidad: 'unid', qty: 3 },
            { id: 5, nombre: 'Pasteles Surtidos de Vitrina', precio: 1650, unidad: 'unid', qty: 4 }
        ];
        renderTicket();
    }

    /**
     * Process checkout registration and display confirmation modal.
     */
    function handleRegisterSale() {
        if (ticket.length === 0) {
            alert('Agregue al menos un producto al ticket antes de registrar la venta.');
            return;
        }

        const { total } = calculateTicketTotals(ticket);
        const methodEl = document.querySelector('input[name="payment_method"]:checked');
        const method = methodEl ? methodEl.value : 'Efectivo';

        receiptNumber++;
        const folioStr = String(receiptNumber).padStart(6, '0');
        document.getElementById('boleta-num').textContent = folioStr;
        document.getElementById('modal-folio').textContent = folioStr;
        document.getElementById('modal-total').textContent = '$' + total.toLocaleString('es-CL');
        document.getElementById('modal-pago').textContent = method;

        document.getElementById('modal-venta-exitosa').classList.remove('hidden');
    }

    /**
     * Reset state and start a new sale transaction.
     */
    function startNewSale() {
        ticket = [];
        renderTicket();
    }

    /**
     * Display cash count modal dialog.
     */
    function handleCashCountModal() {
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
