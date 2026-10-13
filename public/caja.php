<?php
/**
 * Módulo de Cajas y Puntos de Venta (POS)
 * Panadería y Pastelería Pan y Queque
 * Basado en la plantilla elegante de Haute Boulangerie (Plantilla/code.html)
 */
$currentPage = 'caja';
$pageTitle = 'Punto de Venta & POS';
require_once __DIR__ . '/../includes/header.php';

// Definición de productos de muestra
$sampleProducts = [
    [
        'id' => 1,
        'nombre' => 'Pan Marraqueta de Masa Madre',
        'descripcion' => 'Crujiente y tradicional, fermentación en frío 48h',
        'unidad' => 'kg',
        'precio' => 1890,
        'icono' => '🥖',
        'stock' => 140,
        'categoria' => 'Panadería Tradicional'
    ],
    [
        'id' => 2,
        'nombre' => 'Hallullas Especiales',
        'descripcion' => 'Masa suave y esponjosa horneada en piedra refractaria',
        'unidad' => 'kg',
        'precio' => 1890,
        'icono' => '🥯',
        'stock' => 115,
        'categoria' => 'Panadería Tradicional'
    ],
    [
        'id' => 3,
        'nombre' => 'Torta de Chocolate Grand Cru',
        'descripcion' => 'Rellena con trufa artesanal, cacao 70% y manjar casero',
        'unidad' => 'unid',
        'precio' => 18500,
        'icono' => '🎂',
        'stock' => 12,
        'categoria' => 'Pastelería Fina'
    ],
    [
        'id' => 4,
        'nombre' => 'Empanadas de Pino al Horno',
        'descripcion' => 'Carne picada seleccionada, cebolla caramelizada y aceituna',
        'unidad' => 'unid',
        'precio' => 2400,
        'icono' => '🥟',
        'stock' => 85,
        'categoria' => 'Bollería Caliente'
    ],
    [
        'id' => 5,
        'nombre' => 'Pasteles Surtidos de Vitrina',
        'descripcion' => 'Selección de milhojas francesas, tartaletas y merengues',
        'unidad' => 'unid',
        'precio' => 1650,
        'icono' => '🧁',
        'stock' => 48,
        'categoria' => 'Pastelería Fina'
    ]
];

// Carga dinámica de productos desde PostgreSQL si la base de datos está disponible
$dbProducts = (class_exists('DB')) ? DB::select("SELECT * FROM productos WHERE activo = TRUE ORDER BY id ASC") : [];
if (!empty($dbProducts)) {
    $categoryIcons = [
        'Panadería' => '🥖',
        'Panadería Tradicional' => '🥖',
        'Pastelería' => '🎂',
        'Pastelería Fina' => '🧁',
        'Rotisería' => '🥟',
        'Bollería Caliente' => '🥟'
    ];
    $sampleProducts = array_map(function($p) use ($categoryIcons) {
        return [
            'id' => (int)$p['id'],
            'nombre' => $p['nombre'],
            'descripcion' => $p['descripcion'] ?? 'Elaborado en obrador artesanal',
            'unidad' => $p['unidad'],
            'precio' => (int)$p['precio'],
            'icono' => $categoryIcons[$p['categoria']] ?? '🍞',
            'stock' => (int)$p['stock'],
            'categoria' => $p['categoria']
        ];
    }, $dbProducts);
}
?>

<div class="max-w-7xl mx-auto px-6 lg:px-12 py-8 sm:py-12">

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav mb-6 flex items-center text-xs text-brand-muted space-x-2 uppercase tracking-wider">
        <a href="index.php" class="hover:text-brand-gold flex items-center space-x-1 font-medium transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Inicio</span>
        </a>
        <span>/</span>
        <span class="text-brand-charcoal font-semibold">Punto de Venta &bull; Mostrador</span>
    </nav>

    <!-- Page Header & Terminal Status -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-200/80 shadow-sm mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-full border border-brand-gold/40 flex items-center justify-center text-brand-gold bg-brand-sand">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl font-normal text-brand-charcoal tracking-tight">
                    Punto de Venta &amp; Mostrador
                </h1>
            </div>
            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                <span class="bg-brand-sand text-brand-gold border border-brand-gold/30 font-medium px-2.5 py-0.5 rounded-full uppercase tracking-wider text-[11px]">
                    Sala Mostrador Principal
                </span>
                <span>&bull;</span>
                <span>Terminal POS #02</span>
                <span>&bull;</span>
                <span>Cajero: <strong class="text-brand-charcoal">Marcela Soto (Turno Mañana)</strong></span>
            </div>
        </div>

        <!-- Live Clock & Date Header -->
        <div class="bg-brand-sand/70 border border-gray-200/70 rounded-xl px-5 py-3 flex items-center space-x-4 text-right justify-between md:justify-end">
            <div class="w-10 h-10 rounded-full bg-brand-charcoal text-brand-gold flex items-center justify-center text-base">
                ⏱
            </div>
            <div>
                <div class="text-[11px] text-brand-muted uppercase tracking-widest font-medium">Fecha Operacional</div>
                <div class="font-serif text-base font-semibold text-brand-charcoal" id="current-date-display">
                    <?php echo date('d/m/Y'); ?>
                </div>
                <div class="text-xs font-mono text-brand-gold font-bold" id="live-clock">
                    --:--:--
                </div>
            </div>
        </div>
    </div>

    <!-- POS Main Layout: 2 Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left Column: Products Grid & Selector (7 cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Products Table Card -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-brand-sand/40 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <span class="text-[11px] uppercase tracking-[0.2em] text-brand-gold font-semibold block">Catálogo en Vitrina</span>
                        <h2 class="font-serif text-2xl text-brand-charcoal font-medium">Productos Disponibles</h2>
                    </div>
                    <div class="inline-flex items-center space-x-2 text-xs bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="font-medium text-gray-700">Stock en Sala Sincronizado</span>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-[11px] uppercase font-semibold border-b border-gray-200 tracking-wider">
                                <th class="py-3.5 px-6">Producto</th>
                                <th class="py-3.5 px-3 text-center">Unidad</th>
                                <th class="py-3.5 px-4 text-right">Precio Unit.</th>
                                <th class="py-3.5 px-4 text-center">Cantidad</th>
                                <th class="py-3.5 px-6 text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <?php foreach ($sampleProducts as $prod): ?>
                            <tr class="hover:bg-brand-sand/50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-2xl p-2 bg-brand-sand rounded-xl border border-gray-100"><?php echo $prod['icono']; ?></span>
                                        <div>
                                            <div class="font-semibold text-brand-charcoal"><?php echo htmlspecialchars($prod['nombre']); ?></div>
                                            <div class="text-xs text-gray-500 font-light"><?php echo htmlspecialchars($prod['descripcion']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        <?php echo $prod['unidad']; ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right font-serif font-bold text-base text-brand-charcoal">
                                    <?php echo formatoPesos($prod['precio']); ?>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="inline-flex items-center border border-gray-200 rounded-lg overflow-hidden bg-white shadow-sm">
                                        <button type="button" onclick="adjustQty(<?php echo $prod['id']; ?>, -1)" class="px-2.5 py-1 text-gray-600 hover:bg-gray-100 font-bold text-sm focus:outline-none">-</button>
                                        <input type="number" id="qty-input-<?php echo $prod['id']; ?>" value="1" min="1" max="50" class="w-12 text-center py-1 text-xs font-mono font-bold border-x border-gray-200 focus:outline-none">
                                        <button type="button" onclick="adjustQty(<?php echo $prod['id']; ?>, 1)" class="px-2.5 py-1 text-gray-600 hover:bg-gray-100 font-bold text-sm focus:outline-none">+</button>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <button type="button" onclick="addToTicket(<?php echo $prod['id']; ?>, '<?php echo addslashes($prod['nombre']); ?>', <?php echo $prod['precio']; ?>, '<?php echo $prod['unidad']; ?>')" class="inline-flex items-center px-4 py-2 rounded-lg bg-brand-gold hover:bg-brand-goldHover text-white text-xs uppercase tracking-wider font-semibold shadow-sm transition-all hover:scale-105">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Agregar
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Quick actions bar -->
                <div class="p-4 bg-gray-50 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3 text-xs text-gray-500">
                    <div>
                        <span>Precios afectos a IVA (19%) incluidos por normativa comercial.</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="resetDefaultItems()" class="text-brand-gold hover:text-brand-goldHover font-medium underline">
                            Cargar canasta de ejemplo
                        </button>
                    </div>
                </div>
            </div>

            <!-- Terminal Info Card -->
            <div class="bg-brand-sand/60 rounded-xl p-4 border border-gray-200/80 shadow-sm text-xs flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center space-x-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <div>
                        <span class="text-brand-charcoal font-semibold block">Terminal Conectada a Base Central</span>
                        <span class="text-gray-500 text-[11px]">Sistema Local de Ventas Operativo</span>
                    </div>
                </div>
                <div class="text-[11px] uppercase tracking-wider text-brand-gold bg-white px-3 py-1 rounded-md border border-gray-200 font-medium">
                    Caja #02 &bull; Mostrador Principal
                </div>
            </div>

        </div>

        <!-- Right Column: Ticket / Summary & Action Buttons (5 cols) -->
        <div class="lg:col-span-5 space-y-6">

            <!-- POS Boleta Preview Card -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-lg p-6 sm:p-8 printable-area">
                
                <!-- Ticket Header -->
                <div class="text-center pb-5 border-b border-dashed border-gray-300">
                    <div class="w-12 h-12 mx-auto mb-2 rounded-full border border-brand-gold/40 flex items-center justify-center text-brand-gold bg-brand-sand">
                        🥖
                    </div>
                    <h3 class="font-serif text-xl font-bold text-brand-charcoal uppercase tracking-wide"><?php echo APP_COMPANY; ?></h3>
                    <p class="text-[11px] text-gray-500 font-mono mt-0.5">R.U.T.: 76.543.210-K &bull; GIRO: PANADERÍA Y PASTELERÍA</p>
                    <p class="text-[11px] text-gray-500">Av. Central #1024, Sala de Ventas</p>
                    <div class="mt-3 inline-block bg-brand-sand text-brand-gold text-xs font-mono font-bold px-3 py-1 rounded-full border border-brand-gold/30">
                        BOLETA ELECTRÓNICA N° <span id="boleta-num">004892</span>
                    </div>
                </div>

                <!-- Current Ticket Items -->
                <div class="py-5 border-b border-dashed border-gray-300">
                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3 flex justify-between items-center">
                        <span>Detalle de Consumo</span>
                        <button type="button" onclick="clearTicket()" class="no-print text-gray-400 hover:text-red-500 text-[11px] font-normal underline">Vaciar</button>
                    </div>

                    <div id="ticket-items-container" class="space-y-2.5 text-xs">
                        <!-- Populated by JavaScript -->
                    </div>
                </div>

                <!-- Summary Section: Subtotal, IVA, Total -->
                <div class="py-5 space-y-2.5 border-b border-gray-200 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal Neto:</span>
                        <span id="summary-subtotal" class="font-mono font-semibold text-brand-charcoal">$0</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>IVA (19%):</span>
                        <span id="summary-tax" class="font-mono font-semibold text-brand-charcoal">$0</span>
                    </div>
                    <div class="flex justify-between text-brand-charcoal text-xl font-serif font-bold pt-3 border-t border-gray-200">
                        <span>TOTAL A PAGAR:</span>
                        <span id="summary-total" class="font-serif text-2xl text-brand-gold font-bold">$0</span>
                    </div>
                </div>

                <!-- Payment Method Selector -->
                <div class="pt-5 no-print">
                    <label class="block text-xs uppercase tracking-wider font-semibold text-gray-700 mb-2">Forma de Pago:</label>
                    <div class="grid grid-cols-3 gap-2 text-xs">
                        <label class="flex flex-col items-center p-2.5 border border-gray-200 rounded-xl cursor-pointer hover:bg-brand-sand transition-colors">
                            <input type="radio" name="payment_method" value="Efectivo" checked class="text-brand-gold focus:ring-brand-gold">
                            <span class="mt-1 font-medium text-gray-700">💵 Efectivo</span>
                        </label>
                        <label class="flex flex-col items-center p-2.5 border border-gray-200 rounded-xl cursor-pointer hover:bg-brand-sand transition-colors">
                            <input type="radio" name="payment_method" value="Débito/RedCompra" class="text-brand-gold focus:ring-brand-gold">
                            <span class="mt-1 font-medium text-gray-700">💳 Débito</span>
                        </label>
                        <label class="flex flex-col items-center p-2.5 border border-gray-200 rounded-xl cursor-pointer hover:bg-brand-sand transition-colors">
                            <input type="radio" name="payment_method" value="Transferencia" class="text-brand-gold focus:ring-brand-gold">
                            <span class="mt-1 font-medium text-gray-700">📱 Transf.</span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons: Registrar Venta, Cuadratura de Caja, Imprimir Boleta -->
                <div class="pt-6 space-y-3 no-print">
                    <!-- Button 1: Registrar Venta -->
                    <button type="button" id="btn-registrar-venta" onclick="handleRegistrarVenta()" class="w-full py-3.5 px-4 rounded-xl bg-brand-gold hover:bg-brand-goldHover text-white font-semibold text-xs uppercase tracking-widest shadow-sm hover:shadow transition-all flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Registrar Venta</span>
                    </button>

                    <div class="grid grid-cols-2 gap-3">
                        <!-- Button 2: Cuadratura de Caja -->
                        <button type="button" id="btn-cuadratura" onclick="handleCuadraturaModal()" class="py-2.5 px-3 rounded-xl bg-white hover:bg-brand-sand text-brand-charcoal font-medium text-xs border border-gray-200 hover:border-brand-gold transition-colors flex items-center justify-center space-x-1.5">
                            <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Cuadratura</span>
                        </button>

                        <!-- Button 3: Imprimir Boleta -->
                        <button type="button" id="btn-imprimir" onclick="handleImprimirBoleta()" class="py-2.5 px-3 rounded-xl bg-brand-sand hover:bg-brand-sand/80 text-brand-charcoal font-medium text-xs border border-brand-gold/40 transition-colors flex items-center justify-center space-x-1.5">
                            <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            <span>Imprimir</span>
                        </button>
                    </div>
                </div>

                <!-- Timbre Electrónico Mockup -->
                <div class="mt-6 pt-4 border-t border-dashed border-gray-300 text-center text-[10px] text-gray-400 font-mono">
                    <p>Timbre Electrónico S.I.I. Res. 80 de 2026</p>
                    <p>Verifique documento tributario electrónico</p>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- Modal 1: Venta Registrada con Éxito -->
<div id="modal-venta-exitosa" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-8 shadow-2xl border border-gray-200 text-center">
        <div class="w-16 h-16 bg-brand-sand text-brand-gold border border-brand-gold/40 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-serif">
            ✓
        </div>
        <h3 class="font-serif text-2xl font-bold text-brand-charcoal mb-1">¡Venta Registrada!</h3>
        <p class="text-xs text-gray-500 mb-5 font-mono">Comprobante Fiscal Emitido &bull; Folio #<span id="modal-folio">004892</span></p>
        
        <div class="bg-brand-sand/50 rounded-xl p-4 text-left text-xs space-y-2 mb-6 border border-gray-200/70">
            <div class="flex justify-between">
                <span class="text-gray-500">Monto Total:</span>
                <span id="modal-total" class="font-serif font-bold text-base text-brand-gold">$0</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Forma de Pago:</span>
                <span id="modal-pago" class="font-medium text-brand-charcoal">Efectivo</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Estado de Operación:</span>
                <span class="text-emerald-600 font-semibold">Guardado en Sistema Local</span>
            </div>
        </div>

        <div class="flex space-x-3">
            <button type="button" onclick="closeModal('modal-venta-exitosa'); handleImprimirBoleta();" class="flex-1 py-3 px-4 rounded-xl border border-gray-300 text-brand-charcoal font-medium text-xs uppercase tracking-wider hover:bg-gray-50">
                Imprimir Copia
            </button>
            <button type="button" onclick="closeModal('modal-venta-exitosa'); startNewSale();" class="flex-1 py-3 px-4 rounded-xl bg-brand-gold text-white font-medium text-xs uppercase tracking-wider hover:bg-brand-goldHover">
                Nueva Venta
            </button>
        </div>
    </div>
</div>

<!-- Modal 2: Cuadratura de Caja -->
<div id="modal-cuadratura" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-8 shadow-2xl border border-gray-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-5">
            <div class="flex items-center space-x-2.5">
                <span class="text-2xl">📊</span>
                <h3 class="font-serif text-2xl font-bold text-brand-charcoal">Cuadratura y Arqueo de Caja</h3>
            </div>
            <button type="button" onclick="closeModal('modal-cuadratura')" class="text-gray-400 hover:text-brand-charcoal text-xl">&times;</button>
        </div>

        <div class="text-xs text-gray-500 mb-5">
            Turno Mañana &bull; Caja #02 Sala Mostrador
        </div>

        <div class="space-y-3 text-xs mb-6">
            <div class="flex justify-between p-3 bg-brand-sand/50 rounded-xl">
                <span class="text-gray-600 font-medium">Fondo Fijo Inicial (Apertura):</span>
                <span class="font-mono font-bold text-brand-charcoal">$50.000</span>
            </div>
            <div class="flex justify-between p-3 bg-brand-sand/50 rounded-xl">
                <span class="text-gray-600 font-medium">Ventas Efectivo Acumuladas:</span>
                <span class="font-mono font-bold text-emerald-700">$324.800</span>
            </div>
            <div class="flex justify-between p-3 bg-brand-sand/50 rounded-xl">
                <span class="text-gray-600 font-medium">Ventas Débito / Tarjetas:</span>
                <span class="font-mono font-bold text-brand-charcoal">$542.100</span>
            </div>
            <div class="flex justify-between p-3 bg-brand-sand/50 rounded-xl">
                <span class="text-gray-600 font-medium">Ventas Transferencias:</span>
                <span class="font-mono font-bold text-brand-charcoal">$118.500</span>
            </div>
            <div class="flex justify-between p-3.5 bg-brand-sand border border-brand-gold/40 rounded-xl text-sm">
                <span class="font-bold text-brand-charcoal">Efectivo Físico Esperado en Cajón:</span>
                <span class="font-serif font-bold text-brand-gold text-lg">$374.800</span>
            </div>
        </div>

        <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 flex items-center space-x-2 mb-6">
            <span class="text-lg">✓</span>
            <div>
                <strong>Estado:</strong> Cuadratura preliminar conforme. Sin descuadres.
            </div>
        </div>

        <div class="flex space-x-3">
            <button type="button" onclick="closeModal('modal-cuadratura')" class="flex-1 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium text-xs uppercase tracking-wider hover:bg-gray-50">
                Cerrar
            </button>
            <button type="button" onclick="alert('Cierre de turno Z completado y registrado localmente.'); closeModal('modal-cuadratura');" class="flex-1 py-3 rounded-xl bg-brand-gold text-white font-medium text-xs uppercase tracking-wider hover:bg-brand-goldHover">
                Emitir Cierre Z
            </button>
        </div>
    </div>
</div>

<!-- POS Interactive JavaScript -->
<script>
    let ticket = [
        { id: 1, nombre: 'Pan Marraqueta de Masa Madre', precio: 1890, unidad: 'kg', qty: 2 },
        { id: 4, nombre: 'Empanadas de Pino al Horno', precio: 2400, unidad: 'unid', qty: 3 },
        { id: 5, nombre: 'Pasteles Surtidos de Vitrina', precio: 1650, unidad: 'unid', qty: 4 }
    ];

    let boletaCurrent = 4892;

    function renderTicket() {
        const container = document.getElementById('ticket-items-container');
        if (!container) return;

        if (ticket.length === 0) {
            container.innerHTML = '<p class="text-gray-400 italic text-center py-4">No hay productos en el ticket actual.</p>';
            document.getElementById('summary-subtotal').textContent = '$0';
            document.getElementById('summary-tax').textContent = '$0';
            document.getElementById('summary-total').textContent = '$0';
            return;
        }

        let total = 0;
        let html = '';

        ticket.forEach((item, index) => {
            const itemTotal = item.precio * item.qty;
            total += itemTotal;

            html += `
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <div class="flex-1 pr-2">
                        <div class="font-medium text-brand-charcoal">${item.nombre}</div>
                        <div class="text-[11px] text-gray-500 font-mono">
                            ${item.qty} ${item.unidad} &times; $${item.precio.toLocaleString('es-CL')}
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-mono font-semibold text-brand-charcoal text-xs">$${itemTotal.toLocaleString('es-CL')}</span>
                        <button type="button" onclick="removeFromTicket(${index})" class="no-print text-gray-400 hover:text-red-500 font-bold px-1" title="Eliminar">&times;</button>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;

        const subtotal = Math.round(total / 1.19);
        const tax = total - subtotal;

        document.getElementById('summary-subtotal').textContent = '$' + subtotal.toLocaleString('es-CL');
        document.getElementById('summary-tax').textContent = '$' + tax.toLocaleString('es-CL');
        document.getElementById('summary-total').textContent = '$' + total.toLocaleString('es-CL');
    }

    function adjustQty(productId, delta) {
        const input = document.getElementById('qty-input-' + productId);
        if (!input) return;
        let val = parseInt(input.value) || 1;
        val += delta;
        if (val < 1) val = 1;
        if (val > 50) val = 50;
        input.value = val;
    }

    function addToTicket(id, nombre, precio, unidad) {
        const qtyInput = document.getElementById('qty-input-' + id);
        const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;

        const existing = ticket.find(item => item.id === id);
        if (existing) {
            existing.qty += qty;
        } else {
            ticket.push({ id, nombre, precio, unidad, qty });
        }

        renderTicket();
        if (qtyInput) qtyInput.value = 1;
    }

    function removeFromTicket(index) {
        ticket.splice(index, 1);
        renderTicket();
    }

    function clearTicket() {
        ticket = [];
        renderTicket();
    }

    function resetDefaultItems() {
        ticket = [
            { id: 1, nombre: 'Pan Marraqueta de Masa Madre', precio: 1890, unidad: 'kg', qty: 2 },
            { id: 4, nombre: 'Empanadas de Pino al Horno', precio: 2400, unidad: 'unid', qty: 3 },
            { id: 5, nombre: 'Pasteles Surtidos de Vitrina', precio: 1650, unidad: 'unid', qty: 4 }
        ];
        renderTicket();
    }

    function handleRegistrarVenta() {
        if (ticket.length === 0) {
            alert('Agregue al menos un producto al ticket antes de registrar la venta.');
            return;
        }

        let total = 0;
        ticket.forEach(item => total += item.precio * item.qty);

        const methodEl = document.querySelector('input[name="payment_method"]:checked');
        const method = methodEl ? methodEl.value : 'Efectivo';

        boletaCurrent++;
        document.getElementById('boleta-num').textContent = String(boletaCurrent).padStart(6, '0');
        document.getElementById('modal-folio').textContent = String(boletaCurrent).padStart(6, '0');
        document.getElementById('modal-total').textContent = '$' + total.toLocaleString('es-CL');
        document.getElementById('modal-pago').textContent = method;

        document.getElementById('modal-venta-exitosa').classList.remove('hidden');
    }

    function startNewSale() {
        ticket = [];
        renderTicket();
    }

    function handleCuadraturaModal() {
        document.getElementById('modal-cuadratura').classList.remove('hidden');
    }

    function handleImprimirBoleta() {
        window.print();
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('hidden');
    }

    // Live Clock updater
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
