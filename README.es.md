# Panadería y Pastelería Pan y Queque - Sistema ERP

> **Idioma**: [English Version (README.md)](README.md) | **Español**

Sistema integrado de gestión empresarial (ERP) y control operativo para la intranet corporativa de **Panadería y Pastelería Pan y Queque**, desarrollado en PHP 8.2 nativo con Tailwind CSS, control de acceso basado en roles (RBAC) y persistencia relacional en **MariaDB 10.11 LTS**.

Diseñado bajo la **Guía de Estándares de Codificación y Entregables para Desarrollo (V1.8)** emitida por Quality Assurance (QA) - Universidad de La Serena y alineado con los requerimientos de infraestructura y segmentación de red para **P2 Redes II 2026**.

---

## 🚀 Despliegue Rápido con Docker Compose

El proyecto incluye un entorno listo en contenedores con **PHP 8.2 + Apache + MariaDB 10.11 LTS**.

### 1. Configurar Entorno
Copie la plantilla de variables de entorno e ingrese sus credenciales:

```bash
cp .env.example .env
```

### 2. Iniciar Servicios
Levante los servicios en segundo plano desde la raíz del proyecto:

```bash
docker compose up -d --build
```

### 3. Acceder al Sistema ERP
Una vez activos los contenedores, abra su navegador en:

- 🏠 **Portal Principal:** [http://localhost:8080](http://localhost:8080)
- 🔑 **Portal de Autenticación & Control de Acceso:** [http://localhost:8080/login.php](http://localhost:8080/login.php)
- 🥖 **Punto de Venta (POS) [VLAN 20]:** [http://localhost:8080/pos.php](http://localhost:8080/pos.php)
- 📋 **Contabilidad & Proveedores [VLAN 10]:** [http://localhost:8080/suppliers.php](http://localhost:8080/suppliers.php)
- 🚚 **Logística & Despachos [VPN Choferes]:** [http://localhost:8080/dispatch.php](http://localhost:8080/dispatch.php)
- 🔒 **Dashboard Gerencial [VPN Gerencia]:** [http://localhost:8080/dashboard.php](http://localhost:8080/dashboard.php)

> *Nota: Las rutas legacy (`caja.php`, `proveedores.php`, `reparto.php`) aplican redirección permanente HTTP 301 a sus equivalentes canónicos en inglés.*

---

## 👥 Cuentas de Usuario y Control de Acceso (RBAC)

El sistema incorpora control de acceso perimetral según el rol asignado a cada cuenta, reflejando las políticas de seguridad perimetral y ACLs de IPv6:

| Usuario | Contraseña | Rol Institucional | Módulos Autorizados | Restricciones |
| :--- | :--- | :--- | :--- | :--- |
| `gerente` | `admin123` | **Gerente General** | Todos (Inicio, POS, Proveedores, Rutas, Dashboard) | Sin restricciones |
| `cajero` | `caja123` | **Cajero de Mostrador** | Inicio, Punto de Venta (POS), Arqueo de Caja | Bloqueado en Proveedores, Rutas y Dashboard |
| `chofer` | `chofer123` | **Chofer de Reparto** | Inicio, Logística & Rutas, Confirmación de Albaranes | Bloqueado en POS, Proveedores y Dashboard |
| `finanzas` | `finanzas123` | **Jefe de Finanzas** | Inicio, Proveedores & Libro Mayor, Dashboard | Bloqueado en POS y Rutas |

> En la pantalla de login (`login.php`) se incluyen botones de **Acceso Rápido 1-Click** para alternar de forma inmediata entre roles durante demostraciones o evaluaciones.

---

## ⚡ Funcionalidad 100% en Base de Datos (Sin Mock)

1. **Punto de Venta (POS):**
   - El ticket inicia limpio sin productos pregrabados.
   - Permite agregar productos del catálogo activo en MariaDB.
   - Emite boleta con folio correlativo único, cálculo de IVA (19%), rebaja automática de stock e inserción en tablas `sales`, `sale_details` y `audit_logs`.
   - Arqueo de caja y cuadratura en vivo consultando las ventas reales del día agrupadas por método de pago (Efectivo, Débito, Transferencia).

2. **Proveedores & Finanzas:**
   - Emisión de Órdenes de Compra (PO) reales persistidas en la tabla `purchase_orders`.
   - Actualización automática de volúmenes de compra y última fecha en la tabla `suppliers`.
   - Consulta del Libro Mayor con balance general, cuentas por pagar y cuentas por cobrar computadas en tiempo real.

3. **Logística & Despacho:**
   - Monitor de rutas y albaranes sincronizado con la tabla `dispatch_routes`.
   - Modal de confirmación de entrega con firma de receptor y temperatura conforme (+3.8°C), actualizando el estado de la ruta a *Entregado* y registrando evento en `audit_logs`.

4. **Dashboard Ejecutivo Gerencial:**
   - Métricas de facturación bruta y neta computadas directamente sobre la tabla `sales`.
   - Ranking de Top 5 productos más vendidos obtenido mediante agregación SQL de `sale_details` y `products`.
   - Consola de auditoría operacional en vivo vinculada a MariaDB 10.11.

---

## 🧪 Suite de Pruebas Automatizadas (Gate de Calidad QA)

El proyecto incluye 25 pruebas unitarias automatizadas que validan la capa de servicios, cálculo de divisas, mapeo relacional y políticas de seguridad RBAC:

```bash
php tests/run_tests.php
```

Todas las pruebas se ejecutan de forma autónoma con datos en memoria y degradación resiliente, sin depender de infraestructura externa.

---

## 🔐 Gestión de Variables de Entorno (Sección 6.3)

Toda configuración sensible se gestiona exclusivamente mediante variables de entorno:

| Variable | Obligatoria | Valor por Defecto | Propósito y Comportamiento |
| :--- | :---: | :--- | :--- |
| `DB_HOST` | **Sí** | `db` | Host del servidor MariaDB (usar `127.0.0.1` si corre fuera de Docker). |
| `DB_PORT` | **Sí** | `3306` | Puerto de escucha de MariaDB (3306 por defecto). |
| `DB_NAME` | **Sí** | `panyqueque_erp` | Nombre de la base de datos relacional. |
| `DB_USER` | **Sí** | `erp_user` | Usuario de MariaDB con permisos sobre el esquema. |
| `DB_PASS` | **Sí** | `erp_password_2026` | Contraseña del usuario de MariaDB. |
| `MYSQL_ROOT_PASSWORD` | **Sí** | `erp_root_password_2026` | Contraseña root para inicialización de contenedor. |
| `TZ` | No | `America/Santiago` | Zona horaria del sistema. |

---

## 📁 Estructura del Proyecto

```
├── Dockerfile                  # Imagen PHP 8.2 Apache + MariaDB (pdo_mysql)
├── docker-compose.yml          # Orquestación de servicios (Web + MariaDB 10.11)
├── .env.example               # Plantilla de variables de entorno requeridas
├── .gitignore                  # Reglas de omisión de Git (protege .env y secretos)
├── phpunit.xml                 # Configuración de pruebas PHPUnit
├── docker/
│   ├── apache/
│   │   └── 000-default.conf    # VirtualHost Apache (DocumentRoot en /public)
│   └── mariadb/
│       └── init.sql            # Esquema relacional DDL/DML MariaDB + usuarios + semillas
├── includes/
│   ├── config.php              # Constantes de red, direccionamiento IPv6 y VLANs
│   ├── db.php                  # Conector resiliente PDO MariaDB (Singleton)
│   ├── AuthService.php         # Control de acceso por roles (RBAC) y sesiones
│   ├── ProductService.php      # Servicio de dominio para catálogo de productos
│   ├── SupplierService.php     # Servicio de dominio para proveedores y finanzas
│   ├── DispatchService.php     # Servicio de dominio para rutas logísticas
│   ├── AuditService.php        # Servicio de dominio para eventos de auditoría
│   ├── header.php              # Cabecera compartida, barra de navegación y control de rol
│   └── footer.php              # Pie de página corporativo
├── public/
│   ├── index.php               # Portal de inicio y catálogo dinámico
│   ├── login.php               # Portal de login y selector de roles demo
│   ├── logout.php              # Cierre seguro de sesión
│   ├── pos.php                 # Terminal POS de ventas interactiva con MariaDB
│   ├── suppliers.php           # Módulo de proveedores y emisión de órdenes (PO)
│   ├── dispatch.php            # Monitor de despacho y confirmación de entregas
│   ├── dashboard.php           # Analítica ejecutiva y auditoría en tiempo real
│   ├── caja.php                # Redirección HTTP 301 a pos.php
│   ├── proveedores.php         # Redirección HTTP 301 a suppliers.php
│   └── reparto.php             # Redirección HTTP 301 a dispatch.php
└── tests/
    ├── run_tests.php           # Ejecutor autónomo de pruebas
    └── Unit/
        ├── FormatCurrencyTest.php
        ├── ProductServiceTest.php
        ├── SupplierServiceTest.php
        ├── DispatchServiceTest.php
        ├── AuditServiceTest.php
        └── AuthServiceTest.php
```
