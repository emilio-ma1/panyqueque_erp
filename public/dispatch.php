<?php
/**
 * Módulo de Logística, Despacho y Cadena de Frío HORECA
 * Panadería y Pastelería Pan y Queque
 * Diseñado bajo los estándares del Atelier Architectural ERP (Plantilla/stitch_bakery_erp_system/log_stica_rutas/)
 */
$currentPage = 'dispatch';
$pageTitle = 'Logística & Rutas HORECA';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/DispatchService.php';

// Cargar rutas de despacho desde DispatchService
$routes = DispatchService::getAllRoutes();
?>

<!-- CONTENEDOR PRINCIPAL: LOGÍSTICA & RUTAS -->
<div class="p-4 sm:p-6 lg:p-8 max-w-[1536px] mx-auto space-y-6">

    <!-- 1. ENCABEZADO DE SECCIÓN Y CONTROLES OPERATIVOS -->
    <section class="bg-white border border-slate-200 p-5 rounded-none shadow-none flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-amber-700 rounded-none inline-block"></span>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-amber-700">Módulo 04 // Control Maestro de Distribución</span>
                <span class="text-slate-400 font-mono">/</span>
                <span class="text-xs font-mono text-slate-600 font-medium">TERMINAL MADRUGADA-SUR #01</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                Módulo 04 // Logística, Despacho y Cadena de Frío HORECA
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 max-w-4xl">
                Trazabilidad térmica activa, telemetría de furgones y liquidación de albaranes en tiempo real para alta hostelería y obradores satélite.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3 shrink-0">
            <div class="bg-slate-50 border border-slate-200 px-3 py-2 flex items-center gap-2.5 rounded-none">
                <span class="material-symbols-outlined text-slate-700 text-lg">schedule</span>
                <div class="flex flex-col">
                    <span class="text-[10px] font-mono uppercase text-slate-500 font-semibold">Turno de Salida</span>
                    <span class="text-xs font-mono font-bold text-slate-900">05:00 MADRUGADA</span>
                </div>
            </div>
            <div class="bg-slate-50 border border-slate-200 px-3 py-2 flex items-center gap-2.5 rounded-none">
                <span class="material-symbols-outlined text-emerald-700 text-lg">verified_user</span>
                <div class="flex flex-col">
                    <span class="text-[10px] font-mono uppercase text-slate-500 font-semibold">Cert. Sanitaria</span>
                    <span class="text-xs font-mono font-bold text-slate-900">ISO-22000 OK</span>
                </div>
            </div>
            <button type="button" onclick="location.reload();" class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2.5 text-xs font-bold uppercase font-mono tracking-wider rounded-none flex items-center gap-1.5 border border-slate-900 transition-none">
                <span class="material-symbols-outlined text-base">sync</span>
                <span>Sincronizar Telemetría</span>
            </button>
        </div>
    </section>

    <!-- 2. MÉTRICAS RÁPIDAS DE DESPACHO (4 TARJETAS SÓLIDAS ZERO-PILL) -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Tarjeta 1 -->
        <div class="bg-white border border-slate-200 p-4 rounded-none flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-mono font-semibold uppercase text-slate-500 tracking-wider">Expediciones Hoy</span>
                <span class="material-symbols-outlined text-slate-400 text-xl">local_shipping</span>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-bold font-mono text-slate-900 tabular-nums">5 / 5</div>
                <div class="text-xs text-emerald-800 font-medium flex items-center gap-1.5 mt-1">
                    <span class="w-2 h-2 bg-emerald-600 rounded-none inline-block"></span>
                    <span>100% albaranes en curso</span>
                </div>
            </div>
        </div>

        <!-- Tarjeta 2 -->
        <div class="bg-white border border-slate-200 p-4 rounded-none flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-mono font-semibold uppercase text-slate-500 tracking-wider">Carga Total Salida</span>
                <span class="material-symbols-outlined text-slate-400 text-xl">scale</span>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-bold font-mono text-slate-900 tabular-nums">1.420 kg</div>
                <div class="text-xs text-slate-600 font-mono mt-1">
                    Capacidad media de bodega: <span class="font-bold text-slate-900">74%</span>
                </div>
            </div>
        </div>

        <!-- Tarjeta 3 -->
        <div class="bg-white border border-slate-200 p-4 rounded-none flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-mono font-semibold uppercase text-slate-500 tracking-wider">Piezas Despachadas</span>
                <span class="material-symbols-outlined text-slate-400 text-xl">bakery_dining</span>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-bold font-mono text-amber-700 tabular-nums">2.840 uds</div>
                <div class="text-xs text-slate-600 font-medium mt-1">
                    Hogazas rústicas y viennoiserie AOP
                </div>
            </div>
        </div>

        <!-- Tarjeta 4 -->
        <div class="bg-white border border-slate-200 p-4 rounded-none flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-mono font-semibold uppercase text-slate-500 tracking-wider">Cumplimiento Ventanas</span>
                <span class="material-symbols-outlined text-slate-400 text-xl">timer</span>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-bold font-mono text-slate-900 tabular-nums">98.4%</div>
                <div class="text-xs text-emerald-800 font-mono mt-1 flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-emerald-600 rounded-none inline-block"></span>
                    <span>Tolerancia máx: 8 min</span>
                </div>
            </div>
        </div>

    </section>

    <!-- 3. MONITOR DE UNIDADES MÓVILES (FLOTA DE REPARTO: 3 TARJETAS EN GRID) -->
    <section class="flex flex-col gap-3">
        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-slate-800 rounded-none inline-block"></span>
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 font-mono">
                    Monitor de Unidades Móviles // Flota de Distribución Activa
                </h2>
            </div>
            <div class="text-xs font-mono text-slate-500">
                Frecuencia telemetría GPS: <span class="font-bold text-slate-700">10s (SAT-ACTIVE)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            
            <!-- FURGÓN 1 -->
            <div class="bg-white border border-slate-200 p-4 rounded-none flex flex-col justify-between gap-4">
                <div>
                    <div class="flex items-start justify-between border-b border-slate-100 pb-3">
                        <div>
                            <span class="bg-blue-100 text-blue-900 text-[10px] font-mono font-bold uppercase px-2 py-0.5 rounded-none border border-blue-200">
                                Sonda Frío Activa
                            </span>
                            <h3 class="text-base font-bold text-slate-900 mt-1">Furgón Isotérmico Frío #01</h3>
                            <div class="text-xs font-mono text-slate-500">Móvil: <span class="font-bold text-slate-800">PQ-88-21 (ATP)</span></div>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 px-2.5 py-1 text-right">
                            <div class="text-[9px] font-mono uppercase text-slate-500 font-bold">Temperatura</div>
                            <div class="text-sm font-mono font-bold text-emerald-800">3.8°C SÓLIDO</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-2 text-xs">
                        <div class="flex justify-between border-b border-slate-100 pb-1">
                            <span class="text-slate-500">Conductor:</span>
                            <span class="font-semibold text-slate-900">Juan Pablo Riquelme</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-1">
                            <span class="text-slate-500">Corredor:</span>
                            <span class="font-medium text-slate-800 text-right">Hoteles &amp; Cafeterías Zona Oriente</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-1">
                            <span class="text-slate-500">Albaranes:</span>
                            <span class="font-mono font-bold text-slate-800">3 Albaranes en ruta</span>
                        </div>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <div class="flex justify-between items-center text-xs mb-1 font-mono">
                        <span class="text-slate-500 uppercase text-[10px]">Carga: 680 / 800 kg</span>
                        <span class="font-bold text-slate-900">85% Capacidad</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200 rounded-none">
                        <div class="h-2.5 bg-amber-700 rounded-none" style="width: 85%;"></div>
                    </div>
                </div>
            </div>

            <!-- FURGÓN 2 -->
            <div class="bg-white border border-slate-200 p-4 rounded-none flex flex-col justify-between gap-4">
                <div>
                    <div class="flex items-start justify-between border-b border-slate-100 pb-3">
                        <div>
                            <span class="bg-amber-100 text-amber-900 text-[10px] font-mono font-bold uppercase px-2 py-0.5 rounded-none border border-amber-200">
                                Climatizado Panadería
                            </span>
                            <h3 class="text-base font-bold text-slate-900 mt-1">Furgón Seco Obrador #02</h3>
                            <div class="text-xs font-mono text-slate-500">Móvil: <span class="font-bold text-slate-800">PQ-91-02 (Seco)</span></div>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 px-2.5 py-1 text-right">
                            <div class="text-[9px] font-mono uppercase text-slate-500 font-bold">Temperatura</div>
                            <div class="text-sm font-mono font-bold text-slate-800">18.5°C ESTABLE</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-2 text-xs">
                        <div class="flex justify-between border-b border-slate-100 pb-1">
                            <span class="text-slate-500">Conductor:</span>
                            <span class="font-semibold text-slate-900">Andrés Lagos</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-1">
                            <span class="text-slate-500">Corredor:</span>
                            <span class="font-medium text-slate-800 text-right">Supermercados y Sedes Satélite</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-1">
                            <span class="text-slate-500">Albaranes:</span>
                            <span class="font-mono font-bold text-slate-800">2 Albaranes en ruta</span>
                        </div>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <div class="flex justify-between items-center text-xs mb-1 font-mono">
                        <span class="text-slate-500 uppercase text-[10px]">Carga: 450 / 750 kg</span>
                        <span class="font-bold text-slate-900">60% Capacidad</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200 rounded-none">
                        <div class="h-2.5 bg-amber-600 rounded-none" style="width: 60%;"></div>
                    </div>
                </div>
            </div>

            <!-- FURGÓN 3 -->
            <div class="bg-white border border-slate-200 p-4 rounded-none flex flex-col justify-between gap-4">
                <div>
                    <div class="flex items-start justify-between border-b border-slate-100 pb-3">
                        <div>
                            <span class="bg-emerald-100 text-emerald-900 text-[10px] font-mono font-bold uppercase px-2 py-0.5 rounded-none border border-emerald-200">
                                Congelación Pastelería
                            </span>
                            <h3 class="text-base font-bold text-slate-900 mt-1">Furgón Ultra-Congelado #03</h3>
                            <div class="text-xs font-mono text-slate-500">Móvil: <span class="font-bold text-slate-800">PQ-63-90 (Cold)</span></div>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 px-2.5 py-1 text-right">
                            <div class="text-[9px] font-mono uppercase text-slate-500 font-bold">Temperatura</div>
                            <div class="text-sm font-mono font-bold text-blue-900">-18.2°C CONG</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-2 text-xs">
                        <div class="flex justify-between border-b border-slate-100 pb-1">
                            <span class="text-slate-500">Conductor:</span>
                            <span class="font-semibold text-slate-900">Roberto Díaz</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-1">
                            <span class="text-slate-500">Corredor:</span>
                            <span class="font-medium text-slate-800 text-right">Banquetería y Eventos Especiales</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-1">
                            <span class="text-slate-500">Albaranes:</span>
                            <span class="font-mono font-bold text-slate-800">1 Albarán programado</span>
                        </div>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <div class="flex justify-between items-center text-xs mb-1 font-mono">
                        <span class="text-slate-500 uppercase text-[10px]">Carga: 290 / 600 kg</span>
                        <span class="font-bold text-slate-900">48% Capacidad</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200 rounded-none">
                        <div class="h-2.5 bg-slate-700 rounded-none" style="width: 48%;"></div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 4. HOJA DE RUTA Y ALBARANES ASIGNADOS (TABLA DE CONTROL MAESTRO) -->
    <section class="bg-white border border-slate-200 rounded-none shadow-none">
        
        <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 flex items-center space-x-2">
                    <span class="w-2 h-2 bg-amber-700 rounded-none inline-block"></span>
                    <span>Hojas de Ruta Asignadas para Hoy (Despacho HORECA)</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Control de horarios de entrega, firma de recepción digital y trazabilidad térmica.</p>
            </div>
            <div class="text-xs font-mono text-slate-600 bg-slate-100 px-3 py-1 border border-slate-200 rounded-none">
                VENTANA MATUTINA: 06:00 - 10:30 HRS
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-200 text-slate-700 font-mono font-semibold uppercase tracking-wider text-[11px]">
                        <th class="py-3 px-4">Albarán / Destino</th>
                        <th class="py-3 px-4">Cliente HORECA</th>
                        <th class="py-3 px-4">Dirección</th>
                        <th class="py-3 px-4 text-center">Horario Estimado</th>
                        <th class="py-3 px-4">Detalle de Carga</th>
                        <th class="py-3 px-4 text-center">Estado</th>
                        <th class="py-3 px-4 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-800">
                    <?php foreach ($routes as $r): ?>
                    <tr class="hover:bg-slate-50 transition-none">
                        <td class="py-3.5 px-4 font-bold text-slate-900">
                            <?php echo htmlspecialchars($r['titulo']); ?>
                            <span class="block text-[11px] font-mono text-slate-500 font-normal">Móvil N° 04</span>
                        </td>
                        <td class="py-3.5 px-4 font-semibold text-slate-900">
                            <?php echo htmlspecialchars($r['cliente']); ?>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600 font-mono text-[11px]">
                            <?php echo htmlspecialchars($r['destino']); ?>
                        </td>
                        <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-800">
                            <?php echo $r['hora']; ?>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600">
                            <?php echo htmlspecialchars($r['carga']); ?>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase rounded-none border <?php echo $r['estado_color']; ?>">
                                <?php echo $r['estado']; ?>
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <?php if ($r['completado']): ?>
                            <span class="text-emerald-700 font-mono text-xs font-bold inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                <span>RECIBIDO</span>
                            </span>
                            <?php else: ?>
                            <button type="button" onclick="confirmDelivery(<?php echo $r['id']; ?>, '<?php echo addslashes($r['cliente']); ?>')" class="bg-amber-700 hover:bg-amber-800 text-white px-3 py-1 text-[11px] font-mono font-semibold uppercase rounded-none transition-none">
                                Confirmar Entrega
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="p-3 bg-slate-50 border-t border-slate-200 flex flex-wrap items-center justify-between text-xs font-mono text-slate-500">
            <span>Rutas sincronizadas con telemetría satelital en tiempo real.</span>
            <span class="text-slate-700 font-semibold">Trazabilidad térmica certificada para alimentos perecibles</span>
        </div>
    </section>

</div>

<!-- MODAL: CONFIRMAR ENTREGA (PLANAR RECTANGULAR SÓLIDO) -->
<div id="modal-entrega" class="hidden fixed inset-0 z-50 bg-slate-950/80 flex items-center justify-center p-4">
    <div class="bg-white rounded-none max-w-md w-full p-6 border-2 border-slate-900 shadow-none">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div class="flex items-center space-x-2">
                <span class="material-symbols-outlined text-slate-900">verified</span>
                <h3 class="text-base font-bold text-slate-900 uppercase font-mono tracking-tight">Confirmación de Entrega HORECA</h3>
            </div>
            <button type="button" onclick="closeModal('modal-entrega')" class="text-slate-400 hover:text-slate-900 text-xl font-mono">&times;</button>
        </div>

        <form onsubmit="handleSignatureDelivery(event)" class="space-y-4 text-xs font-mono">
            <p class="text-slate-600 leading-relaxed">
                Confirmando recepción para cliente: <strong id="modal-cliente" class="text-slate-900 block text-sm mt-1"></strong>
            </p>

            <div>
                <label class="block uppercase tracking-wider text-slate-700 font-bold mb-1">Nombre de Quien Recibe *</label>
                <input type="text" id="recibe-nombre" required placeholder="Ej. Camila Morales (Jefa de Bodega)" class="w-full px-3 py-2 border border-slate-300 text-xs font-mono rounded-none focus:outline-none focus:border-slate-900">
            </div>

            <div>
                <label class="block uppercase tracking-wider text-slate-700 font-bold mb-1">Firma Digital / Observaciones de Temperatura</label>
                <textarea id="recibe-obs" rows="2" placeholder="Mercadería recibida conforme a temperatura óptima (+3.8°C)..." class="w-full px-3 py-2 border border-slate-300 text-xs font-mono rounded-none focus:outline-none focus:border-slate-900"></textarea>
            </div>

            <div class="pt-2 flex space-x-2">
                <button type="button" onclick="closeModal('modal-entrega')" class="flex-1 py-2.5 border border-slate-300 text-slate-800 font-mono font-bold uppercase hover:bg-slate-50 rounded-none">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-slate-900 text-white font-mono font-bold uppercase hover:bg-slate-800 rounded-none">
                    Registrar Entrega
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmDelivery(id, cliente) {
        document.getElementById('modal-cliente').textContent = cliente;
        document.getElementById('modal-entrega').classList.remove('hidden');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('hidden');
    }

    function handleSignatureDelivery(e) {
        e.preventDefault();
        const recipientName = document.getElementById('recibe-nombre').value;
        alert(`¡Entrega confirmada y registrada en hoja de ruta!\n\nReceptor: ${recipientName}\nHora: ${new Date().toLocaleTimeString('es-CL')}\nTemperatura Conforme: +3.8°C`);
        closeModal('modal-entrega');
        location.reload();
    }
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
