-- ==============================================================================
-- Panadería y Pastelería Pan y Queque - Base de Datos PostgreSQL
-- Script de Inicialización y Esquema Relacional
-- ==============================================================================

-- 1. Tabla de Productos de Panadería y Pastelería
CREATE TABLE IF NOT EXISTS productos (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    stock INTEGER NOT NULL DEFAULT 0,
    precio INTEGER NOT NULL DEFAULT 0,
    unidad VARCHAR(20) NOT NULL DEFAULT 'un',
    descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabla de Proveedores de Insumos y Materias Primas
CREATE TABLE IF NOT EXISTS proveedores (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    rut VARCHAR(20) NOT NULL UNIQUE,
    contacto VARCHAR(100),
    telefono VARCHAR(50),
    email VARCHAR(100),
    categoria VARCHAR(50),
    monto_compra INTEGER NOT NULL DEFAULT 0,
    estado VARCHAR(30) DEFAULT 'Al día',
    fecha_ultima_compra DATE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabla de Órdenes de Compra a Proveedores
CREATE TABLE IF NOT EXISTS pedidos_compra (
    id SERIAL PRIMARY KEY,
    proveedor_id INTEGER REFERENCES proveedores(id) ON DELETE RESTRICT,
    folio VARCHAR(30) UNIQUE NOT NULL,
    fecha_emision DATE DEFAULT CURRENT_DATE,
    monto_neto INTEGER NOT NULL DEFAULT 0,
    iva INTEGER NOT NULL DEFAULT 0,
    monto_total INTEGER NOT NULL DEFAULT 0,
    estado VARCHAR(30) DEFAULT 'Pendiente',
    observaciones TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 4. Tabla de Rutas y Despachos en Terreno (Logística)
CREATE TABLE IF NOT EXISTS rutas_despacho (
    id SERIAL PRIMARY KEY,
    hora VARCHAR(20) NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    tipo VARCHAR(50),
    destino VARCHAR(150) NOT NULL,
    direccion VARCHAR(200),
    chofer VARCHAR(100),
    estado VARCHAR(30) DEFAULT 'Pendiente',
    items TEXT,
    observacion TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 5. Tabla de Ventas en Punto de Venta (Cajas)
CREATE TABLE IF NOT EXISTS ventas (
    id SERIAL PRIMARY KEY,
    folio VARCHAR(30) UNIQUE NOT NULL,
    fecha TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    subtotal INTEGER NOT NULL DEFAULT 0,
    iva INTEGER NOT NULL DEFAULT 0,
    total INTEGER NOT NULL DEFAULT 0,
    medio_pago VARCHAR(30) DEFAULT 'Efectivo',
    cajero VARCHAR(50) DEFAULT 'Caja 01',
    estado VARCHAR(20) DEFAULT 'Completada'
);

-- 6. Detalle de Ítems Vendidos por Boleta
CREATE TABLE IF NOT EXISTS detalle_ventas (
    id SERIAL PRIMARY KEY,
    venta_id INTEGER REFERENCES ventas(id) ON DELETE CASCADE,
    producto_id INTEGER REFERENCES productos(id) ON DELETE RESTRICT,
    cantidad INTEGER NOT NULL DEFAULT 1,
    precio_unitario INTEGER NOT NULL,
    subtotal INTEGER NOT NULL
);

-- 7. Registro de Auditoría y Eventos
CREATE TABLE IF NOT EXISTS auditoria_logs (
    id SERIAL PRIMARY KEY,
    modulo VARCHAR(50) NOT NULL,
    accion VARCHAR(100) NOT NULL,
    detalle TEXT,
    ip_origen VARCHAR(60),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- ==============================================================================
-- CARGA DE DATOS INICIALES (SEMILLAS / SEED DATA)
-- ==============================================================================

-- Productos Iniciales del Obrador
INSERT INTO productos (nombre, categoria, stock, precio, unidad, descripcion) VALUES
('Pan Marraqueta Tradicional', 'Panadería', 140, 2190, 'kg', 'Crocante, doble fermentación artesanal en piso de piedra'),
('Hallullas Especiales', 'Panadería', 95, 2290, 'kg', 'Masa suave y hojaldrada con manteca de primera selección'),
('Torta Selva Negra', 'Pastelería', 12, 18500, 'un', 'Bizcocho húmedo de cacao con cerezas maceradas y crema chantilly'),
('Empanadas de Pino Horno', 'Rotisería', 60, 2600, 'un', 'Pino vacuno picado a cuchillo con cebolla caramelizada y masa casera'),
('Pasteles Surtidos Finos', 'Pastelería', 35, 1800, 'un', 'Eclairs de chocolate belga, milhojas de manjar de campo y tartaletas'),
('Baguette Tradición Francesa', 'Panadería', 48, 1690, 'un', 'Elaboración con masa madre y 24 horas de fermentación en frío')
ON CONFLICT DO NOTHING;

-- Proveedores Iniciales
INSERT INTO proveedores (nombre, rut, contacto, telefono, email, categoria, monto_compra, estado, fecha_ultima_compra) VALUES
('Harina Los Andes S.A.', '76.432.890-1', 'Rodrigo Silva', '+56 9 8452 1190', 'pedidos@harinalosandes.cl', 'Harinas & Granos', 2450000, 'Al día', '2026-10-10'),
('Lácteos del Sur SpA', '77.109.432-8', 'Camila Morales', '+56 9 7321 4455', 'ventas@lacteosdelsur.cl', 'Mantequillas & Cremas', 1180000, 'Pendiente', '2026-10-08'),
('Azúcar Refinada del Valle', '76.882.114-K', 'Ignacio Fuentes', '+56 9 9123 6670', 'contacto@azucarvalle.cl', 'Azúcares & Endulzantes', 640000, 'Al día', '2026-10-05'),
('Levaduras del Maipo', '78.332.901-3', 'Patricia Vega', '+56 9 6554 8821', 'distribucion@levadurasmaipo.cl', 'Levaduras & Mejoradores', 390000, 'Al día', '2026-10-12'),
('Chocolates & Coberturas Belgas', '76.012.778-5', 'Marcelo Dubois', '+56 9 5210 9943', 'importaciones@chocbelga.cl', 'Cacao & Chocolatería', 1890000, 'En proceso', '2026-10-02')
ON CONFLICT (rut) DO NOTHING;

-- Rutas de Despacho
INSERT INTO rutas_despacho (hora, titulo, tipo, destino, direccion, chofer, estado, items, observacion) VALUES
('08:30 AM', 'Ruta 01 - Reparto Matinal Cafeterías Oriente', 'Restaurantes & Cafés', 'Café & Bistro Bellavista', 'Av. Providencia 1420, Providencia', 'Carlos Mendoza', 'Entregado', '60 kg Marraqueta, 40 Baguettes, 20 Pasteles Finos', 'Entregado conforme con firma digital.'),
('11:00 AM', 'Ruta 02 - Distribución Hotelería y Eventos', 'Hoteles & Eventos', 'Hotel Plaza Santiago', 'Alameda 1050, Santiago Centro', 'Rodrigo Valenzuela', 'En camino', '25 kg Hallullas, 15 Tortas de Vitrina, 80 Empanadas', 'Vehículo en tránsito.'),
('15:00 PM', 'Ruta 03 - Reabastecimiento Sucursal Norte', 'Sucursales Propias', 'Pan y Queque - Sucursal Recoleta', 'Av. Recoleta 840, Recoleta', 'Carlos Mendoza', 'Pendiente', '100 kg Harina Flor, 30 kg Mantequilla, Insumos Repostería', 'Carga programada en andén de salida obrador central.')
ON CONFLICT DO NOTHING;

-- Registro de Auditoría Inicial
INSERT INTO auditoria_logs (modulo, accion, detalle, ip_origen) VALUES
('Sistema', 'Inicialización Base de Datos', 'Base de datos PostgreSQL inicializada con esquema y semillas para Pan y Queque ERP', '127.0.0.1'),
('Cajas', 'Apertura de Turno', 'Apertura de turno matinal Caja 01 - Saldo inicial: $150.000', '127.0.0.1')
ON CONFLICT DO NOTHING;
