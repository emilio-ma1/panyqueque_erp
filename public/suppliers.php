<?php
/**
 * Módulo de Contabilidad y Proveedores
 * Panadería y Pastelería Pan y Queque
 * Diseñado bajo los estándares del Atelier Architectural ERP (Plantilla/stitch_bakery_erp_system/proveedores_finanzas/)
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/SupplierService.php';
require_once __DIR__ . '/../includes/AuditService.php';
require_once __DIR__ . '/../includes/AuthService.php';

// Control de acceso: solo Gerente, Administrador y Finanzas
AuthService::requireAuth(['gerente', 'admin', 'finanzas']);

// ==============================================================================
// PROCESAR NUEVA ORDEN DE COMPRA (PO) VÍA POST
// ==============================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_po') {
    header('Content-Type: application/json; charset=utf-8');

    $supplierId = (int)($_POST['supplier_id'] ?? 0);
    $amount = (int)($_POST['monto'] ?? 0);
    $notes = trim((string)($_POST['observaciones'] ?? ''));

    if ($supplierId <= 0 || $amount <= 0) {
        echo json_encode(['success' => false, 'error' => 'Proveedor y monto válido son requeridos.']);
        exit;
    }

    $res = SupplierService::createPurchaseOrder($supplierId, $amount, $notes);
    echo json_encode($res);
    exit;
}

$currentPage = 'suppliers';
$pageTitle = 'Proveedores & Finanzas';
require_once __DIR__ . '/../includes/header.php';

// Cargar métricas y proveedores desde SupplierService
$suppliers = SupplierService::getAllSuppliers();
$metrics = SupplierService::getFinancialMetrics();
$cuentasPorPagar = $metrics['accountsPayable'];
$cuentasPorCobrar = $metrics['accountsReceivable'];
$balanceGeneral = $metrics['generalBalance'];

$recentOrders = SupplierService::getRecentPurchaseOrders(6);
?>

<!-- CONTENEDOR PRINCIPAL: PROVEEDORES & FINANZAS -->
<div class="p-4 sm:p-6 lg:p-8 max-w-[1536px] mx-auto space-y-6">

    <!-- 1. BARRA DE ACCIONES Y TÍTULO ARQUITECTÓNICO -->
    <section class="bg-white border border-slate-200 p-5 sm:p-6 rounded-none flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-[11px] font-mono uppercase tracking-wider text-slate-600 mb-1">
                <span class="w-2 h-2 bg-amber-600 rounded-none inline-block"></span>
                <span class="font-bold text-amber-700">Módulo 03 // Libro Mayor, Cadenas de Suministro y Proveedores</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-500">AUDITORÍA FISCAL 2026</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-950">
                Control Financiero de Compras y Cuentas de Explotación
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">
                Balance de devengo, compras industriales de harinas y conciliación de cuentas HORECA en MariaDB.
            </p>
        </div>

        <!-- Botones de Acción Rápidos y Rectangulares (Zero-Pill) -->
        <div class="flex flex-wrap items-center gap-2 shrink-0">
            <button type="button" onclick="openModal('modal-nueva-orden')" class="bg-slate-950 hover:bg-slate-800 text-white px-3.5 py-2 text-xs font-semibold font-mono uppercase tracking-wider rounded-none flex items-center space-x-1.5 transition-none">
                <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                <span>+ Nueva Orden de Compra (PO)</span>
            </button>
            <button type="button" onclick="openModal('modal-balance')" class="bg-slate-200 hover:bg-slate-300 text-slate-900 px-3.5 py-2 text-xs font-semibold font-mono uppercase tracking-wider rounded-none flex items-center space-x-1.5 transition-none">
                <span class="material-symbols-outlined text-[16px]">download</span>
                <span>Estado de Resultados</span>
            </button>
            <button type="button" onclick="window.print()" class="bg-white hover:bg-slate-100 text-slate-800 border border-slate-300 px-3.5 py-2 text-xs font-semibold font-mono uppercase tracking-wider rounded-none flex items-center space-x-1.5 transition-none">
                <span class="material-symbols-outlined text-[16px]">description</span>
                <span>Descargar Informe Auditoría</span>
            </button>
        </div>
    </section>

    <!-- 2. TARJETAS DE BALANCE FINANCIERO SÓLIDAS (GRID 4 COLUMNAS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Tarjeta 1: Cuentas por Pagar (AP) -->
        <div class="bg-white border border-slate-200 p-4 rounded-none flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between text-[11px] font-mono text-slate-500 uppercase tracking-wider mb-1">
                    <span>Pasivo Corriente</span>
                    <span class="text-amber-800 font-bold bg-amber-50 px-1 border border-amber-200">[AP]</span>
                </div>
                <div class="text-xs font-bold text-slate-800 uppercase">Cuentas por Pagar Insumos</div>
                <div class="text-2xl font-bold font-mono text-amber-800 mt-2 tabular-nums">
                    <?php echo formatCurrency($cuentasPorPagar); ?>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-[11px] font-mono">
                <div class="flex justify-between text-slate-700">
                    <span>Órdenes Pendientes:</span>
                    <strong class="text-amber-800 font-bold"><?php echo formatCurrency($cuentasPorPagar); ?></strong>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Estado:</span>
                    <strong class="text-slate-900">Conciliado MariaDB</strong>
                </div>
                <div class="w-full bg-slate-200 h-1.5 mt-2 rounded-none">
                    <div class="bg-amber-600 h-1.5" style="width: 42%"></div>
                </div>
            </div>
        </div>

        <!-- Tarjeta 2: Cuentas por Cobrar (AR) -->
        <div class="bg-white border border-slate-200 p-4 rounded-none flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between text-[11px] font-mono text-slate-500 uppercase tracking-wider mb-1">
                    <span>Activo Corriente</span>
                    <span class="text-emerald-800 font-bold bg-emerald-50 px-1 border border-emerald-200">[AR]</span>
                </div>
                <div class="text-xs font-bold text-slate-800 uppercase">Facturación y Ventas Totales</div>
                <div class="text-2xl font-bold font-mono text-slate-950 mt-2 tabular-nums">
                    <?php echo formatCurrency($cuentasPorCobrar); ?>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-[11px] font-mono">
                <div class="flex justify-between text-slate-700">
                    <span>Cartera HORECA &amp; POS:</span>
                    <strong class="text-emerald-800 font-bold">Auditado</strong>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Tasa de Cobro:</span>
                    <strong class="text-slate-900">Al día 98.4%</strong>
                </div>
                <div class="w-full bg-slate-200 h-1.5 mt-2 rounded-none">
                    <div class="bg-emerald-600 h-1.5" style="width: 82%"></div>
                </div>
            </div>
        </div>

        <!-- Tarjeta 3: Balance Operativo Neto -->
        <div class="bg-white border border-slate-200 p-4 rounded-none flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between text-[11px] font-mono text-slate-500 uppercase tracking-wider mb-1">
                    <span>Flujo Disponible</span>
                    <span class="text-slate-700 font-bold bg-slate-100 px-1 border border-slate-300">[NETO]</span>
                </div>
                <div class="text-xs font-bold text-slate-800 uppercase">Balance Operativo General</div>
                <div class="text-2xl font-bold font-mono text-slate-950 mt-2 tabular-nums">
                    <?php echo formatCurrency($balanceGeneral); ?>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-[11px] font-mono">
                <div class="flex justify-between text-slate-700">
                    <span>Capital de Trabajo:</span>
                    <strong class="text-slate-900 font-bold">Conforme</strong>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Caja + Bancos:</span>
                    <strong class="text-emerald-700">Superávit</strong>
                </div>
                <div class="w-full bg-slate-200 h-1.5 mt-2 rounded-none">
                    <div class="bg-slate-900 h-1.5" style="width: 76%"></div>
                </div>
            </div>
        </div>

        <!-- Tarjeta 4: Desembolso Mensual OPEX -->
        <div class="bg-white border border-slate-200 p-4 rounded-none flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between text-[11px] font-mono text-slate-500 uppercase tracking-wider mb-1">
                    <span>Ejecución Presupuestaria</span>
                    <span class="text-blue-800 font-bold bg-blue-50 px-1 border border-blue-200">[OPEX]</span>
                </div>
                <div class="text-xs font-bold text-slate-800 uppercase">Presupuesto Materias Primas</div>
                <div class="text-2xl font-bold font-mono text-slate-950 mt-2 tabular-nums">$38.200.000</div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-[11px] font-mono">
                <div class="flex justify-between text-slate-700">
                    <span>Ejecutado al mes:</span>
                    <strong class="text-slate-900 font-bold">$12.450.000</strong>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Disponible:</span>
                    <strong class="text-emerald-700 font-bold">67.4%</strong>
                </div>
                <div class="w-full bg-slate-200 h-1.5 mt-2 rounded-none">
                    <div class="bg-blue-600 h-1.5" style="width: 32.6%"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. TABLA PRINCIPAL DE PROVEEDORES HOMOLOGADOS -->
    <div class="bg-white border border-slate-200 rounded-none shadow-none">
        
        <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 flex items-center space-x-2">
                    <span class="w-2 h-2 bg-amber-600 rounded-none inline-block"></span>
                    <span>Directorio de Proveedores Homologados y Cuentas Corrientes</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Control de contratos, volúmenes de compra acumulados y estado de conciliación fiscal.</p>
            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    <input type="text" id="supplier-search" onkeyup="filterSuppliers()" placeholder="Filtrar por proveedor o RUT..." class="px-3 py-1.5 pl-8 border border-slate-300 text-xs font-mono rounded-none focus:outline-none focus:border-slate-900 w-64">
                    <span class="material-symbols-outlined absolute left-2 top-2 text-slate-400 text-base">search</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-200 text-slate-700 font-mono font-semibold uppercase tracking-wider text-[11px]">
                        <th class="py-3 px-4">Proveedor / Empresa</th>
                        <th class="py-3 px-4">RUT Institucional</th>
                        <th class="py-3 px-4">Línea de Suministro</th>
                        <th class="py-3 px-4 text-center">Última Compra</th>
                        <th class="py-3 px-4 text-right">Volumen Compras ($CLP)</th>
                        <th class="py-3 px-4 text-center">Estado Conciliación</th>
                        <th class="py-3 px-4 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-800">
                    <?php foreach ($suppliers as $s): ?>
                    <tr class="hover:bg-slate-50 supplier-row transition-none">
                        <td class="py-3.5 px-4 font-bold text-slate-900">
                            <?php echo htmlspecialchars($s['nombre']); ?>
                            <span class="block text-[11px] font-mono text-slate-500 font-normal">Planta Central #01</span>
                        </td>
                        <td class="py-3.5 px-4 font-mono text-slate-600">
                            <?php echo $s['rut']; ?>
                        </td>
                        <td class="py-3.5 px-4 text-slate-700">
                            <?php echo htmlspecialchars($s['rubro']); ?>
                        </td>
                        <td class="py-3.5 px-4 text-center font-mono text-slate-600">
                            <?php echo $s['ultima_compra']; ?>
                        </td>
                        <td class="py-3.5 px-4 text-right font-mono font-bold text-slate-900 text-sm tabular-nums">
                            <?php echo formatCurrency($s['monto']); ?>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase rounded-none border <?php echo $s['badge']; ?>">
                                <?php echo $s['estado']; ?>
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <button type="button" onclick="openOrderForSupplierId(<?php echo $s['id']; ?>, '<?php echo addslashes($s['nombre']); ?>')" class="bg-slate-900 hover:bg-slate-800 text-white px-3 py-1 text-[11px] font-mono font-medium uppercase rounded-none transition-none">
                                Pedir (PO)
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="p-3 bg-slate-50 border-t border-slate-200 flex flex-wrap items-center justify-between text-xs font-mono text-slate-500">
            <span><?php echo count($suppliers); ?> proveedores homologados registrados en MariaDB.</span>
            <span class="text-slate-700 font-semibold">Trazabilidad sanitaria de materias primas conforme</span>
        </div>
    </div>

    <!-- 4. ÓRDENES DE COMPRA RECIENTES (PERSISTIDAS EN MARIADB) -->
    <div class="bg-white border border-slate-200 rounded-none shadow-none">
        <div class="p-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900 flex items-center space-x-2">
                    <span class="w-2 h-2 bg-slate-900 rounded-none inline-block"></span>
                    <span>Libro Mayor // Órdenes de Compra (PO) Emitidas</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Historial correlativo de compromisos de pago registrados en MariaDB.</p>
            </div>
            <span class="text-xs font-mono text-slate-500 bg-slate-100 px-2 py-0.5 border border-slate-200">
                AUDITORÍA ACTIVA
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse font-mono">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-200 text-slate-700 font-semibold uppercase text-[11px]">
                        <th class="py-2.5 px-4">Folio PO</th>
                        <th class="py-2.5 px-4">Proveedor</th>
                        <th class="py-2.5 px-4">Fecha Emisión</th>
                        <th class="py-2.5 px-4">Detalle / Notas</th>
                        <th class="py-2.5 px-4 text-right">Monto Neto</th>
                        <th class="py-2.5 px-4 text-right">I.V.A. (19%)</th>
                        <th class="py-2.5 px-4 text-right">Total ($CLP)</th>
                        <th class="py-2.5 px-4 text-center">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php if (empty($recentOrders)): ?>
                    <tr>
                        <td colspan="8" class="py-4 text-center text-slate-400 italic">No hay órdenes de compra registradas.</td>
                    </tr>
                    <?php else: foreach ($recentOrders as $po): ?>
                    <tr class="hover:bg-slate-50">
                        <td class="py-2.5 px-4 font-bold text-slate-900"><?php echo htmlspecialchars($po['folio']); ?></td>
                        <td class="py-2.5 px-4 font-sans font-semibold text-slate-800"><?php echo htmlspecialchars($po['supplier_name']); ?></td>
                        <td class="py-2.5 px-4 text-slate-600"><?php echo htmlspecialchars($po['issue_date']); ?></td>
                        <td class="py-2.5 px-4 font-sans text-slate-600"><?php echo htmlspecialchars($po['notes'] ?? 'Sin observaciones'); ?></td>
                        <td class="py-2.5 px-4 text-right text-slate-700 tabular-nums"><?php echo formatCurrency((int)$po['net_amount']); ?></td>
                        <td class="py-2.5 px-4 text-right text-slate-700 tabular-nums"><?php echo formatCurrency((int)$po['tax']); ?></td>
                        <td class="py-2.5 px-4 text-right font-bold text-slate-900 tabular-nums"><?php echo formatCurrency((int)$po['total_amount']); ?></td>
                        <td class="py-2.5 px-4 text-center">
                            <span class="px-2 py-0.5 text-[10px] font-bold border <?php echo ($po['status'] === 'Pagado') ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : 'bg-amber-50 text-amber-800 border-amber-300'; ?>">
                                <?php echo htmlspecialchars($po['status']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- MODAL 1: NUEVA ORDEN DE COMPRA (FUNCIONAL CON GUARDADO EN BD) -->
<div id="modal-nueva-orden" class="hidden fixed inset-0 z-50 bg-slate-950/80 flex items-center justify-center p-4">
    <div class="bg-white rounded-none max-w-lg w-full p-6 border-2 border-slate-900 shadow-none">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div class="flex items-center space-x-2">
                <span class="material-symbols-outlined text-slate-900">post_add</span>
                <h3 class="text-base font-bold text-slate-900 uppercase font-mono tracking-tight">Nueva Orden de Compra (PO)</h3>
            </div>
            <button type="button" onclick="closeModal('modal-nueva-orden')" class="text-slate-400 hover:text-slate-900 text-xl font-mono">&times;</button>
        </div>

        <form id="form-nueva-orden" onsubmit="handleCreateOrder(event)" class="space-y-4 text-xs font-mono">
            <div>
                <label class="block uppercase tracking-wider text-slate-700 font-bold mb-1">Proveedor Homologado *</label>
                <select id="orden-proveedor-id" name="supplier_id" required class="w-full px-3 py-2 border border-slate-300 text-xs font-mono rounded-none focus:outline-none focus:border-slate-900">
                    <?php foreach ($suppliers as $s): ?>
                    <option value="<?php echo $s['id']; ?>">
                        <?php echo htmlspecialchars($s['nombre']); ?> (<?php echo htmlspecialchars($s['rubro']); ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block uppercase tracking-wider text-slate-700 font-bold mb-1">Monto Total Estimado ($CLP) *</label>
                <input type="number" id="orden-monto" name="monto" required min="1000" step="1000" placeholder="Ej. 650000" class="w-full px-3 py-2 border border-slate-300 text-xs font-mono rounded-none focus:outline-none focus:border-slate-900">
            </div>

            <div>
                <label class="block uppercase tracking-wider text-slate-700 font-bold mb-1">Detalle de Insumos y Observaciones de Entrega</label>
                <textarea id="orden-observaciones" name="observaciones" rows="2" placeholder="Ej. 10 sacos de harina flor especial 50kg en rampa de descarga..." class="w-full px-3 py-2 border border-slate-300 text-xs font-mono rounded-none focus:outline-none focus:border-slate-900"></textarea>
            </div>

            <div class="pt-2 flex space-x-2">
                <button type="button" onclick="closeModal('modal-nueva-orden')" class="flex-1 py-2.5 border border-slate-300 text-slate-800 font-bold uppercase hover:bg-slate-50 rounded-none">
                    Cancelar
                </button>
                <button type="submit" id="btn-emitir-po" class="flex-1 py-2.5 bg-slate-900 text-white font-bold uppercase hover:bg-slate-800 rounded-none">
                    Emitir Orden en BD
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2: BALANCE FINANCIERO GENERAL -->
<div id="modal-balance" class="hidden fixed inset-0 z-50 bg-slate-950/80 flex items-center justify-center p-4">
    <div class="bg-white rounded-none max-w-lg w-full p-6 border-2 border-slate-900 shadow-none">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div class="flex items-center space-x-2">
                <span class="material-symbols-outlined text-slate-900">account_balance</span>
                <h3 class="text-base font-bold text-slate-900 uppercase font-mono tracking-tight">Estado de Resultados &amp; Balance</h3>
            </div>
            <button type="button" onclick="closeModal('modal-balance')" class="text-slate-400 hover:text-slate-900 text-xl font-mono">&times;</button>
        </div>

        <div class="space-y-2 text-xs font-mono mb-5">
            <div class="flex justify-between p-2.5 bg-slate-50 border border-slate-200">
                <span class="text-slate-600 font-medium">Facturación Bruta POS + HORECA:</span>
                <span class="font-bold text-slate-900 tabular-nums"><?php echo formatCurrency($cuentasPorCobrar); ?></span>
            </div>
            <div class="flex justify-between p-2.5 bg-slate-50 border border-slate-200">
                <span class="text-slate-600 font-medium">Cuentas por Pagar a Proveedores:</span>
                <span class="font-bold text-amber-800 tabular-nums">-<?php echo formatCurrency($cuentasPorPagar); ?></span>
            </div>
            <div class="flex justify-between p-3 bg-amber-50 border border-amber-300 text-sm">
                <span class="font-bold text-slate-900">Superávit Operacional Neto:</span>
                <span class="font-bold text-amber-800 text-base tabular-nums"><?php echo formatCurrency($balanceGeneral); ?></span>
            </div>
        </div>

        <div class="flex space-x-2">
            <button type="button" onclick="closeModal('modal-balance')" class="flex-1 py-2.5 border border-slate-300 text-slate-800 font-mono font-bold uppercase hover:bg-slate-50 rounded-none">
                Cerrar
            </button>
            <button type="button" onclick="window.print();" class="flex-1 py-2.5 bg-slate-900 text-white font-mono font-bold uppercase hover:bg-slate-800 rounded-none">
                Imprimir Balance
            </button>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.remove('hidden');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('hidden');
    }

    function openOrderForSupplierId(id, name) {
        openModal('modal-nueva-orden');
        const select = document.getElementById('orden-proveedor-id');
        if (select) {
            select.value = id;
        }
    }

    function filterSuppliers() {
        const term = (document.getElementById('supplier-search').value || '').toLowerCase();
        const rows = document.querySelectorAll('.supplier-row');
        rows.forEach(r => {
            const text = r.textContent.toLowerCase();
            r.style.display = text.includes(term) ? '' : 'none';
        });
    }

    async function handleCreateOrder(e) {
        e.preventDefault();
        const supplierId = document.getElementById('orden-proveedor-id').value;
        const monto = document.getElementById('orden-monto').value;
        const observaciones = document.getElementById('orden-observaciones').value;
        const btn = document.getElementById('btn-emitir-po');

        btn.disabled = true;
        btn.textContent = 'Guardando en MariaDB...';

        try {
            const formData = new URLSearchParams();
            formData.append('action', 'create_po');
            formData.append('supplier_id', supplierId);
            formData.append('monto', monto);
            formData.append('observaciones', observaciones);

            const res = await fetch('suppliers.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            });
            const data = await res.json();

            if (data.success) {
                alert(`¡Orden de Compra PO emitida y guardada en MariaDB!\n\nFolio: ${data.folio}\nMonto: $${parseInt(monto, 10).toLocaleString('es-CL')}`);
                closeModal('modal-nueva-orden');
                location.reload();
            } else {
                alert('Error al emitir orden: ' + (data.error || 'Error desconocido'));
            }
        } catch (err) {
            console.error(err);
            alert('Error de conexión con el servidor.');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Emitir Orden en BD';
        }
    }
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
