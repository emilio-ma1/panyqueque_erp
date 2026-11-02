# Panadería y Pastelería Pan y Queque - Sistema ERP

> **Idioma**: [English Version (README.md)](README.md) | **Español**

Sistema integrado de gestión empresarial (ERP) y control operativo para la intranet corporativa de **Panadería y Pastelería Pan y Queque**, desarrollado en PHP 8.2 nativo con Tailwind CSS, control de acceso basado en roles (RBAC) y persistencia relacional en **MariaDB 10.11 LTS**.

Diseñado bajo la **Guía de Estándares de Codificación y Entregables para Desarrollo (QA-STD-001 v2.0)** emitida por Quality Assurance (QA) - Universidad de La Serena y alineado con los requerimientos de infraestructura y segmentación de red para **P2 Redes II 2026** (VLAN 10, VLAN 20, VLAN 30, Spanning Tree Protocol y direccionamiento dual-stack IPv6).

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

### 3. Poblar o Reiniciar Base de Datos (Dataset Octubre 2026)
MariaDB se inicializa automáticamente desde `docker/mariadb/init.sql`. Para restablecer o volver a sembrar el conjunto histórico completo (datos operativos completos de octubre de 2026 y noviembre de 2026 limpio para pruebas en vivo):

```bash
docker compose exec web php scripts/seed_database.php
```

### 4. Acceder al Sistema ERP
Una vez activos los contenedores, abra su navegador en:

- 🏠 **Portal Principal y Catálogo:** [http://localhost:8080](http://localhost:8080)
- 🔑 **Portal de Autenticación & Control de Acceso:** [http://localhost:8080/login.php](http://localhost:8080/login.php)
- 🥖 **Punto de Venta (POS) [VLAN 20]:** [http://localhost:8080/pos.php](http://localhost:8080/pos.php)
- 📋 **Contabilidad & Proveedores [VLAN 10]:** [http://localhost:8080/suppliers.php](http://localhost:8080/suppliers.php)
- 🚚 **Logística & Despachos [VPN Choferes]:** [http://localhost:8080/dispatch.php](http://localhost:8080/dispatch.php)
- 🔒 **Dashboard Gerencial [VPN Gerencia]:** [http://localhost:8080/dashboard.php](http://localhost:8080/dashboard.php)

> *Nota: Las rutas legacy (`caja.php`, `proveedores.php`, `reparto.php`) aplican redirección permanente HTTP 301 a sus equivalentes canónicos en inglés.*

---

## 📚 Documentación y Manuales de Usuario

El repositorio cuenta con documentación exhaustiva:

- 📖 **[Manual de Usuario y Operación (MANUAL_USUARIO.md)](MANUAL_USUARIO.md)** / **[Docs/MANUAL_DE_USO.md](Docs/MANUAL_DE_USO.md)**: Guía completa paso a paso para la operación de cada rol, cobro en POS, arqueo de caja, programación de rutas logísticas y solución de problemas.
- 📐 **[Estándar de Codificación QA (Docs/Manual_de_codificacion.md)](Docs/Manual_de_codificacion.md)**: Código normativo institucional `QA-STD-001 v2.0`.
- 🌐 **[Topología Cisco Packet Tracer (Docs/PP2 REDES.pkt)](Docs/PP2%20REDES.pkt)**: Archivo de simulación Packet Tracer con diseño de red, Spanning Tree (STP), Port Security, VLANs y enrutamiento IPv6.

---

## 🌐 Segmentación de Red Institucional y Topología Cisco (P2 Redes II)

El ERP refleja la topología de red y segmentación corporativa modelada en Cisco Packet Tracer (`Docs/PP2 REDES.pkt`):

| Segmento | Identificador de Red | Prefijo / Dirección IPv6 | Alcance y Servicios |
| :--- | :--- | :--- | :--- |
| **VLAN 10** | `VLAN 10 - Administración` | `2001:db8:acad:10::/64` | Finanzas, Compras y Libro Mayor |
| **VLAN 20** | `VLAN 20 - Cajas_Ventas` | `2001:db8:acad:20::/64` | Terminales POS de Ventas y Arqueo de Caja |
| **VLAN 30** | `VLAN 30 - Servidores` | `2001:db8:acad:30::/64` | Servidor Web (`::80`), MariaDB (`::db`), Archivos (`::21`) |
| **VPN Choferes** | `VPN_CHOFERES` | `2001:db8:wan::100` | Logística, Albaranes y Confirmación de Entregas |
| **VPN Gerencia** | `VPN_GERENCIA` | `2001:db8:wan::200` | Dashboard Ejecutivo, KPIs y Consola de Auditoría |

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
   - Modal de programación de nuevas rutas (`+ Programar Nueva Ruta`) con tipificación de cliente (Restaurantes & Cafés, Hoteles, Hospitales, Sucursales, Supermercados) y asignación de chofer/vehículo.
   - Monitor de rutas y albaranes sincronizado directamente con la tabla `dispatch_routes`.
   - Modal de confirmación de entrega con firma de receptor y temperatura conforme (+3.8°C), actualizando el estado de la ruta a *Entregado* y registrando evento en `audit_logs`.

4. **Dashboard Ejecutivo Gerencial:**
   - Selectores de período: `HOY • TIEMPO REAL` (ventas del día en vivo), `7 DÍAS` (evolución semanal) y `MES EN CURSO` (consolidado octubre y noviembre).
   - Métricas de facturación bruta y neta computadas directamente sobre la tabla `sales`.
   - Desglose operativo de EBITDA: insumos/harinas (31.6%), nómina de obrador (24.0%) y energía de hornos (10.0%).
   - Ranking de Top 5 productos más vendidos obtenido mediante agregación SQL de `sale_details` y `products`.
   - Consola de auditoría operacional en vivo vinculada a MariaDB 10.11.

---

## 🧪 Suite de Pruebas Automatizadas (Gate de Calidad QA)

El proyecto incluye 25 pruebas unitarias automatizadas que validan la capa de servicios, cálculo de divisas, mapeo relacional y políticas de seguridad RBAC:

```bash
# Dentro del contenedor Docker:
docker compose exec web php tests/run_tests.php

# O directamente en el host (PHP 8.2+):
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
├── MANUAL_USUARIO.md          # Manual de usuario y operación del sistema (Español)
├── phpunit.xml                 # Configuración de pruebas PHPUnit
├── Docs/
│   ├── MANUAL_DE_USO.md       # Espejo del manual de usuario en carpeta Docs
│   ├── Manual_de_codificacion.md # Norma institucional QA-STD-001 v2.0
│   └── PP2 REDES.pkt           # Topología de red en Cisco Packet Tracer (P2 Redes II)
├── Plantilla/
│   └── stitch_bakery_erp_system # Diseños de interfaz y maquetas HTML de referencia
├── docker/
│   ├── apache/
│   │   └── 000-default.conf    # VirtualHost Apache (DocumentRoot en /public)
│   ├── mariadb/
│   │   └── init.sql            # Esquema MariaDB DDL/DML + usuarios + datos Octubre 2026
│   └── postgres/
│       └── init.sql            # Esquema relacional de referencia PostgreSQL
├── includes/
│   ├── config.php              # Constantes de red, direccionamiento IPv6 y VLANs
│   ├── db.php                  # Conector resiliente PDO MariaDB (Singleton)
│   ├── AuthService.php         # Control de acceso por roles (RBAC) y sesiones
│   ├── ProductService.php      # Servicio de dominio para catálogo de productos
│   ├── SupplierService.php     # Servicio de dominio para proveedores y finanzas
│   ├── DispatchService.php     # Servicio de dominio para rutas logísticas
│   ├── AuditService.php        # Servicio de dominio para eventos de auditoría
│   ├── header.php              # Cabecera corporativa, barra de navegación y control de rol
│   └── footer.php              # Pie de página corporativo
├── public/
│   ├── assets/                 # Hojas de estilo y recursos estáticos
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
├── scripts/
│   └── seed_database.php       # Script de sembrado histórico y reseteo MariaDB (Octubre 2026)
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
