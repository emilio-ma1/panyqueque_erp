    </main>

    <!-- ====================================================================== -->
    <!-- FOOTER: Corporativo, Limpio con Copyright Dinámico (Plantilla) -->
    <!-- ====================================================================== -->
    <footer class="bg-brand-charcoal text-white pt-16 pb-12 border-t border-gray-800 mt-16 transition-colors">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 pb-12 border-b border-gray-800">
                
                <!-- Columna 1: Marca y descripción -->
                <div class="space-y-4 md:col-span-1">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full border border-brand-gold/50 flex items-center justify-center text-brand-gold">
                            <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m0-18c-2.5 0-5 3.5-5 9s2.5 9 5 9m0-18c2.5 0 5 3.5 5 9s-2.5 9-5 9" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18" />
                            </svg>
                        </div>
                        <span class="font-serif text-xl font-semibold tracking-wide text-white">
                            <?php echo APP_COMPANY; ?>
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 font-light leading-relaxed">
                        Artesanos del pan y la viennoiserie tradicional. Comprometidos con la excelencia gastronómica, el control operativo y la gestión comercial de alta gama.
                    </p>
                    <div class="text-[11px] text-brand-gold uppercase tracking-widest font-mono">
                        Versión ERP: <span class="text-white font-medium">v<?php echo APP_VERSION; ?></span>
                    </div>
                </div>

                <!-- Columna 2: Enlaces a Módulos ERP -->
                <div>
                    <h4 class="text-xs uppercase tracking-widest text-brand-gold font-semibold mb-4">Módulos del Sistema</h4>
                    <ul class="space-y-2.5 text-xs text-gray-400 font-light">
                        <li><a href="index.php" class="hover:text-white transition-colors flex items-center gap-1.5"><span>&rsaquo;</span> Portal Principal</a></li>
                        <li><a href="caja.php" class="hover:text-white transition-colors flex items-center gap-1.5"><span>&rsaquo;</span> Puntos de Venta (POS)</a></li>
                        <li><a href="proveedores.php" class="hover:text-white transition-colors flex items-center gap-1.5"><span>&rsaquo;</span> Contabilidad &amp; Proveedores</a></li>
                        <li><a href="reparto.php" class="hover:text-white transition-colors flex items-center gap-1.5"><span>&rsaquo;</span> Logística &amp; Reparto</a></li>
                        <li><a href="dashboard.php" class="hover:text-white transition-colors flex items-center gap-1.5"><span>&rsaquo;</span> Dashboard Ejecutivo</a></li>
                    </ul>
                </div>

                <!-- Columna 3: Calidad y Filosofía -->
                <div>
                    <h4 class="text-xs uppercase tracking-widest text-brand-gold font-semibold mb-4">Filosofía &amp; Obrador</h4>
                    <ul class="space-y-2.5 text-xs text-gray-400 font-light">
                        <li>Masa Madre de Larga Fermentación</li>
                        <li>Harinas Ecológicas de Molino Tradicional</li>
                        <li>Mantequilla Francesa AOP Certificada</li>
                        <li>Horneado Continuo en Solera Refractaria</li>
                        <li>Control de Calidad y Trazabilidad</li>
                    </ul>
                </div>

                <!-- Columna 4: Casa Matriz & Atención -->
                <div>
                    <h4 class="text-xs uppercase tracking-widest text-brand-gold font-semibold mb-4">Casa Matriz &amp; Obrador</h4>
                    <address class="not-italic space-y-2.5 text-xs text-gray-400 font-light">
                        <p class="flex items-start gap-2">
                            <span class="text-brand-gold font-semibold">Dir:</span>
                            <span>Av. Central #1024, Sala Principal</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <span class="text-brand-gold font-semibold">Tel:</span>
                            <span>+56 9 8765 4321</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <span class="text-brand-gold font-semibold">Mail:</span>
                            <span>contacto@panyqueque.cl</span>
                        </p>
                        <p class="text-[11px] text-gray-500 pt-1">Atención: Lunes a Sábado (06:00 - 20:30)</p>
                    </address>
                </div>

            </div>

            <!-- Fila inferior: Copyright Dinámico -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-4">
                <p>&copy; <?php echo APP_YEAR; ?> <?php echo APP_COMPANY; ?>. Todos los derechos reservados.</p>
                <div class="flex items-center gap-6">
                    <span class="inline-flex items-center gap-1.5 <?php echo (class_exists('DB') && DB::isConnected()) ? 'text-emerald-400' : 'text-brand-gold'; ?>">
                        <span class="w-1.5 h-1.5 rounded-full <?php echo (class_exists('DB') && DB::isConnected()) ? 'bg-emerald-400' : 'bg-brand-gold'; ?>"></span>
                        <span><?php echo (class_exists('DB') && DB::isConnected()) ? 'PostgreSQL 15 Conectado' : 'Sistema Local Activo'; ?></span>
                    </span>
                    <span class="text-brand-gold">Haute Boulangerie ERP</span>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>
