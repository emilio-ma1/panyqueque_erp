-- ==============================================================================
-- Panadería y Pastelería Pan y Queque - PostgreSQL Database
-- Initialisation & Relational Schema (English snake_case per Section 5.1)
-- ==============================================================================

-- 1. Bakery & Pastry Products
CREATE TABLE IF NOT EXISTS products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    stock INTEGER NOT NULL DEFAULT 0,
    price INTEGER NOT NULL DEFAULT 0,
    unit VARCHAR(20) NOT NULL DEFAULT 'un',
    description TEXT,
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 2. Raw-Material Suppliers
CREATE TABLE IF NOT EXISTS suppliers (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    rut VARCHAR(20) NOT NULL UNIQUE,
    contact_name VARCHAR(100),
    phone VARCHAR(50),
    email VARCHAR(100),
    category VARCHAR(50),
    purchase_amount INTEGER NOT NULL DEFAULT 0,
    status VARCHAR(30) DEFAULT 'Al día',
    last_purchase_date DATE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 3. Supplier Purchase Orders
CREATE TABLE IF NOT EXISTS purchase_orders (
    id SERIAL PRIMARY KEY,
    supplier_id INTEGER REFERENCES suppliers(id) ON DELETE RESTRICT,
    folio VARCHAR(30) UNIQUE NOT NULL,
    issue_date DATE DEFAULT CURRENT_DATE,
    net_amount INTEGER NOT NULL DEFAULT 0,
    tax INTEGER NOT NULL DEFAULT 0,
    total_amount INTEGER NOT NULL DEFAULT 0,
    status VARCHAR(30) DEFAULT 'Pendiente',
    notes TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 4. Dispatch Routes & Field Deliveries (Logistics)
CREATE TABLE IF NOT EXISTS dispatch_routes (
    id SERIAL PRIMARY KEY,
    time VARCHAR(20) NOT NULL,
    title VARCHAR(150) NOT NULL,
    type VARCHAR(50),
    destination VARCHAR(150) NOT NULL,
    address VARCHAR(200),
    driver VARCHAR(100),
    status VARCHAR(30) DEFAULT 'Pendiente',
    items TEXT,
    notes TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 5. Point-of-Sale Transactions
CREATE TABLE IF NOT EXISTS sales (
    id SERIAL PRIMARY KEY,
    folio VARCHAR(30) UNIQUE NOT NULL,
    date TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    subtotal INTEGER NOT NULL DEFAULT 0,
    tax INTEGER NOT NULL DEFAULT 0,
    total INTEGER NOT NULL DEFAULT 0,
    payment_method VARCHAR(30) DEFAULT 'Efectivo',
    cashier VARCHAR(50) DEFAULT 'Caja 01',
    status VARCHAR(20) DEFAULT 'Completada'
);

-- 6. Line Items per Sale Receipt
CREATE TABLE IF NOT EXISTS sale_details (
    id SERIAL PRIMARY KEY,
    sale_id INTEGER REFERENCES sales(id) ON DELETE CASCADE,
    product_id INTEGER REFERENCES products(id) ON DELETE RESTRICT,
    quantity INTEGER NOT NULL DEFAULT 1,
    unit_price INTEGER NOT NULL,
    subtotal INTEGER NOT NULL
);

-- 7. Audit & Event Log
CREATE TABLE IF NOT EXISTS audit_logs (
    id SERIAL PRIMARY KEY,
    module VARCHAR(50) NOT NULL,
    action VARCHAR(100) NOT NULL,
    detail TEXT,
    source_ip VARCHAR(60),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- ==============================================================================
-- SEED DATA
-- ==============================================================================

-- Initial bakery products
INSERT INTO products (name, category, stock, price, unit, description) VALUES
('Pan Marraqueta Tradicional', 'Panadería', 140, 2190, 'kg', 'Crocante, doble fermentación artesanal en piso de piedra'),
('Hallullas Especiales', 'Panadería', 95, 2290, 'kg', 'Masa suave y hojaldrada con manteca de primera selección'),
('Torta Selva Negra', 'Pastelería', 12, 18500, 'un', 'Bizcocho húmedo de cacao con cerezas maceradas y crema chantilly'),
('Empanadas de Pino Horno', 'Rotisería', 60, 2600, 'un', 'Pino vacuno picado a cuchillo con cebolla caramelizada y masa casera'),
('Pasteles Surtidos Finos', 'Pastelería', 35, 1800, 'un', 'Eclairs de chocolate belga, milhojas de manjar de campo y tartaletas'),
('Baguette Tradición Francesa', 'Panadería', 48, 1690, 'un', 'Elaboración con masa madre y 24 horas de fermentación en frío')
ON CONFLICT DO NOTHING;

-- Initial suppliers
INSERT INTO suppliers (name, rut, contact_name, phone, email, category, purchase_amount, status, last_purchase_date) VALUES
('Harina Los Andes S.A.', '76.432.890-1', 'Rodrigo Silva', '+56 9 8452 1190', 'pedidos@harinalosandes.cl', 'Harinas & Granos', 2450000, 'Al día', '2026-10-10'),
('Lácteos del Sur SpA', '77.109.432-8', 'Camila Morales', '+56 9 7321 4455', 'ventas@lacteosdelsur.cl', 'Mantequillas & Cremas', 1180000, 'Pendiente', '2026-10-08'),
('Azúcar Refinada del Valle', '76.882.114-K', 'Ignacio Fuentes', '+56 9 9123 6670', 'contacto@azucarvalle.cl', 'Azúcares & Endulzantes', 640000, 'Al día', '2026-10-05'),
('Levaduras del Maipo', '78.332.901-3', 'Patricia Vega', '+56 9 6554 8821', 'distribucion@levadurasmaipo.cl', 'Levaduras & Mejoradores', 390000, 'Al día', '2026-10-12'),
('Chocolates & Coberturas Belgas', '76.012.778-5', 'Marcelo Dubois', '+56 9 5210 9943', 'importaciones@chocbelga.cl', 'Cacao & Chocolatería', 1890000, 'En proceso', '2026-10-02')
ON CONFLICT (rut) DO NOTHING;

-- Dispatch routes
INSERT INTO dispatch_routes (time, title, type, destination, address, driver, status, items, notes) VALUES
('08:30 AM', 'Ruta 01 - Reparto Matinal Cafeterías Oriente', 'Restaurantes & Cafés', 'Café & Bistro Bellavista', 'Av. Providencia 1420, Providencia', 'Carlos Mendoza', 'Entregado', '60 kg Marraqueta, 40 Baguettes, 20 Pasteles Finos', 'Entregado conforme con firma digital.'),
('11:00 AM', 'Ruta 02 - Distribución Hotelería y Eventos', 'Hoteles & Eventos', 'Hotel Plaza Santiago', 'Alameda 1050, Santiago Centro', 'Rodrigo Valenzuela', 'En camino', '25 kg Hallullas, 15 Tortas de Vitrina, 80 Empanadas', 'Vehículo en tránsito.'),
('15:00 PM', 'Ruta 03 - Reabastecimiento Sucursal Norte', 'Sucursales Propias', 'Pan y Queque - Sucursal Recoleta', 'Av. Recoleta 840, Recoleta', 'Carlos Mendoza', 'Pendiente', '100 kg Harina Flor, 30 kg Mantequilla, Insumos Repostería', 'Carga programada en andén de salida obrador central.')
ON CONFLICT DO NOTHING;

-- Initial audit entry
INSERT INTO audit_logs (module, action, detail, source_ip) VALUES
('Sistema', 'Inicialización Base de Datos', 'Base de datos PostgreSQL inicializada con esquema y semillas para Pan y Queque ERP', '127.0.0.1'),
('Cajas', 'Apertura de Turno', 'Apertura de turno matinal Caja 01 - Saldo inicial: $150.000', '127.0.0.1')
ON CONFLICT DO NOTHING;
