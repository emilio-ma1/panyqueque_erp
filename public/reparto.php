<?php
/**
 * Módulo de Logística y Reparto
 * Panadería y Pastelería Pan y Queque
 * Basado en la plantilla elegante de Haute Boulangerie (Plantilla/code.html)
 */
$currentPage = 'reparto';
$pageTitle = 'Logística & Despachos';
require_once __DIR__ . '/../includes/header.php';

// Definición de rutas del día
$routes = [
    [
        'id' => 1,
        'hora' => '08:30 AM',
        'titulo' => 'Ruta 1: Despacho de Pan Fresco',
        'destino' => 'Supermercado Central (Av. Bernardo O\'Higgins #450)',
        'carga' => '50 kg de Pan Marraqueta de Masa Madre y 30 kg de Hallullas Especiales',
        'cliente' => 'Supermercado Central S.A.',
        'estado' => 'Entregado',
        'estado_color' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
        'icono_estado' => '✓',
        'completado' => true
    ],
    [
        'id' => 2,
        'hora' => '11:00 AM',
        'titulo' => 'Ruta 2: Repostería Fina & Viennoiserie',
        'destino' => 'Cafetería Gourmet Oriente (Av. Vitacura #2890)',
        'carga' => '12 Tortas de Chocolate Grand Cru, 15 bandejas de pasteles surtidos y bollería fina',
        'cliente' => 'Gourmet Oriente SpA',
        'estado' => 'En Camino',
        'estado_color' => 'bg-amber-50 text-amber-800 border-amber-200',
        'icono_estado' => '🚛',
        'completado' => false
    ],
    [
        'id' => 3,
        'hora' => '15:00 PM',
        'titulo' => 'Ruta 3: Abastecimiento y Despacho General',
        'destino' => 'Sucursal Norte (Av. Independencia #1200)',
        'carga' => '40 kg harinas especiales, 20 kg empanadas de pino y materias primas en tránsito',
        'cliente' => 'Sucursal Norte Pan y Queque',
        'estado' => 'Pendiente',
        'estado_color' => 'bg-gray-100 text-gray-700 border-gray-200',
        'icono_estado' => '⏳',
        'completado' => false
    ]
];

// Carga dinámica de rutas desde PostgreSQL si la base de datos está disponible
$dbRoutes = (class_exists('DB')) ? DB::select("SELECT * FROM rutas_despacho ORDER BY id ASC") : [];
if (!empty($dbRoutes)) {
    $routes = array_map(function($r) {
        $estado = $r['estado'] ?? 'Pendiente';
        $color = 'bg-gray-100 text-gray-700 border-gray-200';
        $icono = '⏳';
        $completado = false;
        if ($estado === 'Entregado') {
            $color = 'bg-emerald-50 text-emerald-800 border-emerald-200';
            $icono = '✓';
            $completado = true;
        } elseif ($estado === 'En camino' || $estado === 'En Camino') {
            $color = 'bg-amber-50 text-amber-800 border-amber-200';
            $icono = '🚛';
        }
        return [
            'id' => (int)$r['id'],
            'hora' => $r['hora'],
            'titulo' => $r['titulo'],
            'destino' => $r['destino'] . (!empty($r['direccion']) ? ' (' . $r['direccion'] . ')' : ''),
            'carga' => $r['items'] ?? 'Carga general de panadería',
            'cliente' => $r['destino'],
            'estado' => $estado,
            'estado_color' => $color,
            'icono_estado' => $icono,
            'completado' => $completado
        ];
    }, $dbRoutes);
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
        <span class="text-brand-charcoal font-semibold">Logística &amp; Reparto</span>
    </nav>

    <!-- Page Header -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-200/80 shadow-sm mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-full border border-brand-gold/40 flex items-center justify-center text-brand-gold bg-brand-sand">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl font-normal text-brand-charcoal tracking-tight">
                    Logística &amp; Despachos
                </h1>
            </div>
            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                <span class="bg-brand-sand text-brand-gold border border-brand-gold/30 font-medium px-2.5 py-0.5 rounded-full uppercase tracking-wider text-[11px]">
                    Flota de Despacho
                </span>
                <span>&bull;</span>
                <span>Conductor: <strong class="text-brand-charcoal">Juan Pablo Riquelme</strong></span>
                <span>&bull;</span>
                <span>Móvil: <strong class="text-brand-charcoal">Furgón Refrigerado N° 04 (PQ-88-21)</strong></span>
            </div>
        </div>

        <div class="flex items-center space-x-2">
            <button type="button" onclick="location.reload();" class="inline-flex items-center px-4 py-2.5 rounded-lg bg-white hover:bg-brand-sand text-brand-charcoal border border-gray-200 hover:border-brand-gold text-xs uppercase tracking-widest font-semibold shadow-sm transition-all">
                <svg class="w-4 h-4 mr-1.5 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span>Sincronizar Ruta</span>
            </button>
        </div>
    </div>

    <!-- Status Banner (Plantilla Style) -->
    <div class="bg-brand-charcoal text-white rounded-2xl p-6 border border-gray-800 shadow-md mb-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-full border border-brand-gold/50 flex items-center justify-center text-brand-gold bg-brand-gold/10 flex-shrink-0">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-gold"></span>
                </div>

                <div>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs uppercase tracking-widest text-brand-gold font-semibold">
                            Itinerario Matutino Activo
                        </span>
                    </div>
                    <p class="text-xs text-gray-300 mt-0.5 font-light">
                        Despacho continuo desde obrador central hacia supermercados, cafeterías y sucursales.
                    </p>
                </div>
            </div>

            <div class="text-left sm:text-right">
                <span class="text-[10px] text-gray-400 uppercase tracking-widest block">Turno Programado</span>
                <span class="font-serif text-lg font-semibold text-brand-gold">07:30 - 15:30 hrs</span>
            </div>

        </div>
    </div>

    <!-- Timeline of Routes -->
    <div class="space-y-6 mb-12">
        <h2 class="font-serif text-2xl text-brand-charcoal font-medium">Hojas de Ruta Asignadas para Hoy</h2>

        <div class="space-y-4">
            <?php foreach ($routes as $r): ?>
            <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-200/80 shadow-sm hover:border-brand-gold/60 transition-all flex flex-col md:flex-row md:items-center justify-between gap-6">
                
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-brand-sand border border-brand-gold/30 flex items-center justify-center text-brand-gold font-serif font-bold text-lg flex-shrink-0">
                        <?php echo $r['icono_estado']; ?>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs font-bold text-brand-gold uppercase tracking-wider"><?php echo $r['hora']; ?></span>
                            <span>&bull;</span>
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium border <?php echo $r['estado_color']; ?>">
                                <?php echo $r['estado']; ?>
                            </span>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-brand-charcoal">
                            <?php echo $r['titulo']; ?>
                        </h3>
                        <p class="text-xs text-gray-600 font-medium">
                            Destino: <span class="text-brand-charcoal"><?php echo $r['destino']; ?></span>
                        </p>
                        <p class="text-xs text-gray-500 font-light">
                            Detalle de Carga: <?php echo $r['carga']; ?>
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3 self-end md:self-center">
                    <?php if ($r['completado']): ?>
                    <button type="button" disabled class="px-4 py-2.5 rounded-lg bg-gray-100 text-gray-400 text-xs uppercase tracking-wider font-semibold cursor-not-allowed">
                        Entregado ✓
                    </button>
                    <?php else: ?>
                    <button type="button" onclick="confirmDelivery(<?php echo $r['id']; ?>, '<?php echo addslashes($r['cliente']); ?>')" class="px-5 py-2.5 rounded-lg bg-brand-gold hover:bg-brand-goldHover text-white text-xs uppercase tracking-wider font-semibold shadow-sm transition-all hover:scale-105">
                        Confirmar Entrega
                    </button>
                    <?php endif; ?>
                </div>

            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>

<!-- Modal: Confirmar Entrega -->
<div id="modal-entrega" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-8 shadow-2xl border border-gray-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-6">
            <h3 class="font-serif text-2xl font-bold text-brand-charcoal">Confirmación de Entrega</h3>
            <button type="button" onclick="closeModal('modal-entrega')" class="text-gray-400 hover:text-brand-charcoal text-xl">&times;</button>
        </div>

        <form onsubmit="handleFirma(event)" class="space-y-4 text-xs">
            <p class="text-gray-600 leading-relaxed">
                Confirmando recepción para cliente: <strong id="modal-cliente" class="text-brand-charcoal block text-sm mt-1"></strong>
            </p>

            <div>
                <label class="block uppercase tracking-wider text-gray-700 font-semibold mb-1">Nombre de Quien Recibe *</label>
                <input type="text" id="recibe-nombre" required placeholder="Ej. Camila Morales (Jefa de Bodega)" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-gold">
            </div>

            <div>
                <label class="block uppercase tracking-wider text-gray-700 font-semibold mb-1">Firma Digital / Observaciones</label>
                <textarea id="recibe-obs" rows="2" placeholder="Mercadería recibida conforme a temperatura óptima..." class="w-full px-3.5 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-gold"></textarea>
            </div>

            <div class="pt-4 flex space-x-3">
                <button type="button" onclick="closeModal('modal-entrega')" class="flex-1 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium text-xs uppercase tracking-wider hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 py-3 rounded-xl bg-brand-gold text-white font-medium text-xs uppercase tracking-wider hover:bg-brand-goldHover">
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
        const m = document.getElementById(id);
        if (m) m.classList.add('hidden');
    }

    function handleFirma(e) {
        e.preventDefault();
        const nombre = document.getElementById('recibe-nombre').value;
        alert(`¡Entrega confirmada y registrada!\n\nReceptor: ${nombre}\nHora: ${new Date().toLocaleTimeString('es-CL')}`);
        closeModal('modal-entrega');
        location.reload();
    }
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
