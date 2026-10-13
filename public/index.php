<?php
/**
 * Portal Principal / Landing del ERP
 * Panadería y Pastelería Pan y Queque
 * Basado en la plantilla elegante de Haute Boulangerie (Plantilla/code.html)
 */
$currentPage = 'inicio';
$pageTitle = 'Portal Principal ERP';
require_once __DIR__ . '/../includes/header.php';
?>

<!-- ====================================================================== -->
<!-- HERO SECTION: Elegancia, Titular Magnético y Espacio Negativo (Plantilla) -->
<!-- ====================================================================== -->
<section id="inicio" class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-28 bg-gradient-to-b from-brand-sand/60 via-white to-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            
            <!-- Columna Texto -->
            <div class="lg:col-span-7 space-y-8">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-sand border border-brand-gold/30 text-brand-gold text-[11px] uppercase tracking-widest font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-gold"></span>
                    <span>Obrador de Alta Gama &bull; Sistema ERP Centralizado</span>
                </div>
                
                <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-brand-charcoal font-normal leading-[1.15] tracking-tight">
                    Excelencia en <span class="italic font-light text-brand-gold">Panadería</span> y Gestión Comercial
                </h1>

                <p class="text-base sm:text-lg text-gray-600 font-light max-w-xl leading-relaxed">
                    Plataforma integral de gestión empresarial para <strong>Panadería y Pastelería Pan y Queque</strong>. Centralice de forma ágil la facturación en punto de venta, compras a proveedores, logística de distribución y analítica directiva.
                </p>

                <!-- CTAs Primario y Secundario -->
                <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                    <a href="caja.php" class="inline-flex items-center justify-center px-8 py-3.5 text-xs uppercase tracking-widest font-medium text-white bg-brand-gold hover:bg-brand-goldHover transition-all rounded-lg shadow-sm hover:shadow">
                        Abrir Punto de Venta (POS)
                    </a>
                    <a href="dashboard.php" class="inline-flex items-center justify-center px-7 py-3.5 text-xs uppercase tracking-widest font-medium text-brand-charcoal bg-white border border-gray-200 hover:border-brand-gold hover:text-brand-gold transition-all rounded-lg">
                        Ver Dashboard Ejecutivo
                    </a>
                </div>

                <!-- Métricas de Confianza en el Hero -->
                <div class="pt-8 border-t border-gray-200/70 grid grid-cols-3 gap-6">
                    <div>
                        <p class="font-serif text-2xl font-semibold text-brand-charcoal">48h</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mt-0.5">Fermentación Lenta</p>
                    </div>
                    <div>
                        <p class="font-serif text-2xl font-semibold text-brand-charcoal">$1.42M</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mt-0.5">Ventas del Día</p>
                    </div>
                    <div>
                        <p class="font-serif text-2xl font-semibold text-brand-charcoal">06:00</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mt-0.5">Despacho en Ruta</p>
                    </div>
                </div>
            </div>

            <!-- Columna Visual Hero (Inspirada en Plantilla) -->
            <div class="lg:col-span-5 relative">
                <div class="relative rounded-2xl overflow-hidden shadow-xl border border-gray-100 bg-brand-sand">
                    <!-- Tarjeta artística representativa de la panadería -->
                    <div class="aspect-[4/5] relative flex flex-col justify-between p-8 bg-gradient-to-br from-[#2D241E] via-[#3E3228] to-[#1C1612] text-white">
                        <!-- Patrón sutil de fondo -->
                        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#B89758_1px,transparent_1px)] [background-size:16px_16px]"></div>
                        
                        <div class="relative z-10 flex justify-between items-start">
                            <span class="text-[10px] tracking-[0.3em] uppercase bg-black/40 border border-brand-gold/40 text-brand-gold px-3 py-1 rounded-full">
                                Plataforma Operativa Local
                            </span>
                            <span class="font-serif text-xs text-gray-300">v1.0.0</span>
                        </div>

                        <div class="relative z-10 my-auto text-center py-6">
                            <div class="w-20 h-20 mx-auto mb-5 rounded-full border border-brand-gold/50 flex items-center justify-center bg-brand-gold/10">
                                <svg class="w-10 h-10 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m0-18c-2.5 0-5 3.5-5 9s2.5 9 5 9m0-18c2.5 0 5 3.5 5 9s-2.5 9-5 9" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18" />
                                </svg>
                            </div>
                            <h3 class="font-serif text-3xl font-light tracking-wide text-white">PAN Y QUEQUE</h3>
                            <p class="text-xs text-brand-gold font-mono uppercase tracking-widest mt-2">Masa Madre Viva &bull; Obrador Artesanal</p>
                        </div>

                        <!-- Tarjeta flotante inferior -->
                        <div class="relative z-10 p-4 rounded-xl bg-white/10 backdrop-blur-md border border-white/10 text-xs">
                            <div class="flex items-center justify-between font-medium">
                                <span class="text-gray-200">Estado del Sistema ERP</span>
                                <span class="text-brand-gold font-semibold flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Operativo Local
                                </span>
                            </div>
                            <p class="text-gray-300 text-[11px] mt-1 font-light">4 módulos integrados: Cajas, Proveedores, Reparto y Dirección.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ====================================================================== -->
<!-- MÓDULOS DEL SISTEMA: Grid de Tarjetas Minimalistas (Plantilla) -->
<!-- ====================================================================== -->
<section id="modulos" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <span class="text-[11px] uppercase tracking-[0.25em] text-brand-gold font-semibold">
                Gestión Integral
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl text-brand-charcoal font-normal">
                Módulos del Sistema ERP
            </h2>
            <p class="text-sm text-gray-500 font-light leading-relaxed">
                Herramientas diseñadas para satisfacer las necesidades diarias de atención en mostrador, abastecimiento, logística y dirección estratégica.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Card 1: Puntos de Venta (Cajas) -->
            <article class="group bg-white rounded-xl border border-gray-200/80 hover:border-brand-gold/60 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col overflow-hidden">
                <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-tr from-[#3a2f26] to-[#5a483a] p-6 flex flex-col justify-between text-white">
                    <span class="self-start bg-white/20 backdrop-blur-sm text-white text-[10px] uppercase tracking-wider font-medium px-3 py-1 rounded-full border border-white/20">
                        Sala de Ventas
                    </span>
                    <div class="flex items-end justify-between">
                        <span class="font-serif text-lg tracking-wide">01. Cajas &amp; POS</span>
                        <div class="w-8 h-8 rounded-full border border-white/30 flex items-center justify-center text-brand-gold">
                            <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <span class="text-xs text-brand-gold font-medium uppercase tracking-wider block">
                            Facturación &bull; Boletas &bull; IVA 19%
                        </span>
                        <h3 class="font-serif text-xl text-brand-charcoal font-medium leading-snug">
                            Puntos de Venta y Cajas
                        </h3>
                        <p class="text-xs text-gray-600 font-light leading-relaxed pt-1">
                            Facturación diaria de marraquetas, hallullas, empanadas y tortas con catálogo interactivo, cálculo de totales y cuadratura de caja.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <a href="caja.php" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-brand-charcoal group-hover:text-brand-gold transition-colors">
                            <span>Ingresar al POS</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Card 2: Contabilidad y Proveedores -->
            <article class="group bg-white rounded-xl border border-gray-200/80 hover:border-brand-gold/60 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col overflow-hidden">
                <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-tr from-[#2d2226] to-[#4e3a42] p-6 flex flex-col justify-between text-white">
                    <span class="self-start bg-white/20 backdrop-blur-sm text-white text-[10px] uppercase tracking-wider font-medium px-3 py-1 rounded-full border border-white/20">
                        Adquisiciones
                    </span>
                    <div class="flex items-end justify-between">
                        <span class="font-serif text-lg tracking-wide">02. Proveedores</span>
                        <div class="w-8 h-8 rounded-full border border-white/30 flex items-center justify-center text-brand-gold">
                            <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <span class="text-xs text-brand-gold font-medium uppercase tracking-wider block">
                            Harinas &bull; Levaduras &bull; Mantecas
                        </span>
                        <h3 class="font-serif text-xl text-brand-charcoal font-medium leading-snug">
                            Contabilidad &amp; Compras
                        </h3>
                        <p class="text-xs text-gray-600 font-light leading-relaxed pt-1">
                            Gestión de 5 proveedores de materia prima, emisión de órdenes de compra, control de cuentas por pagar y balances financieros.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <a href="proveedores.php" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-brand-charcoal group-hover:text-brand-gold transition-colors">
                            <span>Ver Finanzas</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Card 3: Logística y Reparto -->
            <article class="group bg-white rounded-xl border border-gray-200/80 hover:border-brand-gold/60 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col overflow-hidden">
                <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-tr from-[#1f2833] to-[#2e3c4d] p-6 flex flex-col justify-between text-white">
                    <span class="self-start bg-white/20 backdrop-blur-sm text-white text-[10px] uppercase tracking-wider font-medium px-3 py-1 rounded-full border border-white/20">
                        Despachos en Ruta
                    </span>
                    <div class="flex items-end justify-between">
                        <span class="font-serif text-lg tracking-wide">03. Distribución</span>
                        <div class="w-8 h-8 rounded-full border border-white/30 flex items-center justify-center text-brand-gold">
                            <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <span class="text-xs text-brand-gold font-medium uppercase tracking-wider block">
                            Supermercados &bull; Cafeterías &bull; Sedes
                        </span>
                        <h3 class="font-serif text-xl text-brand-charcoal font-medium leading-snug">
                            Logística y Reparto
                        </h3>
                        <p class="text-xs text-gray-600 font-light leading-relaxed pt-1">
                            Hojas de despacho para conductores, rutas optimizadas del día y confirmación de recepción con firma de entrega digital.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <a href="reparto.php" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-brand-charcoal group-hover:text-brand-gold transition-colors">
                            <span>Ver Hojas de Ruta</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Card 4: Dashboard Gerencial -->
            <article class="group bg-white rounded-xl border border-brand-gold/60 hover:border-brand-gold shadow-sm hover:shadow-md transition-all duration-300 flex flex-col overflow-hidden">
                <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-tr from-[#1A1A1A] via-[#2A241F] to-[#B89758] p-6 flex flex-col justify-between text-white">
                    <span class="self-start bg-brand-gold/30 backdrop-blur-sm text-brand-gold text-[10px] uppercase tracking-wider font-bold px-3 py-1 rounded-full border border-brand-gold/50">
                        Alta Dirección VIP
                    </span>
                    <div class="flex items-end justify-between">
                        <span class="font-serif text-lg tracking-wide">04. Analítica</span>
                        <div class="w-8 h-8 rounded-full border border-brand-gold flex items-center justify-center text-brand-gold">
                            <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0h.5m-1 0h-9.5m0 0h-.5" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <span class="text-xs text-brand-gold font-medium uppercase tracking-wider block">
                            Margen 38.5% &bull; Ventas $1.42M
                        </span>
                        <h3 class="font-serif text-xl text-brand-charcoal font-medium leading-snug">
                            Dashboard Gerencial
                        </h3>
                        <p class="text-xs text-gray-600 font-light leading-relaxed pt-1">
                            Panel exclusivo con métricas consolidadas, tendencias de productos más vendidos, capacidad de hornos y balances estratégicos.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <a href="dashboard.php" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-brand-gold group-hover:text-brand-goldHover transition-colors">
                            <span>Abrir Dashboard</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </article>

        </div>

    </div>
</section>

<!-- ====================================================================== -->
<!-- SECCIÓN DE CALIDAD & CAPACIDAD OPERATIVA (Plantilla) -->
<!-- ====================================================================== -->
<section id="calidad" class="py-20 bg-brand-sand/60 border-y border-gray-200/60">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <div class="space-y-6">
                <span class="text-[11px] uppercase tracking-[0.25em] text-brand-gold font-semibold">
                    Tradición y Rigor
                </span>
                <h2 class="font-serif text-3xl sm:text-4xl text-brand-charcoal font-normal leading-tight">
                    Obrador Artesanal con Control Tecnológico Integral
                </h2>
                <p class="text-base text-gray-600 font-light leading-relaxed">
                    En <strong class="text-brand-charcoal font-medium"><?php echo APP_COMPANY; ?></strong> combinamos las recetas tradicionales de panificación con fermentación prolongada y la tecnología moderna para gestionar el aprovisionamiento, los despachos matutinos y la recaudación en sala.
                </p>

                <!-- Sellos de Calidad -->
                <div class="grid grid-cols-2 gap-4 pt-4 text-xs font-medium text-brand-charcoal">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-gold shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        <span>Masa madre viva de cultivo propio</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-gold shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        <span>Hornos de solera de alta capacidad</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-gold shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        <span>Trazabilidad completa de materias primas</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-brand-gold shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        <span>Despacho refrigerado diario garantizado</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 lg:p-10 rounded-2xl shadow-sm border border-gray-200/80 space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <span class="text-xs uppercase tracking-widest text-brand-gold font-semibold">Resumen Operativo</span>
                    <h3 class="font-serif text-2xl text-brand-charcoal mt-1">Capacidad Diaria del Obrador</h3>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-lg bg-brand-sand/70 border border-gray-100">
                        <p class="font-serif text-3xl font-bold text-brand-charcoal">48h</p>
                        <p class="text-xs text-gray-600 mt-1 font-light">Fermentación en frío</p>
                    </div>
                    <div class="p-4 rounded-lg bg-brand-sand/70 border border-gray-100">
                        <p class="font-serif text-3xl font-bold text-brand-charcoal">100%</p>
                        <p class="text-xs text-gray-600 mt-1 font-light">Mantequilla pura de pasto</p>
                    </div>
                    <div class="p-4 rounded-lg bg-brand-sand/70 border border-gray-100">
                        <p class="font-serif text-3xl font-bold text-brand-charcoal">1.800 kg</p>
                        <p class="text-xs text-gray-600 mt-1 font-light">Capacidad de horneado diario</p>
                    </div>
                    <div class="p-4 rounded-lg bg-brand-sand/70 border border-gray-100">
                        <p class="font-serif text-3xl font-bold text-brand-charcoal">99.8%</p>
                        <p class="text-xs text-gray-600 mt-1 font-light">Puntualidad en despachos</p>
                    </div>
                </div>

                <a href="caja.php" class="block text-center py-3 px-6 text-xs uppercase tracking-widest font-medium text-white bg-brand-charcoal hover:bg-black transition-colors rounded-lg shadow-sm">
                    Ir al Punto de Venta Principal
                </a>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
