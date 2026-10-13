<?php
/**
 * Módulo de Contabilidad y Proveedores
 * Panadería y Pastelería Pan y Queque
 * Basado en la plantilla elegante de Haute Boulangerie (Plantilla/code.html)
 */
$currentPage = 'proveedores';
$pageTitle = 'Contabilidad & Proveedores';
require_once __DIR__ . '/../includes/header.php';

// Proveedores de muestra
$suppliers = [
    [
        'id' => 1,
        'nombre' => 'Harina Los Andes S.A.',
        'rubro' => 'Harinas ecológicas de trigo y fuerza',
        'rut' => '76.412.390-2',
        'ultima_compra' => '10/10/2026',
        'monto' => 1250000,
        'estado' => 'Pagado',
        'badge' => 'bg-emerald-50 text-emerald-800 border-emerald-200'
    ],
    [
        'id' => 2,
        'nombre' => 'Mantequilla Premium SpA',
        'rubro' => 'Mantequilla pura de pasto AOP Charentes',
        'rut' => '77.892.110-5',
        'ultima_compra' => '08/10/2026',
        'monto' => 680000,
        'estado' => 'Pendiente',
        'badge' => 'bg-amber-50 text-amber-800 border-amber-200'
    ],
    [
        'id' => 3,
        'nombre' => 'Azúcar Refinada del Sur Ltda.',
        'rubro' => 'Azúcar flor y endulzantes orgánicos',
        'rut' => '76.109.845-K',
        'ultima_compra' => '05/10/2026',
        'monto' => 430000,
        'estado' => 'Pagado',
        'badge' => 'bg-emerald-50 text-emerald-800 border-emerald-200'
    ],
    [
        'id' => 4,
        'nombre' => 'Levadura Francesa & Enzimas',
        'rubro' => 'Levadura fresca prensada y deshidratada',
        'rut' => '78.330.122-3',
        'ultima_compra' => '12/10/2026',
        'monto' => 320000,
        'estado' => 'En Proceso',
        'badge' => 'bg-sky-50 text-sky-800 border-sky-200'
    ],
    [
        'id' => 5,
        'nombre' => 'Chocolate Belga & Coberturas',
        'rubro' => 'Cacao puro 70%, coberturas y drops',
        'rut' => '79.554.901-8',
        'ultima_compra' => '02/10/2026',
        'monto' => 890000,
        'estado' => 'Pagado',
        'badge' => 'bg-emerald-50 text-emerald-800 border-emerald-200'
    ]
];

// Carga dinámica de proveedores desde PostgreSQL si está disponible
$dbSuppliers = (class_exists('DB')) ? DB::select("SELECT * FROM proveedores ORDER BY id ASC") : [];
if (!empty($dbSuppliers)) {
    $suppliers = array_map(function($s) {
        $estado = $s['estado'] ?? 'Al día';
        $badge = 'bg-emerald-50 text-emerald-800 border-emerald-200';
        if ($estado === 'Pendiente') {
            $badge = 'bg-amber-50 text-amber-800 border-amber-200';
        } elseif ($estado === 'En proceso' || $estado === 'En Proceso') {
            $badge = 'bg-sky-50 text-sky-800 border-sky-200';
        }
        return [
            'id' => (int)$s['id'],
            'nombre' => $s['nombre'],
            'rubro' => $s['categoria'] ?? 'Materia prima artesanal',
            'rut' => $s['rut'],
            'ultima_compra' => !empty($s['fecha_ultima_compra']) ? date('d/m/Y', strtotime($s['fecha_ultima_compra'])) : '10/10/2026',
            'monto' => (int)$s['monto_compra'],
            'estado' => ($estado === 'Al día') ? 'Pagado' : $estado,
            'badge' => $badge
        ];
    }, $dbSuppliers);
}

// Métricas financieras
$cuentasPorPagar = 1000000;
$cuentasPorCobrar = 8920000;
$balanceGeneral = 5470000;
?>

<div class="max-w-7xl mx-auto px-6 lg:px-12 py-8 sm:py-12">

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav mb-6 flex items-center text-xs text-brand-muted space-x-2 uppercase tracking-wider">
        <a href="index.php" class="hover:text-brand-gold flex items-center space-x-1 font-medium transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Inicio</span>
        </a>
        <span>/</span>
        <span class="text-brand-charcoal font-semibold">Contabilidad &amp; Proveedores</span>
    </nav>

    <!-- Page Header -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-200/80 shadow-sm mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-full border border-brand-gold/40 flex items-center justify-center text-brand-gold bg-brand-sand">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl font-normal text-brand-charcoal tracking-tight">
                    Contabilidad &amp; Proveedores
                </h1>
            </div>
            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                <span class="bg-brand-sand text-brand-gold border border-brand-gold/30 font-medium px-2.5 py-0.5 rounded-full uppercase tracking-wider text-[11px]">
                    Cadena de Suministro &bull; Finanzas
                </span>
                <span>&bull;</span>
                <span>Gestión de Órdenes de Compra y Materias Primas Críticas</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-3">
            <button type="button" onclick="openModal('modal-nueva-orden')" class="inline-flex items-center px-4 py-2.5 rounded-lg bg-brand-gold hover:bg-brand-goldHover text-white text-xs uppercase tracking-widest font-semibold shadow-sm transition-all hover:scale-105">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Nueva Orden de Compra</span>
            </button>
            <button type="button" onclick="openModal('modal-balance')" class="inline-flex items-center px-4 py-2.5 rounded-lg bg-white hover:bg-brand-sand text-brand-charcoal border border-gray-200 hover:border-brand-gold text-xs uppercase tracking-widest font-semibold shadow-sm transition-all">
                <svg class="w-4 h-4 mr-1.5 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Emitir Balance</span>
            </button>
        </div>
    </div>

    <!-- Financial KPI Summary Cards (Plantilla Style) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Card 1: Cuentas por Pagar -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm hover:border-brand-gold/60 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs uppercase tracking-widest text-brand-muted font-medium">Cuentas por Pagar</span>
                <span class="text-xs px-2 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200 font-medium">Insumos</span>
            </div>
            <p class="font-serif text-3xl font-bold text-amber-700 mb-1">
                <?php echo formatoPesos($cuentasPorPagar); ?>
            </p>
            <p class="text-xs text-gray-500 font-light">2 órdenes pendientes de liquidación a 30 días</p>
        </div>

        <!-- Card 2: Cuentas por Cobrar -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm hover:border-brand-gold/60 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs uppercase tracking-widest text-brand-muted font-medium">Cuentas por Cobrar</span>
                <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 font-medium">B2B / Clínicas</span>
            </div>
            <p class="font-serif text-3xl font-bold text-emerald-700 mb-1">
                <?php echo formatoPesos($cuentasPorCobrar); ?>
            </p>
            <p class="text-xs text-gray-500 font-light">Facturación corporativa a supermercados y hoteles</p>
        </div>

        <!-- Card 3: Balance General Neto -->
        <div class="bg-white rounded-2xl p-6 border border-brand-gold/50 shadow-sm hover:border-brand-gold transition-colors bg-gradient-to-br from-white to-brand-sand/40">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs uppercase tracking-widest text-brand-gold font-semibold">Balance Operativo Neto</span>
                <span class="text-xs px-2 py-0.5 rounded-full bg-brand-sand text-brand-gold border border-brand-gold/30 font-semibold">Caja Chica + Bancos</span>
            </div>
            <p class="font-serif text-3xl font-bold text-brand-charcoal mb-1">
                <?php echo formatoPesos($balanceGeneral); ?>
            </p>
            <p class="text-xs text-gray-500 font-light">Flujo disponible tras pago de materias primas</p>
        </div>

    </div>

    <!-- Suppliers Table Card -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-100 bg-brand-sand/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-[11px] uppercase tracking-[0.2em] text-brand-gold font-semibold block">Registro Oficial</span>
                <h2 class="font-serif text-2xl text-brand-charcoal font-medium">Proveedores de Materias Primas</h2>
            </div>

            <!-- Search input -->
            <div class="relative w-full sm:w-72">
                <input type="text" id="supplier-search" onkeyup="filterSuppliers()" placeholder="Buscar proveedor o insumo..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 bg-white text-xs focus:outline-none focus:border-brand-gold transition-colors">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="suppliers-table">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-[11px] uppercase font-semibold border-b border-gray-200 tracking-wider">
                        <th class="py-3.5 px-6">Proveedor / Razón Social</th>
                        <th class="py-3.5 px-4">RUT</th>
                        <th class="py-3.5 px-4">Rubro / Insumo</th>
                        <th class="py-3.5 px-4 text-center">Última Compra</th>
                        <th class="py-3.5 px-6 text-right">Monto Acumulado</th>
                        <th class="py-3.5 px-4 text-center">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <?php foreach ($suppliers as $s): ?>
                    <tr class="hover:bg-brand-sand/40 transition-colors supplier-row">
                        <td class="py-4 px-6 font-semibold text-brand-charcoal">
                            <?php echo htmlspecialchars($s['nombre']); ?>
                        </td>
                        <td class="py-4 px-4 font-mono text-xs text-gray-500">
                            <?php echo $s['rut']; ?>
                        </td>
                        <td class="py-4 px-4 text-xs text-gray-600 font-light">
                            <?php echo htmlspecialchars($s['rubro']); ?>
                        </td>
                        <td class="py-4 px-4 text-center text-xs font-mono text-gray-600">
                            <?php echo $s['ultima_compra']; ?>
                        </td>
                        <td class="py-4 px-6 text-right font-serif font-bold text-base text-brand-charcoal">
                            <?php echo formatoPesos($s['monto']); ?>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium border <?php echo $s['badge']; ?>">
                                <?php echo $s['estado']; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
            <span>5 proveedores estratégicos registrados en el obrador.</span>
            <span class="text-brand-gold font-medium">Actualizado en tiempo real</span>
        </div>
    </div>

</div>

<!-- Modal 1: Nueva Orden de Compra -->
<div id="modal-nueva-orden" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-8 shadow-2xl border border-gray-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-6">
            <h3 class="font-serif text-2xl font-bold text-brand-charcoal">Nueva Orden de Compra</h3>
            <button type="button" onclick="closeModal('modal-nueva-orden')" class="text-gray-400 hover:text-brand-charcoal text-xl">&times;</button>
        </div>

        <form onsubmit="handleCrearOrden(event)" class="space-y-4 text-xs">
            <div>
                <label class="block uppercase tracking-wider text-gray-700 font-semibold mb-1">Proveedor *</label>
                <select id="orden-proveedor" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-gold">
                    <?php foreach ($suppliers as $s): ?>
                    <option value="<?php echo htmlspecialchars($s['nombre']); ?>"><?php echo htmlspecialchars($s['nombre']); ?> (<?php echo htmlspecialchars($s['rubro']); ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block uppercase tracking-wider text-gray-700 font-semibold mb-1">Cantidad / Volumen *</label>
                    <input type="text" id="orden-cantidad" required placeholder="Ej. 500 kg / 20 sacos" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-gold">
                </div>
                <div>
                    <label class="block uppercase tracking-wider text-gray-700 font-semibold mb-1">Monto Estimado ($CLP) *</label>
                    <input type="number" id="orden-monto" required placeholder="650000" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-gold">
                </div>
            </div>

            <div>
                <label class="block uppercase tracking-wider text-gray-700 font-semibold mb-1">Observaciones de Entrega</label>
                <textarea rows="2" placeholder="Recepción en obrador central antes de las 08:00 hrs..." class="w-full px-3.5 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-gold"></textarea>
            </div>

            <div class="pt-4 flex space-x-3">
                <button type="button" onclick="closeModal('modal-nueva-orden')" class="flex-1 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium text-xs uppercase tracking-wider hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 py-3 rounded-xl bg-brand-gold text-white font-medium text-xs uppercase tracking-wider hover:bg-brand-goldHover">
                    Emitir Orden
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Balance Financiero -->
<div id="modal-balance" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-8 shadow-2xl border border-gray-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-6">
            <h3 class="font-serif text-2xl font-bold text-brand-charcoal">Resumen de Balance General</h3>
            <button type="button" onclick="closeModal('modal-balance')" class="text-gray-400 hover:text-brand-charcoal text-xl">&times;</button>
        </div>

        <div class="space-y-3 text-xs mb-6">
            <div class="flex justify-between p-3 bg-brand-sand/50 rounded-xl">
                <span class="text-gray-600 font-medium">Ingresos Totales por Ventas:</span>
                <span class="font-serif font-bold text-brand-charcoal text-base">$8.920.000</span>
            </div>
            <div class="flex justify-between p-3 bg-brand-sand/50 rounded-xl">
                <span class="text-gray-600 font-medium">Costo de Materias Primas:</span>
                <span class="font-serif font-bold text-amber-800 text-base">-$3.450.000</span>
            </div>
            <div class="flex justify-between p-3 bg-brand-sand/50 rounded-xl">
                <span class="text-gray-600 font-medium">Gastos Operativos &amp; Flota:</span>
                <span class="font-serif font-bold text-gray-800 text-base">-$1.000.000</span>
            </div>
            <div class="flex justify-between p-4 bg-brand-sand border border-brand-gold/40 rounded-xl text-sm">
                <span class="font-bold text-brand-charcoal">Superávit Operacional Neto:</span>
                <span class="font-serif font-bold text-brand-gold text-xl">+$4.470.000</span>
            </div>
        </div>

        <div class="flex space-x-3">
            <button type="button" onclick="closeModal('modal-balance')" class="flex-1 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium text-xs uppercase tracking-wider hover:bg-gray-50">
                Cerrar
            </button>
            <button type="button" onclick="window.print();" class="flex-1 py-3 rounded-xl bg-brand-charcoal text-white font-medium text-xs uppercase tracking-wider hover:bg-black">
                Imprimir Balance
            </button>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        const m = document.getElementById(id);
        if (m) m.classList.remove('hidden');
    }

    function closeModal(id) {
        const m = document.getElementById(id);
        if (m) m.classList.add('hidden');
    }

    function filterSuppliers() {
        const term = document.getElementById('supplier-search').value.toLowerCase();
        const rows = document.querySelectorAll('.supplier-row');
        rows.forEach(r => {
            const text = r.textContent.toLowerCase();
            r.style.display = text.includes(term) ? '' : 'none';
        });
    }

    function handleCrearOrden(e) {
        e.preventDefault();
        const prov = document.getElementById('orden-proveedor').value;
        const cant = document.getElementById('orden-cantidad').value;
        const monto = parseInt(document.getElementById('orden-monto').value) || 0;
        alert(`¡Orden de compra generada exitosamente!\n\nProveedor: ${prov}\nCantidad: ${cant}\nMonto: $${monto.toLocaleString('es-CL')}`);
        closeModal('modal-nueva-orden');
    }
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
