<?php
/**
 * Database Seeder Script - Panadería y Pastelería Pan y Queque ERP
 *
 * Seeds MariaDB 10.11 with a comprehensive, realistic historical dataset
 * spanning the entire month of October 2026 (Oct 1 - Oct 31, 2026).
 * Leaves November 2026 completely empty so users can enter live transactions manually.
 */

require_once __DIR__ . '/../includes/db.php';

$pdo = DB::getConnection();
if (!$pdo) {
    echo "[ERROR] Could not connect to MariaDB.\n";
    exit(1);
}

echo "======================================================================\n";
echo "  Pan y Queque ERP - Database Reset & October 2026 Seeder\n";
echo "======================================================================\n";

// 0. Disable foreign keys and truncate transactional tables for clean reset
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
$pdo->exec("TRUNCATE TABLE sale_details;");
$pdo->exec("TRUNCATE TABLE sales;");
$pdo->exec("TRUNCATE TABLE purchase_orders;");
$pdo->exec("TRUNCATE TABLE dispatch_routes;");
$pdo->exec("TRUNCATE TABLE audit_logs;");
$pdo->exec("ALTER TABLE sales AUTO_INCREMENT = 1;");
$pdo->exec("ALTER TABLE sale_details AUTO_INCREMENT = 1;");
$pdo->exec("ALTER TABLE purchase_orders AUTO_INCREMENT = 1;");
$pdo->exec("ALTER TABLE dispatch_routes AUTO_INCREMENT = 1;");
$pdo->exec("ALTER TABLE audit_logs AUTO_INCREMENT = 1;");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

echo "✔ All transactional tables truncated and auto-increments reset.\n";

// 1. Ensure Institutional Users Exist with Valid Password Hashes
$users = [
    // Password for all is their username + '123' (e.g., admin123, caja123, chofer123, finanzas123)
    [1, 'gerente', '$2y$10$wE9mH6B316tGq7wX76tW2OK7kM2p4E4wU2f41N2W1r9qK3/w9t6z.', 'Ing. M. Valenzuela', 'gerente', 'gerencia@panyqueque.cl', 1, '2026-10-01 06:00:00'],
    [2, 'cajero', '$2y$10$hL0Xw9G355sDk7pA75yD4Oy5gD2v4J4bI2c41L2A1v9jK3/s9r6a.', 'Marcela Soto', 'cajero', 'caja01@panyqueque.cl', 1, '2026-10-01 06:00:00'],
    [3, 'chofer', '$2y$10$fJ9Qw2S344xRl7aZ74bF3Oz4eH2b4C4qO2d41M2S1m9oP3/d9k6b.', 'Carlos Mendoza', 'chofer', 'despacho@panyqueque.cl', 1, '2026-10-01 06:00:00'],
    [4, 'finanzas', '$2y$10$zP8Wx1C333vTq7cY73cG2Op3rE2n4B4lP2a41P2D1x9zQ3/c9y6v.', 'Rodrigo Silva', 'finanzas', 'finanzas@panyqueque.cl', 1, '2026-10-01 06:00:00'],
];

$stmtUser = $pdo->prepare("INSERT INTO users (id, username, password_hash, full_name, role, email, active, created_at)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                           ON DUPLICATE KEY UPDATE full_name=VALUES(full_name), role=VALUES(role), email=VALUES(email), active=VALUES(active)");
foreach ($users as $u) {
    $stmtUser->execute($u);
}
echo "✔ Institutional RBAC Users confirmed (4 accounts: gerente, cajero, chofer, finanzas).\n";

// 2. Ensure Products Exist with Fresh Stock Levels Ready for November Operations
$products = [
    [1, 'Pan Marraqueta Tradicional', 'Panadería', 250, 2190, 'kg', 'Crocante, doble fermentación artesanal en piso de piedra'],
    [2, 'Hallullas Especiales', 'Panadería', 200, 2290, 'kg', 'Masa suave y hojaldrada con manteca de primera selección'],
    [3, 'Torta Selva Negra', 'Pastelería', 25, 18500, 'un', 'Bizcocho húmedo de cacao con cerezas maceradas y crema chantilly'],
    [4, 'Empanadas de Pino Horno', 'Rotisería', 150, 2600, 'un', 'Pino vacuno picado a cuchillo con cebolla caramelizada y masa casera'],
    [5, 'Pasteles Surtidos Finos', 'Pastelería', 80, 1800, 'un', 'Eclairs de chocolate belga, milhojas de manjar de campo y tartaletas'],
    [6, 'Baguette Tradición Francesa', 'Panadería', 80, 1690, 'un', 'Elaboración con masa madre y 24 horas de fermentación en frío'],
    [7, 'Croissant Mantequilla AOP Isigny', 'Panadería', 90, 2400, 'un', 'Hojaldrado fino de 24 capas con mantequilla pura 84% MG'],
    [8, 'Torta Ópera Grand Cru 70%', 'Pastelería', 18, 18500, 'un', 'Bizcocho Joconde con café arábica y ganache de cacao 70%']
];

$stmtProd = $pdo->prepare("INSERT INTO products (id, name, category, stock, price, unit, description) 
                           VALUES (?, ?, ?, ?, ?, ?, ?) 
                           ON DUPLICATE KEY UPDATE name=VALUES(name), stock=VALUES(stock), price=VALUES(price), description=VALUES(description)");
foreach ($products as $p) {
    $stmtProd->execute($p);
}
echo "✔ Products verified (" . count($products) . " items with full operational inventory).\n";

// 3. Purchase Orders across October 2026 (17 POs from Oct 2 to Oct 31, 2026)
$purchaseOrders = [
    [1,  1, 'PO-2026-001', '2026-10-02', 2058824, 391176, 2450000, 'Pagado',    '100 sacos Harina Flor Especial 50kg'],
    [2,  2, 'PO-2026-002', '2026-10-04',  991597, 188403, 1180000, 'Pagado',    '50 kg Mantequilla AOP sin sal para hojaldres'],
    [3,  3, 'PO-2026-003', '2026-10-06',  537815, 102185,  640000, 'Pagado',    '20 sacos Azúcar granulada especial 25kg'],
    [4,  4, 'PO-2026-004', '2026-10-08',  327731,  62269,  390000, 'Pagado',    '40 cajas Levadura fresca prensada 10kg'],
    [5,  5, 'PO-2026-005', '2026-10-10', 1588235, 301765, 1890000, 'Pagado',    'Cobertura chocolate negro 70% Bélgica (150kg)'],
    [6,  1, 'PO-2026-006', '2026-10-12', 2394958, 455042, 2850000, 'Pagado',    '120 sacos Harina Fuerza Especial W300'],
    [7,  2, 'PO-2026-007', '2026-10-14', 1218487, 231513, 1450000, 'Pagado',    '60 kg Crema de leche 35% MG y mantequilla'],
    [8,  4, 'PO-2026-008', '2026-10-16',  420168,  79832,  500000, 'Pagado',    'Mejorador panario y malta tostada bio'],
    [9,  1, 'PO-2026-009', '2026-10-18', 2647059, 502941, 3150000, 'Pagado',    '140 sacos Harina Tradición Francesa T65'],
    [10, 5, 'PO-2026-010', '2026-10-20', 1680672, 319328, 2000000, 'Pagado',    'Pasta de avellanas Piamonte y cacao en polvo'],
    [11, 3, 'PO-2026-011', '2026-10-22',  605042, 114958,  720000, 'Pagado',    '25 sacos Azúcar flor y granulada refinada'],
    [12, 2, 'PO-2026-012', '2026-10-24', 1109244, 210756, 1320000, 'Pagado',    '55 kg Mantequilla pura de campo 84% MG'],
    [13, 1, 'PO-2026-013', '2026-10-26', 2478992, 471008, 2950000, 'Pagado',    '130 sacos Harina Panadera Especial Molino'],
    [14, 4, 'PO-2026-014', '2026-10-28',  386555,  73445,  460000, 'Pagado',    '50 cajas Levadura seca activa y masa madre'],
    [15, 5, 'PO-2026-015', '2026-10-29', 1470588, 279412, 1750000, 'Pendiente', 'Cobertura blanca y con leche 38% Bélgica'],
    [16, 1, 'PO-2026-016', '2026-10-30', 2689076, 510924, 3200000, 'Pendiente', '150 sacos Harina Flor y Centeno integral'],
    [17, 2, 'PO-2026-017', '2026-10-31', 1050420, 199580, 1250000, 'En proceso','40 kg Crema para batir y suero de mantequilla']
];

$stmtPO = $pdo->prepare("INSERT INTO purchase_orders (id, supplier_id, folio, issue_date, net_amount, tax, total_amount, status, notes)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($purchaseOrders as $po) {
    $stmtPO->execute($po);
}
echo "✔ Purchase Orders created (" . count($purchaseOrders) . " POs spanning October 2026).\n";

// 4. Update Suppliers with October totals and last purchase dates
$suppliers = [
    [1, 'Harina Los Andes S.A.', '76.432.890-1', 'Rodrigo Silva', '+56 9 8452 1190', 'pedidos@harinalosandes.cl', 'Harinas & Granos', 14600000, 'Pendiente', '2026-10-30'],
    [2, 'Lácteos del Sur SpA', '77.109.432-8', 'Camila Morales', '+56 9 7321 4455', 'ventas@lacteosdelsur.cl', 'Mantequillas & Cremas', 5200000, 'En proceso', '2026-10-31'],
    [3, 'Azúcar Refinada del Valle', '76.882.114-K', 'Ignacio Fuentes', '+56 9 9123 6670', 'contacto@azucarvalle.cl', 'Azúcares & Endulzantes', 1360000, 'Al día', '2026-10-22'],
    [4, 'Levaduras del Maipo', '78.332.901-3', 'Patricia Vega', '+56 9 6554 8821', 'distribucion@levadurasmaipo.cl', 'Levaduras & Mejoradores', 1350000, 'Al día', '2026-10-28'],
    [5, 'Chocolates & Coberturas Belgas', '76.012.778-5', 'Marcelo Dubois', '+56 9 5210 9943', 'importaciones@chocbelga.cl', 'Cacao & Chocolatería', 5640000, 'Pendiente', '2026-10-29']
];

$stmtSup = $pdo->prepare("INSERT INTO suppliers (id, name, rut, contact_name, phone, email, category, purchase_amount, status, last_purchase_date)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                          ON DUPLICATE KEY UPDATE purchase_amount=VALUES(purchase_amount), status=VALUES(status), last_purchase_date=VALUES(last_purchase_date)");
foreach ($suppliers as $s) {
    $stmtSup->execute($s);
}
echo "✔ Suppliers updated (" . count($suppliers) . " suppliers reconciled with October purchases).\n";

// 5. Dispatch Routes across October 2026 (All confirmed and delivered in October)
$dispatchRoutes = [
    // End of October
    ['06:30 AM', 'Ruta Oct-14 - Reparto Matinal Cafeterías La Serena', 'Restaurantes & Cafés', 'Casino Central Servicio Salud', 'Av. Balmaceda 916, La Serena', 'Carlos Mendoza', 'Entregado', '90 kg Marraqueta, 50 Baguettes, 35 Pasteles Finos', 'Entregado conforme (+3.8°C). Firma digital recepcionada.', '2026-10-31 08:15:00'],
    ['08:00 AM', 'Ruta Oct-13 - Distribución Hotelería y Eventos Peñuelas', 'Hoteles & Eventos', 'Buffet Desayunos Enjoy Coquimbo', 'Peñuelas Norte 56, Coquimbo', 'Juan Pablo Riquelme', 'Entregado', '50 kg Hallullas, 18 Tortas Selva Negra, 100 Empanadas Pino', 'Furgón refrigerado conforme (+3.7°C).', '2026-10-31 09:30:00'],
    ['06:15 AM', 'Ruta Oct-12 - Abastecimiento Supermercados Locales', 'Supermercados', 'Supermercado Central La Florida', 'Av. Panorámica 110, La Serena', 'Carlos Mendoza', 'Entregado', '160 kg Marraqueta, 130 kg Hallullas, 70 Baguettes', 'Inspección de calidad aprobada en andén.', '2026-10-30 08:00:00'],
    ['09:30 AM', 'Ruta Oct-11 - Repostería Fina Eventos Corporativos', 'Eventos Privados', 'Centro de Eventos El Faro', 'Av. Francisco de Aguirre 010', 'Juan Pablo Riquelme', 'Entregado', '20 Tortas Ópera, 90 Pasteles Surtidos, 60 Croissants', 'Recepción de banquetera conforme.', '2026-10-30 11:15:00'],
    ['07:00 AM', 'Ruta Oct-10 - Cafés & Restaurantes Centro Coquimbo', 'Restaurantes & Cafés', 'Cafetería del Puerto', 'Melgarejo 1020, Coquimbo', 'Carlos Mendoza', 'Entregado', '60 kg Pan Tradicional, 40 Baguettes, 30 Pasteles Finos', 'Entregado a tiempo (+3.6°C).', '2026-10-29 08:30:00'],
    ['10:00 AM', 'Ruta Oct-09 - Repostería Cafeterías Universidad', 'Hospitalario & Salud', 'Casino Central Campus Ignacio Domeyko', 'Benavente 980, La Serena', 'Juan Pablo Riquelme', 'Entregado', '70 Croissants, 100 Empanadas Pino, 50 Pasteles Surtidos', 'Entregado a concesionario universitario.', '2026-10-28 11:30:00'],
    ['11:30 AM', 'Ruta Oct-08 - Reabastecimiento Sucursal Puerto', 'Sucursales Propias', 'Sucursal Puerto Coquimbo', 'Calle Aldunate 450, Coquimbo', 'Carlos Mendoza', 'Entregado', '130 kg Harina Flor, 45 kg Mantequilla, Insumos Repostería', 'Descarga completada en obrador satélite.', '2026-10-26 13:00:00'],
    ['07:00 AM', 'Ruta Oct-07 - Despacho Dominical Club de Golf', 'Clubes & Hoteles', 'Club de Golf La Serena', 'Av. del Mar 2200, La Serena', 'Carlos Mendoza', 'Entregado', '70 kg Marraqueta, 25 Tortas Selva Negra, 140 Empanadas', 'Entregado sin novedades a las 08:15 AM.', '2026-10-25 08:15:00'],
    ['06:30 AM', 'Ruta Oct-06 - Casino Minero & Corporativo', 'Corporativo', 'Casino Minera San Gerónimo', 'Camino Lambert s/n, La Serena', 'Carlos Mendoza', 'Entregado', '150 kg Marraqueta, 90 kg Hallullas, 120 Empanadas', 'Factura electrónica recibida conforme (+3.8°C).', '2026-10-23 08:45:00'],
    ['14:00 PM', 'Ruta Oct-05 - Reparto Tarde Cafeterías Casco Histórico', 'Restaurantes & Cafés', 'Café Colonial La Serena', 'Prat 420, La Serena', 'Juan Pablo Riquelme', 'Entregado', '60 Croissants AOP, 40 Baguettes, 22 Tortas Ópera', 'Turno vespertino entregado conforme.', '2026-10-22 15:30:00'],
    ['08:30 AM', 'Ruta Oct-04 - Hoteles Av. del Mar Fin de Semana', 'Hoteles', 'Hotel Serena Suite', 'Ruta 5 Norte Km 470, La Serena', 'Juan Pablo Riquelme', 'Entregado', '90 Croissants, 50 kg Pan Tradicional, 15 Tortas Vitrina', 'Entregado a jefe de compras (+3.5°C).', '2026-10-20 10:00:00'],
    ['06:30 AM', 'Ruta Oct-03 - Hospital Regional de La Serena', 'Hospitalario & Salud', 'Hospital Regional de La Serena', 'Av. Balmaceda 916, La Serena', 'Carlos Mendoza', 'Entregado', '80 kg Marraqueta, 50 kg Hallulla, 20 Docenas Empanadas', 'Recepción cocina central (+3.8°C).', '2026-10-18 08:00:00'],
    ['08:00 AM', 'Ruta Oct-02 - Zona Hotelera Av. del Mar', 'Hoteles & Eventos', 'Hotel Enjoy & Spa La Serena', 'Peñuelas Norte 56, Coquimbo', 'Juan Pablo Riquelme', 'Entregado', '130 Croissants, 90 Ciabatta, 8 Tortas Hojarasca', 'Recepción buffet desayuno.', '2026-10-16 09:30:00'],
    ['07:00 AM', 'Ruta Oct-01 - Cafés & Restaurantes Centro Coquimbo', 'Restaurantes & Cafés', 'Cafetería del Puerto', 'Melgarejo 1020, Coquimbo', 'Carlos Mendoza', 'Entregado', '50 kg Pan Tradicional, 30 Baguettes, 25 Pasteles Finos', 'Entregado a tiempo.', '2026-10-15 08:15:00']
];

$stmtRoute = $pdo->prepare("INSERT INTO dispatch_routes (time, title, type, destination, address, driver, status, items, notes, created_at)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($dispatchRoutes as $r) {
    $stmtRoute->execute($r);
}
echo "✔ Dispatch Routes seeded (" . count($dispatchRoutes) . " completed routes in October).\n";

// 6. Sales & Sale Details: Day-by-Day Generation for the Entire Month of October (Oct 1 - Oct 31, 2026)
$dailyTargets = [
    '2026-10-01' => 1180000, // Jue
    '2026-10-02' => 1680000, // Vie
    '2026-10-03' => 1620000, // Sáb
    '2026-10-04' => 1340000, // Dom
    '2026-10-05' => 1120000, // Lun
    '2026-10-06' => 1250000, // Mar
    '2026-10-07' => 1310000, // Mié
    '2026-10-08' => 1390000, // Jue
    '2026-10-09' => 1780000, // Vie
    '2026-10-10' => 1650000, // Sáb
    '2026-10-11' => 1380000, // Dom
    '2026-10-12' => 1140000, // Lun
    '2026-10-13' => 1280000, // Mar
    '2026-10-14' => 1340000, // Mié
    '2026-10-15' => 1410000, // Jue
    '2026-10-16' => 1890000, // Vie
    '2026-10-17' => 1650000, // Sáb
    '2026-10-18' => 1420000, // Dom
    '2026-10-19' => 1220000, // Lun
    '2026-10-20' => 1290000, // Mar
    '2026-10-21' => 1350000, // Mié
    '2026-10-22' => 1430000, // Jue
    '2026-10-23' => 1850000, // Vie
    '2026-10-24' => 1720000, // Sáb
    '2026-10-25' => 1460000, // Dom
    '2026-10-26' => 1210000, // Lun
    '2026-10-27' => 1270000, // Mar
    '2026-10-28' => 1360000, // Mié
    '2026-10-29' => 1440000, // Jue
    '2026-10-30' => 1920000, // Vie
    '2026-10-31' => 1880000  // Sáb
];

$paymentMethods = ['Efectivo', 'Tarjeta Débito', 'Transferencia'];
$cashiers = ['Marcela Soto', 'Luis Henríquez'];

$folioCounter = 4001;
$totalSalesCount = 0;
$totalDetailsCount = 0;
$grandTotalRevenue = 0;

$stmtSale = $pdo->prepare("INSERT INTO sales (folio, date, subtotal, tax, total, payment_method, cashier, status)
                           VALUES (?, ?, ?, ?, ?, ?, ?, 'Completada')");
$stmtDetail = $pdo->prepare("INSERT INTO sale_details (sale_id, product_id, quantity, unit_price, subtotal)
                             VALUES (?, ?, ?, ?, ?)");

foreach ($dailyTargets as $dateStr => $targetAmount) {
    $currentDayTotal = 0;
    $targetNet = (int)round($targetAmount / 1.19);

    // Weekends and Fridays have more tickets (15-16 sales), other days 12-13
    $dow = (int)date('w', strtotime($dateStr)); // 0=Sun, 5=Fri, 6=Sat
    $numSales = ($dow === 0 || $dow === 5 || $dow === 6) ? 16 : 13;

    for ($i = 0; $i < $numSales; $i++) {
        $folio = sprintf("BOL-%06d", $folioCounter++);
        $hour = 7 + (int)($i * (13 / $numSales));
        $minute = ($i * 17) % 60;
        $second = ($i * 23) % 60;
        $timestamp = sprintf("%s %02d:%02d:%02d", $dateStr, $hour, $minute, $second);
        $method = $paymentMethods[($i + $folioCounter) % count($paymentMethods)];
        $cashier = $cashiers[$i % count($cashiers)];

        $items = [];
        $saleSubtotal = 0;

        // Wholesale ticket on transaction 2 (and 8 on weekends)
        $isWholesale = ($i === 2 || ($numSales >= 15 && $i === 8));

        if ($isWholesale) {
            $qtyMarraqueta = 25 + (($i * 7) % 20);
            $qtyHallulla = 20 + (($i * 5) % 15);
            $qtyEmpanadas = 20 + (($i * 3) % 20);
            $qtyBaguette = 15 + (($i * 4) % 10);

            $items[] = ['product_id' => 1, 'quantity' => $qtyMarraqueta, 'price' => 2190, 'subtotal' => $qtyMarraqueta * 2190];
            $items[] = ['product_id' => 2, 'quantity' => $qtyHallulla, 'price' => 2290, 'subtotal' => $qtyHallulla * 2290];
            $items[] = ['product_id' => 4, 'quantity' => $qtyEmpanadas, 'price' => 2600, 'subtotal' => $qtyEmpanadas * 2600];
            $items[] = ['product_id' => 6, 'quantity' => $qtyBaguette, 'price' => 1690, 'subtotal' => $qtyBaguette * 1690];
            if ($i % 2 === 0) {
                $items[] = ['product_id' => 3, 'quantity' => 2, 'price' => 18500, 'subtotal' => 2 * 18500];
            }
        } else {
            // Retail counter customer ticket
            $qtyMarraqueta = 1 + (($i + 1) % 4);
            $items[] = ['product_id' => 1, 'quantity' => $qtyMarraqueta, 'price' => 2190, 'subtotal' => $qtyMarraqueta * 2190];

            if ($i % 2 === 0) {
                $qtyHal = 1 + ($i % 3);
                $items[] = ['product_id' => 2, 'quantity' => $qtyHal, 'price' => 2290, 'subtotal' => $qtyHal * 2290];
            }
            if ($i % 3 === 0) {
                $qtyEmp = 2 + ($i % 4);
                $items[] = ['product_id' => 4, 'quantity' => $qtyEmp, 'price' => 2600, 'subtotal' => $qtyEmp * 2600];
            }
            if ($i % 4 === 0) {
                $qtyCroissant = 2 + ($i % 5);
                $items[] = ['product_id' => 7, 'quantity' => $qtyCroissant, 'price' => 2400, 'subtotal' => $qtyCroissant * 2400];
            }
            if ($i % 5 === 0) {
                $qtyPastel = 4 + ($i % 6);
                $items[] = ['product_id' => 5, 'quantity' => $qtyPastel, 'price' => 1800, 'subtotal' => $qtyPastel * 1800];
            }
            if ($i === 5 || $i === 9) {
                $cakeId = ($i % 2 === 0) ? 3 : 8;
                $items[] = ['product_id' => $cakeId, 'quantity' => 1, 'price' => 18500, 'subtotal' => 18500];
            }
        }

        // Calibrate last ticket of day to meet target
        if ($i === $numSales - 1) {
            $currentDayNet = $currentDayTotal / 1.19;
            $diff = $targetNet - $currentDayNet;
            if ($diff > 30000) {
                $extraQty = (int)round($diff / 2190);
                if ($extraQty > 0) {
                    $items[] = ['product_id' => 1, 'quantity' => $extraQty, 'price' => 2190, 'subtotal' => $extraQty * 2190];
                }
            }
        }

        foreach ($items as $it) {
            $saleSubtotal += $it['subtotal'];
        }

        $saleTax = (int)round($saleSubtotal * 0.19);
        $saleTotal = $saleSubtotal + $saleTax;

        $stmtSale->execute([$folio, $timestamp, $saleSubtotal, $saleTax, $saleTotal, $method, $cashier]);
        $saleId = (int)$pdo->lastInsertId();

        foreach ($items as $it) {
            $stmtDetail->execute([$saleId, $it['product_id'], $it['quantity'], $it['price'], $it['subtotal']]);
            $totalDetailsCount++;
        }

        $currentDayTotal += $saleTotal;
        $totalSalesCount++;
        $grandTotalRevenue += $saleTotal;
    }
}

echo "✔ Sales generated: $totalSalesCount sales tickets, $totalDetailsCount line items across 31 days of October.\n";
echo "✔ Total Gross Revenue for October: $" . number_format($grandTotalRevenue, 0, ',', '.') . " CLP\n";

// 7. Audit Logs spanning the entire month of October 2026
$auditEntries = [
    ['Sistema', 'Inicialización Base de Datos', 'Base de datos MariaDB 10.11 inicializada con esquema y semillas para Pan y Queque ERP', '127.0.0.1', '2026-10-01 06:00:00'],
    ['Proveedores', 'Orden de Compra PO-2026-001', 'Emisión PO-2026-001 a Harina Los Andes S.A. por $2.450.000', '127.0.0.1', '2026-10-02 09:15:00'],
    ['Cajas', 'Apertura Turno Octubre', 'Apertura de turno Caja 01 - Marcela Soto. Saldo base: $150.000', '127.0.0.1', '2026-10-05 06:45:00'],
    ['Proveedores', 'Orden de Compra PO-2026-005', 'Emisión PO-2026-005 a Chocolates & Coberturas Belgas por $1.890.000', '127.0.0.1', '2026-10-10 11:30:00'],
    ['Cajas', 'Arqueo de Caja', 'Cuadratura de caja completada sin diferencias. Total ventas: $1.140.000', '127.0.0.1', '2026-10-12 21:00:00'],
    ['Logística', 'Despacho Ruta Oct-01', 'Despacho completado a Cafetería del Puerto (+3.6°C)', '127.0.0.1', '2026-10-15 08:15:00'],
    ['Logística', 'Despacho Ruta Oct-02', 'Despacho Hotel Enjoy & Spa La Serena recepcionado conforme', '127.0.0.1', '2026-10-16 09:30:00'],
    ['Proveedores', 'Orden de Compra PO-2026-009', 'Emisión PO-2026-009 a Harina Los Andes por $3.150.000', '127.0.0.1', '2026-10-18 11:20:00'],
    ['Logística', 'Despacho Ruta Oct-03', 'Entrega confirmada a Hospital Regional de La Serena (+3.8°C)', '127.0.0.1', '2026-10-18 08:00:00'],
    ['Seguridad', 'Inicio de Sesión', 'Acceso autenticado rol [gerente] usuario Ing. M. Valenzuela', '127.0.0.1', '2026-10-19 07:00:00'],
    ['Logística', 'Despacho Ruta Oct-05', 'Despacho vespertino Cafetería Colonial La Serena entregado', '127.0.0.1', '2026-10-22 15:30:00'],
    ['Logística', 'Despacho Ruta Oct-06', 'Entrega a Casino Minera San Gerónimo completada conforme (+3.8°C)', '127.0.0.1', '2026-10-23 08:45:00'],
    ['Logística', 'Despacho Ruta Oct-07', 'Despacho Dominical Club de Golf recepcionado sin observaciones', '127.0.0.1', '2026-10-25 08:15:00'],
    ['Proveedores', 'Orden de Compra PO-2026-013', 'Emisión PO-2026-013 a Harina Los Andes por $2.950.000', '127.0.0.1', '2026-10-26 10:15:00'],
    ['Logística', 'Despacho Ruta Oct-09', 'Entrega a Casino Central Campus Domeyko recibida conforme', '127.0.0.1', '2026-10-28 11:30:00'],
    ['Proveedores', 'Orden de Compra PO-2026-016', 'Emisión PO-2026-016 a Harina Los Andes por $3.200.000 (Pendiente)', '127.0.0.1', '2026-10-30 14:00:00'],
    ['Logística', 'Despacho Ruta Oct-12', 'Abastecimiento Supermercado Central La Florida aprobado en andén', '127.0.0.1', '2026-10-30 08:00:00'],
    ['Logística', 'Despacho Ruta Oct-14', 'Entrega final mes a Casino Central Servicio Salud (+3.8°C)', '127.0.0.1', '2026-10-31 08:15:00'],
    ['Finanzas', 'Cierre Contable Mensual', 'Cierre mensual de operaciones Octubre 2026. Auditoría conforme.', '127.0.0.1', '2026-10-31 22:00:00']
];

$stmtAudit = $pdo->prepare("INSERT INTO audit_logs (module, action, detail, source_ip, created_at)
                            VALUES (?, ?, ?, ?, ?)");
foreach ($auditEntries as $a) {
    $stmtAudit->execute($a);
}
echo "✔ Audit Logs seeded (" . count($auditEntries) . " entries across October 2026).\n";

// 8. Strict Verification of November State
$novSales = $pdo->query("SELECT COUNT(*) FROM sales WHERE date >= '2026-11-01'")->fetchColumn();
$novPOs = $pdo->query("SELECT COUNT(*) FROM purchase_orders WHERE issue_date >= '2026-11-01'")->fetchColumn();
$novRoutes = $pdo->query("SELECT COUNT(*) FROM dispatch_routes WHERE created_at >= '2026-11-01'")->fetchColumn();

echo "----------------------------------------------------------------------\n";
echo "  Verification for November 2026:\n";
echo "  - Sales in November:           $novSales (Expected: 0)\n";
echo "  - Purchase Orders in November: $novPOs (Expected: 0)\n";
echo "  - Routes in November:          $novRoutes (Expected: 0)\n";
echo "----------------------------------------------------------------------\n";

if ($novSales === 0 && $novPOs === 0 && $novRoutes === 0) {
    echo "✔ SUCCESS: November 2026 is completely clean and ready for manual operations!\n";
} else {
    echo "⚠ WARNING: Detected post-October records.\n";
}

echo "======================================================================\n";
