<?php
/**
 * Database Seeder Script - Panadería y Pastelería Pan y Queque
 * Seeds MariaDB with a comprehensive, realistic operational dataset
 * spanning the current week (Oct 12 - Oct 19, 2026) and the full month of October 2026.
 */

require_once __DIR__ . '/../includes/db.php';

$pdo = DB::getConnection();
if (!$pdo) {
    echo "[ERROR] Could not connect to MariaDB.\n";
    exit(1);
}

echo "=== Seeding MariaDB with Weekly & Monthly Operational Data ===\n";

// Disable foreign keys temporarily for clean reset
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
$pdo->exec("TRUNCATE TABLE sale_details;");
$pdo->exec("TRUNCATE TABLE sales;");
$pdo->exec("TRUNCATE TABLE purchase_orders;");
$pdo->exec("TRUNCATE TABLE dispatch_routes;");
$pdo->exec("TRUNCATE TABLE audit_logs;");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

echo "✔ Tables truncated successfully.\n";

// 1. Ensure Products Exist with realistic inventory
$products = [
    [1, 'Pan Marraqueta Tradicional', 'Panadería', 180, 2190, 'kg', 'Crocante, doble fermentación artesanal en piso de piedra'],
    [2, 'Hallullas Especiales', 'Panadería', 140, 2290, 'kg', 'Masa suave y hojaldrada con manteca de primera selección'],
    [3, 'Torta Selva Negra', 'Pastelería', 14, 18500, 'un', 'Bizcocho húmedo de cacao con cerezas maceradas y crema chantilly'],
    [4, 'Empanadas de Pino Horno', 'Rotisería', 85, 2600, 'un', 'Pino vacuno picado a cuchillo con cebolla caramelizada y masa casera'],
    [5, 'Pasteles Surtidos Finos', 'Pastelería', 45, 1800, 'un', 'Eclairs de chocolate belga, milhojas de manjar de campo y tartaletas'],
    [6, 'Baguette Tradición Francesa', 'Panadería', 60, 1690, 'un', 'Elaboración con masa madre y 24 horas de fermentación en frío'],
    [7, 'Croissant Mantequilla AOP Isigny', 'Panadería', 70, 2400, 'un', 'Hojaldrado fino de 24 capas con mantequilla pura 84% MG'],
    [8, 'Torta Ópera Grand Cru 70%', 'Pastelería', 10, 18500, 'un', 'Bizcocho Joconde con café arábica y ganache de cacao 70%']
];

$stmtProd = $pdo->prepare("INSERT INTO products (id, name, category, stock, price, unit, description) 
                           VALUES (?, ?, ?, ?, ?, ?, ?) 
                           ON DUPLICATE KEY UPDATE name=VALUES(name), stock=VALUES(stock), price=VALUES(price)");
foreach ($products as $p) {
    $stmtProd->execute($p);
}
echo "✔ Products verified (" . count($products) . " items).\n";

// 2. Suppliers
$suppliers = [
    [1, 'Harina Los Andes S.A.', '76.432.890-1', 'Rodrigo Silva', '+56 9 8452 1190', 'pedidos@harinalosandes.cl', 'Harinas & Granos', 8450000, 'Al día', '2026-10-16'],
    [2, 'Lácteos del Sur SpA', '77.109.432-8', 'Camila Morales', '+56 9 7321 4455', 'ventas@lacteosdelsur.cl', 'Mantequillas & Cremas', 4180000, 'Pendiente', '2026-10-15'],
    [3, 'Azúcar Refinada del Valle', '76.882.114-K', 'Ignacio Fuentes', '+56 9 9123 6670', 'contacto@azucarvalle.cl', 'Azúcares & Endulzantes', 1840000, 'Al día', '2026-10-12'],
    [4, 'Levaduras del Maipo', '78.332.901-3', 'Patricia Vega', '+56 9 6554 8821', 'distribucion@levadurasmaipo.cl', 'Levaduras & Mejoradores', 1390000, 'Al día', '2026-10-14'],
    [5, 'Chocolates & Coberturas Belgas', '76.012.778-5', 'Marcelo Dubois', '+56 9 5210 9943', 'importaciones@chocbelga.cl', 'Cacao & Chocolatería', 3890000, 'En proceso', '2026-10-17']
];

$stmtSup = $pdo->prepare("INSERT INTO suppliers (id, name, rut, contact_name, phone, email, category, purchase_amount, status, last_purchase_date)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                          ON DUPLICATE KEY UPDATE purchase_amount=VALUES(purchase_amount), status=VALUES(status), last_purchase_date=VALUES(last_purchase_date)");
foreach ($suppliers as $s) {
    $stmtSup->execute($s);
}
echo "✔ Suppliers updated (" . count($suppliers) . " suppliers).\n";

// 3. Purchase Orders across the month
$purchaseOrders = [
    [1, 1, 'PO-2026-001', '2026-10-02', 2058824, 391176, 2450000, 'Pagado', '100 sacos Harina Flor Especial 50kg'],
    [2, 2, 'PO-2026-002', '2026-10-05', 991597, 188403, 1180000, 'Pagado', '50 kg Mantequilla AOP sin sal para hojaldres'],
    [3, 3, 'PO-2026-003', '2026-10-07', 537815, 102185, 640000, 'Pagado', '20 sacos Azúcar granulada especial 25kg'],
    [4, 4, 'PO-2026-004', '2026-10-09', 327731, 62269, 390000, 'Pagado', '40 cajas Levadura fresca prensada 10kg'],
    [5, 5, 'PO-2026-005', '2026-10-11', 1588235, 301765, 1890000, 'Pagado', 'Cobertura de chocolate negro 70% origen Bélgica (150kg)'],
    [6, 1, 'PO-2026-006', '2026-10-13', 2394958, 455042, 2850000, 'Pagado', '120 sacos Harina Fuerza Especial W300'],
    [7, 2, 'PO-2026-007', '2026-10-15', 1218487, 231513, 1450000, 'Pendiente', '60 kg Crema de leche 35% MG y mantequilla'],
    [8, 4, 'PO-2026-008', '2026-10-16', 420168, 79832, 500000, 'Pendiente', 'Mejorador panario y malta tostada bio'],
    [9, 1, 'PO-2026-009', '2026-10-17', 2647059, 502941, 3150000, 'Pagado', '140 sacos Harina Tradición Francesa T65'],
    [10, 5, 'PO-2026-010', '2026-10-18', 1680672, 319328, 2000000, 'En proceso', 'Pasta de avellanas del Piamonte y cacao en polvo']
];

$stmtPO = $pdo->prepare("INSERT INTO purchase_orders (id, supplier_id, folio, issue_date, net_amount, tax, total_amount, status, notes)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($purchaseOrders as $po) {
    $stmtPO->execute($po);
}
echo "✔ Purchase Orders created (" . count($purchaseOrders) . " POs).\n";

// 4. Dispatch Routes spanning the week
$dispatchRoutes = [
    // Today: Monday 2026-10-19
    ['06:30 AM', 'Ruta 01 - Reparto Matinal Cafeterías La Serena', 'Restaurantes & Cafés', 'Casino Central Servicio Salud', 'Av. Balmaceda 916, La Serena', 'Carlos Mendoza', 'Entregado', '80 kg Marraqueta, 45 Baguettes, 30 Pasteles Finos', 'Entregado conforme (+3.8°C). Firma digital recepcionada.'],
    ['08:00 AM', 'Ruta 02 - Distribución Hotelería y Eventos Peñuelas', 'Hoteles & Eventos', 'Buffet Desayunos Enjoy Coquimbo', 'Peñuelas Norte 56, Coquimbo', 'Juan Pablo Riquelme', 'En camino', '40 kg Hallullas, 15 Tortas Selva Negra, 90 Empanadas Pino', 'Furgón refrigerado en tránsito sobre Ruta 5.'],
    ['11:30 AM', 'Ruta 03 - Reabastecimiento Sucursal Norte', 'Sucursales Propias', 'Sucursal Puerto Coquimbo', 'Calle Aldunate 450, Coquimbo', 'Carlos Mendoza', 'Pendiente', '120 kg Harina Flor, 40 kg Mantequilla, Insumos Repostería', 'Carga programada en andén de salida obrador central.'],
    ['14:00 PM', 'Ruta 04 - Reparto Tarde Cafeterías Casco Histórico', 'Restaurantes & Cafés', 'Café Colonial La Serena', 'Prat 420, La Serena', 'Juan Pablo Riquelme', 'Pendiente', '50 Croissants AOP, 35 Baguettes, 20 Tortas Ópera', 'Programado para turno vespertino.'],

    // Sunday: 2026-10-18
    ['07:00 AM', 'Ruta Dom-01 - Despacho Dominical Club de Golf', 'Clubes & Hoteles', 'Club de Golf La Serena', 'Av. del Mar 2200, La Serena', 'Carlos Mendoza', 'Entregado', '60 kg Marraqueta, 25 Tortas Selva Negra, 120 Empanadas', 'Entregado sin novedades a las 08:15 AM.'],
    ['09:30 AM', 'Ruta Dom-02 - Repostería Fina Eventos Familiares', 'Eventos Privados', 'Centro de Eventos El Faro', 'Av. Francisco de Aguirre 010', 'Juan Pablo Riquelme', 'Entregado', '18 Tortas Ópera, 80 Pasteles Surtidos, 50 Croissants', 'Recepción de banquetera conforme.'],

    // Saturday: 2026-10-17
    ['06:15 AM', 'Ruta Sáb-01 - Abastecimiento Supermercados Locales', 'Supermercados', 'Supermercado Central La Florida', 'Av. Panorámica 110, La Serena', 'Carlos Mendoza', 'Entregado', '150 kg Marraqueta, 120 kg Hallullas, 60 Baguettes', 'Inspección de calidad aprobada en andén.'],
    ['08:30 AM', 'Ruta Sáb-02 - Hoteles Av. del Mar Fin de Semana', 'Hoteles', 'Hotel Serena Suite', 'Ruta 5 Norte Km 470, La Serena', 'Juan Pablo Riquelme', 'Entregado', '80 Croissants, 40 kg Pan Tradicional, 12 Tortas Vitrina', 'Entregado a jefe de compras con temperatura +3.6°C.'],

    // Friday: 2026-10-16
    ['06:30 AM', 'Ruta Vie-01 - Casino Minero & Corporativo', 'Corporativo', 'Casino Minera San Gerónimo', 'Camino Lambert s/n, La Serena', 'Carlos Mendoza', 'Entregado', '140 kg Marraqueta, 80 kg Hallullas, 100 Empanadas', 'Factura electrónica recibida conforme.'],
    ['10:00 AM', 'Ruta Vie-02 - Repostería Cafeterías Universidad', 'Educación', 'Casino Central Campus Ignacio Domeyko', 'Benavente 980, La Serena', 'Juan Pablo Riquelme', 'Entregado', '60 Croissants, 90 Empanadas Pino, 40 Pasteles Surtidos', 'Entregado a concesionario universitario.'],

    // Thursday: 2026-10-15
    ['07:00 AM', 'Ruta Jue-01 - Cafés & Restaurantes Centro Coquimbo', 'Restaurantes & Cafés', 'Cafetería del Puerto', 'Melgarejo 1020, Coquimbo', 'Carlos Mendoza', 'Entregado', '50 kg Pan Tradicional, 30 Baguettes, 20 Pasteles Finos', 'Entregado a tiempo.']
];

$stmtRoute = $pdo->prepare("INSERT INTO dispatch_routes (time, title, type, destination, address, driver, status, items, notes)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($dispatchRoutes as $r) {
    $stmtRoute->execute($r);
}
echo "✔ Dispatch Routes seeded (" . count($dispatchRoutes) . " routes).\n";

// 5. Sales & Sale Details: Realistic Day-by-Day Generator (Full Month + Full Week)
// Target Daily Totals:
$dailyTargets = [
    '2026-10-01' => 1150000,
    '2026-10-02' => 1280000,
    '2026-10-03' => 1420000,
    '2026-10-04' => 1180000,
    '2026-10-05' => 1090000,
    '2026-10-06' => 1240000,
    '2026-10-07' => 1310000,
    '2026-10-08' => 1380000,
    '2026-10-09' => 1760000,
    '2026-10-10' => 1590000,
    '2026-10-11' => 1350000,
    // The Completed Week:
    '2026-10-12' => 1120000, // LUN
    '2026-10-13' => 1280000, // MAR
    '2026-10-14' => 1340000, // MIÉ
    '2026-10-15' => 1410000, // JUE
    '2026-10-16' => 1890000, // VIE
    '2026-10-17' => 1650000, // SÁB
    '2026-10-18' => 1420000, // DOM
    // Today:
    '2026-10-19' => 1476500  // LUN (Hoy)
];

$paymentMethods = ['Efectivo', 'Tarjeta Débito', 'Transferencia'];
$cashiers = ['Marcela Soto', 'Luis Henríquez'];

$catalog = [
    1 => ['name' => 'Pan Marraqueta Tradicional', 'price' => 2190],
    2 => ['name' => 'Hallullas Especiales', 'price' => 2290],
    3 => ['name' => 'Torta Selva Negra', 'price' => 18500],
    4 => ['name' => 'Empanadas de Pino Horno', 'price' => 2600],
    5 => ['name' => 'Pasteles Surtidos Finos', 'price' => 1800],
    6 => ['name' => 'Baguette Tradición Francesa', 'price' => 1690],
    7 => ['name' => 'Croissant Mantequilla AOP Isigny', 'price' => 2400],
    8 => ['name' => 'Torta Ópera Grand Cru 70%', 'price' => 18500],
];

$folioCounter = 4801;
$totalSalesCount = 0;
$totalDetailsCount = 0;
$grandTotalRevenue = 0;

$stmtSale = $pdo->prepare("INSERT INTO sales (folio, date, subtotal, tax, total, payment_method, cashier, status)
                           VALUES (?, ?, ?, ?, ?, ?, ?, 'Completada')");
$stmtDetail = $pdo->prepare("INSERT INTO sale_details (sale_id, product_id, quantity, unit_price, subtotal)
                             VALUES (?, ?, ?, ?, ?)");

foreach ($dailyTargets as $dateStr => $targetAmount) {
    $currentDayTotal = 0;
    $targetNet = (int)round($targetAmount / 1.19); // Net before 19% VAT

    // Plan 12-16 sales per day
    $numSales = ($dateStr >= '2026-10-16' && $dateStr <= '2026-10-18') ? 16 : 12;
    $avgNetPerSale = (int)round($targetNet / $numSales);

    for ($i = 0; $i < $numSales; $i++) {
        $folio = sprintf("BOL-%06d", $folioCounter++);
        $hour = 7 + (int)($i * (13 / $numSales));
        $minute = ($i * 19) % 60;
        $second = ($i * 29) % 60;
        $timestamp = sprintf("%s %02d:%02d:%02d", $dateStr, $hour, $minute, $second);
        $method = $paymentMethods[($i + $folioCounter) % count($paymentMethods)];
        $cashier = $cashiers[$i % count($cashiers)];

        $items = [];
        $saleSubtotal = 0;

        // Is this a wholesale/B2B large ticket (1-2 per day) or a retail ticket?
        $isWholesale = ($i === 2 || ($numSales > 12 && $i === 8));

        if ($isWholesale) {
            // Wholesale hotel or casino delivery ticket
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

        // On the last ticket of the day, calibrate with a custom adjustment line to reach the target closely
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

echo "✔ Sales generated: $totalSalesCount sales, $totalDetailsCount line items.\n";
echo "✔ Grand Total Sales Revenue: $" . number_format($grandTotalRevenue, 0, ',', '.') . "\n";

// 6. Audit Logs across the week
$auditEntries = [
    ['Sistema', 'Inicialización Base de Datos', 'Base de datos MariaDB 10.11 inicializada con esquema y semillas para Pan y Queque ERP', '127.0.0.1', '2026-10-01 06:00:00'],
    ['Proveedores', 'Orden de Compra PO-2026-001', 'Emisión PO-2026-001 a Harina Los Andes S.A. por $2.450.000', '127.0.0.1', '2026-10-02 09:15:00'],
    ['Cajas', 'Apertura Turno Octubre', 'Apertura de turno Caja 01 - Saldo base: $150.000', '127.0.0.1', '2026-10-12 06:45:00'],
    ['Logística', 'Despacho Ruta Vie-01', 'Despacho completado a Casino Minera San Gerónimo (+3.8°C)', '127.0.0.1', '2026-10-16 08:30:00'],
    ['Proveedores', 'Orden de Compra PO-2026-009', 'Emisión PO-2026-009 a Harina Los Andes por $3.150.000', '127.0.0.1', '2026-10-17 11:20:00'],
    ['Logística', 'Despacho Ruta Dom-01', 'Despacho Dominical Club de Golf recepcionado conforme', '127.0.0.1', '2026-10-18 08:15:00'],
    ['Seguridad', 'Inicio de Sesión', 'Acceso autenticado rol [gerente] usuario Ing. M. Valenzuela', '127.0.0.1', '2026-10-19 07:00:00'],
    ['Cajas', 'Apertura Turno Hoy', 'Apertura de turno matinal Caja 01 - Marcela Soto', '127.0.0.1', '2026-10-19 07:05:00'],
    ['Logística', 'Despacho Ruta 01', 'Entrega confirmada a Casino Central Servicio Salud (+3.8°C)', '127.0.0.1', '2026-10-19 08:15:00'],
    ['Cajas', 'Venta Mayorista', 'Boleta BOL-004910 emitida por $142.000 (Transferencia)', '127.0.0.1', '2026-10-19 10:30:00']
];

$stmtAudit = $pdo->prepare("INSERT INTO audit_logs (module, action, detail, source_ip, created_at)
                            VALUES (?, ?, ?, ?, ?)");
foreach ($auditEntries as $a) {
    $stmtAudit->execute($a);
}
echo "✔ Audit Logs seeded (" . count($auditEntries) . " logs).\n";

echo "=== Seeding Complete ===\n";
