<?php
/**
 * Módulo de Contabilidad y Proveedores
 * Panadería y Pastelería Pan y Queque
 * Diseñado bajo los estándares del Atelier Architectural ERP (Plantilla/stitch_bakery_erp_system/proveedores_finanzas/)
 */
$currentPage = 'suppliers';
$pageTitle = 'Proveedores & Finanzas';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/SupplierService.php';

// Cargar métricas y proveedores desde SupplierService
$suppliers = SupplierService::getAllSuppliers();
$metrics = SupplierService::getFinancialMetrics();
$cuentasPorPagar = $metrics['accountsPayable'];
$cuentasPorCobrar = $metrics['accountsReceivable'];
$balanceGeneral = $metrics['generalBalance'];
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
                Balance de devengo, compras industriales de harinas y conciliación de cuentas HORECA.
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
                <span>Exportar Balances (CSV/XLS)</span>
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
                    <span>Vencimiento &lt;15 días:</span>
                    <strong class="text-amber-800 font-bold">$1.850.000</strong>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Vencimiento 30-60 días:</span>
                    <strong class="text-slate-900">$1.100.000</strong>
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
                <div class="text-xs font-bold text-slate-800 uppercase">Cuentas por Cobrar (HORECA)</div>
                <div class="text-2xl font-bold font-mono text-slate-950 mt-2 tabular-nums">
                    <?php echo formatCurrency($cuentasPorCobrar); ?>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-[11px] font-mono">
                <div class="flex justify-between text-slate-700">
                    <span>Cartera HORECA Activa:</span>
                    <strong class="text-emerald-800 font-bold">18 Clientes A1</strong>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Hoteles y Cadenas:</span>
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
                    <span>Caja Chica + Bancos:</span>
                    <strong class="text-emerald-700">Auditado</strong>
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
                    <span>Presupuesto Ejecutado:</span>
                    <strong class="text-blue-900 font-bold">84.6%</strong>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Límite Mensual Autorizado:</span>
                    <strong class="text-slate-900">$45.000.000</strong>
                </div>
                <div class="w-full bg-slate-200 h-1.5 mt-2 rounded-none">
                    <div class="bg-blue-700 h-1.5" style="width: 84.6%"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. DIRECTORIO DE PROVEEDORES HOMOLOGADOS (TABLA MAESTRA PLANAR) -->
    <div class="bg-white border border-slate-200 rounded-none shadow-none">
        
        <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 flex items-center space-x-2">
                    <span class="w-2 h-2 bg-slate-900 rounded-none inline-block"></span>
                    <span>Directorio de Proveedores Homologados (Cadena Acreditada)</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Relación de fabricantes auditados, condiciones comerciales y cuentas por liquidar.</p>
            </div>

            <!-- Buscador en tiempo real -->
            <div class="relative w-full sm:w-80">
                <input type="text" id="supplier-search" onkeyup="filterSuppliers()" placeholder="Buscar proveedor, insumo o RUT..." class="w-full pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-300 text-xs font-mono rounded-none focus:outline-none focus:bg-white focus:border-slate-900">
                <span class="material-symbols-outlined text-slate-400 absolute left-2 top-2 text-sm">search</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs" id="suppliers-table">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-200 text-slate-700 font-mono font-semibold uppercase tracking-wider text-[11px]">
                        <th class="py-3 px-4">Proveedor / Razón Social</th>
                        <th class="py-3 px-4 font-mono">R.U.T.</th>
                        <th class="py-3 px-4">Insumo Crítico Suministrado</th>
                        <th class="py-3 px-4 text-center">Última Compra</th>
                        <th class="py-3 px-4 text-right">Monto Devengado</th>
                        <th class="py-3 px-4 text-center">Estado Devengo</th>
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
                            <button type="button" onclick="openOrderForSupplier('<?php echo addslashes($s['nombre']); ?>')" class="bg-slate-900 hover:bg-slate-800 text-white px-3 py-1 text-[11px] font-mono font-medium uppercase rounded-none transition-none">
                                Pedir (PO)
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="p-3 bg-slate-50 border-t border-slate-200 flex flex-wrap items-center justify-between text-xs font-mono text-slate-500">
            <span>5 proveedores estratégicos registrados en el obrador central.</span>
            <span class="text-slate-700 font-semibold">Trazabilidad sanitaria de materias primas conforme</span>
        </div>
    </div>

    <!-- 4. MATERIAS PRIMAS CRÍTICAS EN SILO & CÁMARAS (PLANAR RECTANGULAR) -->
    <section class="bg-white border border-slate-200 p-5 rounded-none">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <h3 class="text-xs font-mono uppercase tracking-wider text-slate-800 font-bold flex items-center space-x-2">
                <span class="material-symbols-outlined text-sm text-amber-700">inventory_2</span>
                <span>Stock de Materias Primas Críticas &bull; Niveles de Reabastecimiento</span>
            </h3>
            <span class="text-xs font-mono text-slate-500">Corte al turno matutino</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs font-mono">
            <div class="p-3 bg-slate-50 border border-slate-200">
                <div class="text-slate-500 uppercase text-[10px]">Harina Especial Flor T65</div>
                <div class="text-lg font-bold text-slate-900 mt-1 tabular-nums">8.400 kg</div>
                <div class="text-[11px] text-emerald-700 mt-0.5">Capacidad Silo: 72% [ÓPTIMO]</div>
            </div>
            <div class="p-3 bg-slate-50 border border-slate-200">
                <div class="text-slate-500 uppercase text-[10px]">Levadura Fresca Prensada</div>
                <div class="text-lg font-bold text-slate-900 mt-1 tabular-nums">450 kg</div>
                <div class="text-[11px] text-emerald-700 mt-0.5">Cámara Fría: 85% [ÓPTIMO]</div>
            </div>
            <div class="p-3 bg-slate-50 border border-slate-200">
                <div class="text-slate-500 uppercase text-[10px]">Mantequilla 84% MG Isigny</div>
                <div class="text-lg font-bold text-slate-900 mt-1 tabular-nums">620 kg</div>
                <div class="text-[11px] text-amber-700 mt-0.5">Cámara Congelada: 68% [REORDEN]</div>
            </div>
            <div class="p-3 bg-slate-50 border border-slate-200">
                <div class="text-slate-500 uppercase text-[10px]">Bolsas Kraft &amp; Cajas Torta</div>
                <div class="text-lg font-bold text-slate-900 mt-1 tabular-nums">12.500 un</div>
                <div class="text-[11px] text-emerald-700 mt-0.5">Bodega Seca: 90% [ÓPTIMO]</div>
            </div>
        </div>
    </section>

</div>

<!-- MODAL 1: NUEVA ORDEN DE COMPRA (PLANAR RECTANGULAR SÓLIDO) -->
<div id="modal-nueva-orden" class="hidden fixed inset-0 z-50 bg-slate-950/80 flex items-center justify-center p-4">
    <div class="bg-white rounded-none max-w-lg w-full p-6 border-2 border-slate-900 shadow-none">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div class="flex items-center space-x-2">
                <span class="material-symbols-outlined text-slate-900">post_add</span>
                <h3 class="text-base font-bold text-slate-900 uppercase font-mono tracking-tight">Nueva Orden de Compra (PO)</h3>
            </div>
            <button type="button" onclick="closeModal('modal-nueva-orden')" class="text-slate-400 hover:text-slate-900 text-xl font-mono">&times;</button>
        </div>

        <form onsubmit="handleCreateOrder(event)" class="space-y-4 text-xs font-mono">
            <div>
                <label class="block uppercase tracking-wider text-slate-700 font-bold mb-1">Proveedor Homologado *</label>
                <select id="orden-proveedor" required class="w-full px-3 py-2 border border-slate-300 text-xs font-mono rounded-none focus:outline-none focus:border-slate-900">
                    <?php foreach ($suppliers as $s): ?>
                    <option value="<?php echo htmlspecialchars($s['nombre']); ?>">
                        <?php echo htmlspecialchars($s['nombre']); ?> (<?php echo htmlspecialchars($s['rubro']); ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block uppercase tracking-wider text-slate-700 font-bold mb-1">Cantidad / Volumen *</label>
                    <input type="text" id="orden-cantidad" required placeholder="Ej. 500 kg / 20 sacos" class="w-full px-3 py-2 border border-slate-300 text-xs font-mono rounded-none focus:outline-none focus:border-slate-900">
                </div>
                <div>
                    <label class="block uppercase tracking-wider text-slate-700 font-bold mb-1">Monto Estimado ($CLP) *</label>
                    <input type="number" id="orden-monto" required placeholder="650000" class="w-full px-3 py-2 border border-slate-300 text-xs font-mono rounded-none focus:outline-none focus:border-slate-900">
                </div>
            </div>

            <div>
                <label class="block uppercase tracking-wider text-slate-700 font-bold mb-1">Observaciones de Entrega en Obrador</label>
                <textarea rows="2" placeholder="Recepción en rampa central obrador antes de las 07:30 hrs..." class="w-full px-3 py-2 border border-slate-300 text-xs font-mono rounded-none focus:outline-none focus:border-slate-900"></textarea>
            </div>

            <div class="pt-2 flex space-x-2">
                <button type="button" onclick="closeModal('modal-nueva-orden')" class="flex-1 py-2.5 border border-slate-300 text-slate-800 font-bold uppercase hover:bg-slate-50 rounded-none">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-slate-900 text-white font-bold uppercase hover:bg-slate-800 rounded-none">
                    Emitir Orden (PO)
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2: BALANCE FINANCIERO GENERAL (PLANAR RECTANGULAR SÓLIDO) -->
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
                <span class="font-bold text-slate-900 tabular-nums">$8.920.000</span>
            </div>
            <div class="flex justify-between p-2.5 bg-slate-50 border border-slate-200">
                <span class="text-slate-600 font-medium">Costo de Materias Primas Auditado:</span>
                <span class="font-bold text-amber-800 tabular-nums">-$3.450.000</span>
            </div>
            <div class="flex justify-between p-2.5 bg-slate-50 border border-slate-200">
                <span class="text-slate-600 font-medium">Gastos Logística &amp; Flota Refrigerada:</span>
                <span class="font-bold text-slate-800 tabular-nums">-$1.000.000</span>
            </div>
            <div class="flex justify-between p-3 bg-amber-50 border border-amber-300 text-sm">
                <span class="font-bold text-slate-900">Superávit Operacional Neto:</span>
                <span class="font-bold text-amber-800 text-base tabular-nums">+$4.470.000</span>
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

    function openOrderForSupplier(provName) {
        openModal('modal-nueva-orden');
        const select = document.getElementById('orden-proveedor');
        if (select) {
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].text.includes(provName)) {
                    select.selectedIndex = i;
                    break;
                }
            }
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

    function handleCreateOrder(e) {
        e.preventDefault();
        const prov = document.getElementById('orden-proveedor').value;
        const cant = document.getElementById('orden-cantidad').value;
        const monto = parseInt(document.getElementById('orden-monto').value, 10) || 0;
        alert(`¡Orden de Compra PO emitida exitosamente!\n\nProveedor: ${prov}\nCantidad: ${cant}\nMonto: $${monto.toLocaleString('es-CL')}`);
        closeModal('modal-nueva-orden');
    }
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
