    </main>

    <!-- ====================================================================== -->
    <!-- FOOTER: Corporativo, Sólido y Rectilíneo (Atelier Architectural ERP)    -->
    <!-- ====================================================================== -->
    <footer class="<?php echo ($currentPage === 'dashboard') ? 'bg-zinc-950 border-t border-zinc-800 text-zinc-300' : 'bg-slate-950 border-t border-slate-800 text-slate-300'; ?> pt-12 pb-8 mt-12 transition-none">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-10 border-b <?php echo ($currentPage === 'dashboard') ? 'border-zinc-800' : 'border-slate-800'; ?>">
                
                <!-- Columna 1: Marca y descripción -->
                <div class="space-y-3 md:col-span-1">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 <?php echo ($currentPage === 'dashboard') ? 'bg-amber-600 text-white' : 'bg-amber-700 text-white'; ?> flex items-center justify-center font-bold text-sm rounded-none">
                            PQ
                        </div>
                        <span class="text-sm font-bold tracking-tight text-white uppercase">
                            <?php echo APP_COMPANY; ?>
                        </span>
                    </div>
                    <p class="text-xs <?php echo ($currentPage === 'dashboard') ? 'text-zinc-400' : 'text-slate-400'; ?> leading-relaxed">
                        Sistema integral de planificación, control térmico de obrador, facturación POS en mostrador y logística HORECA.
                    </p>
                    <div class="text-[11px] font-mono <?php echo ($currentPage === 'dashboard') ? 'text-amber-400' : 'text-slate-400'; ?>">
                        SISTEMA ERP: <span class="text-white font-semibold">V4.8-RELEASE</span>
                    </div>
                </div>

                <!-- Columna 2: Enlaces a Módulos ERP -->
                <div>
                    <h4 class="text-xs uppercase font-mono tracking-wider text-white font-bold mb-3">Módulos del Sistema</h4>
                    <ul class="space-y-2 text-xs <?php echo ($currentPage === 'dashboard') ? 'text-zinc-400' : 'text-slate-400'; ?> font-mono">
                        <li><a href="index.php" class="hover:text-white transition-none flex items-center gap-1.5"><span>›</span> 1. Inicio &amp; Catálogo</a></li>
                        <li><a href="pos.php" class="hover:text-white transition-none flex items-center gap-1.5"><span>›</span> 2. Punto de Venta (POS)</a></li>
                        <li><a href="suppliers.php" class="hover:text-white transition-none flex items-center gap-1.5"><span>›</span> 3. Proveedores &amp; Finanzas</a></li>
                        <li><a href="dispatch.php" class="hover:text-white transition-none flex items-center gap-1.5"><span>›</span> 4. Logística &amp; Rutas</a></li>
                        <li><a href="dashboard.php" class="hover:text-amber-400 text-amber-400 transition-none flex items-center gap-1.5"><span>›</span> 5. Dashboard Ejecutivo [VIP]</a></li>
                    </ul>
                </div>

                <!-- Columna 3: Calidad y Filosofía -->
                <div>
                    <h4 class="text-xs uppercase font-mono tracking-wider text-white font-bold mb-3">Estándares del Obrador</h4>
                    <ul class="space-y-2 text-xs <?php echo ($currentPage === 'dashboard') ? 'text-zinc-400' : 'text-slate-400'; ?>">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-600 rounded-none inline-block"></span> Masa Madre Viva (Cultivo Propio 48h)</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-600 rounded-none inline-block"></span> Harina T65 Molida a la Piedra</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-600 rounded-none inline-block"></span> Mantequilla de Pasto AOP Isigny</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-600 rounded-none inline-block"></span> Hornos de Solera Refractaria a 245°C</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-amber-600 rounded-none inline-block"></span> Trazabilidad Térmica HORECA (+3.8°C)</li>
                    </ul>
                </div>

                <!-- Columna 4: Casa Matriz & Atención -->
                <div>
                    <h4 class="text-xs uppercase font-mono tracking-wider text-white font-bold mb-3">Planta Central &amp; Turnos</h4>
                    <address class="not-italic space-y-2 text-xs <?php echo ($currentPage === 'dashboard') ? 'text-zinc-400' : 'text-slate-400'; ?>">
                        <p class="font-mono">Planta Central #01 &bull; Av. Central #1024</p>
                        <p class="font-mono">Turno Matutino: 04:00 - 13:00</p>
                        <p class="font-mono">Turno Tarde: 13:00 - 21:00</p>
                        <p class="text-[11px] font-mono pt-1 text-slate-500">Mesa de Ayuda ERP: anexo 9402</p>
                    </address>
                </div>

            </div>

            <!-- Fila inferior: Copyright Dinámico y Telemetría -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs font-mono <?php echo ($currentPage === 'dashboard') ? 'text-zinc-500' : 'text-slate-500'; ?> gap-3">
                <p>&copy; <?php echo APP_YEAR; ?> <?php echo APP_COMPANY; ?>. Todos los derechos reservados.</p>
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 <?php echo (class_exists('DB') && DB::isConnected()) ? 'bg-emerald-950 text-emerald-400 border border-emerald-800' : 'bg-amber-950 text-amber-400 border border-amber-800'; ?> rounded-none">
                        <span class="w-1.5 h-1.5 rounded-none <?php echo (class_exists('DB') && DB::isConnected()) ? 'bg-emerald-400' : 'bg-amber-400'; ?>"></span>
                        <span><?php echo (class_exists('DB') && DB::isConnected()) ? 'POSTGRESQL 15 ONLINE' : 'MODO LOCAL ACTIVO'; ?></span>
                    </span>
                    <span class="text-slate-400 uppercase">Atelier Architectural ERP</span>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>
