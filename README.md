# Panadería y Pastelería Pan y Queque - ERP System

> **Language**: **English** | [Versión en Español (README.es.md)](README.es.md)

Integrated Enterprise Resource Planning (ERP) and operational intranet control platform for **Panadería y Pastelería Pan y Queque**, built with native PHP 8.2, Tailwind CSS, Role-Based Access Control (RBAC), and relational persistence on **MariaDB 10.11 LTS**.

Adheres strictly to the **Coding and Deliverables Standards Guide (QA-STD-001 v2.0)** issued by Quality Assurance (QA) - Universidad de La Serena and aligns with institutional network segmentation requirements for **P2 Redes II 2026** (VLAN 10, VLAN 20, VLAN 30, Spanning Tree Protocol, and IPv6 dual-stack addressing).

---

## 🚀 Quick Deployment with Docker Compose

The project includes a production-ready containerised stack with **PHP 8.2 + Apache + MariaDB 10.11 LTS**.

### 1. Environment Setup
Copy the environment example file and configure credentials:

```bash
cp .env.example .env
```

### 2. Start Services
Launch background containers from the project root:

```bash
docker compose up -d --build
```

### 3. Seed or Reset Database (October 2026 Dataset)
MariaDB automatically initializes from `docker/mariadb/init.sql`. To reset or re-seed the full historical dataset (complete operational data for October 2026, leaving November 2026 ready for live manual testing):

```bash
docker compose exec web php scripts/seed_database.php
```

### 4. Access ERP Endpoints
Once the containers are running, navigate to:

- 🏠 **Landing & Production Catalog:** [http://localhost:8080](http://localhost:8080)
- 🔑 **Authentication & Access Control Portal:** [http://localhost:8080/login.php](http://localhost:8080/login.php)
- 🥖 **Point of Sale (POS) [VLAN 20]:** [http://localhost:8080/pos.php](http://localhost:8080/pos.php)
- 📋 **Accounting & Suppliers [VLAN 10]:** [http://localhost:8080/suppliers.php](http://localhost:8080/suppliers.php)
- 🚚 **Logistics & Dispatch [Drivers VPN]:** [http://localhost:8080/dispatch.php](http://localhost:8080/dispatch.php)
- 🔒 **Executive Dashboard [Management VPN]:** [http://localhost:8080/dashboard.php](http://localhost:8080/dashboard.php)

> *Note: Legacy Spanish URLs (`caja.php`, `proveedores.php`, `reparto.php`) issue permanent HTTP 301 redirects to their canonical English routes.*

---

## 📚 Documentation & User Guides

Comprehensive documentation is included within the repository:

- 📖 **[User & Operations Manual (MANUAL_USUARIO.md)](MANUAL_USUARIO.md)** / **[Docs/MANUAL_DE_USO.md](Docs/MANUAL_DE_USO.md)**: Full step-by-step user guide explaining workflows for every role, sales checkout, cash drawer count, route programming, and troubleshooting.
- 📐 **[Coding Standards Guide (Docs/Manual_de_codificacion.md)](Docs/Manual_de_codificacion.md)**: Institutional Quality Assurance Standard `QA-STD-001 v2.0`.
- 🌐 **[Cisco Packet Tracer Topology (Docs/PP2 REDES.pkt)](Docs/PP2%20REDES.pkt)**: Network topology file for Cisco Packet Tracer modeling VLANs, Spanning Tree Protocol (STP), Port Security, and IPv6 routing.

---

## 🌐 Institutional Network Segmentation & Cisco Topology (P2 Redes II)

The ERP is architected to mirror the enterprise and branch network segmentation designed in Cisco Packet Tracer (`Docs/PP2 REDES.pkt`):

| Segment | Network Identifier | IPv6 Prefix / Address | Scope & Services |
| :--- | :--- | :--- | :--- |
| **VLAN 10** | `VLAN 10 - Administración` | `2001:db8:acad:10::/64` | Finance, Procurement, General Ledger |
| **VLAN 20** | `VLAN 20 - Cajas_Ventas` | `2001:db8:acad:20::/64` | POS Terminals, Cash Count & Drawer Balancing |
| **VLAN 30** | `VLAN 30 - Servidores` | `2001:db8:acad:30::/64` | Web Server (`::80`), MariaDB (`::db`), File Server (`::21`) |
| **VPN Drivers** | `VPN_CHOFERES` | `2001:db8:wan::100` | Logistics, Dispatch Waybills & Delivery Confirmations |
| **VPN Management** | `VPN_GERENCIA` | `2001:db8:wan::200` | Executive Dashboard, KPIs, Live Audit Console |

---

## 👥 User Accounts and Role-Based Access Control (RBAC)

The system enforces perimeter and module access controls mapped to institutional roles, matching network ACL and IPv6 policies:

| Username | Password | Institutional Role | Authorized Modules | Restrictions |
| :--- | :--- | :--- | :--- | :--- |
| `gerente` | `admin123` | **General Manager** | All (Home, POS, Suppliers, Routes, Dashboard) | No restrictions |
| `cajero` | `caja123` | **Counter Cashier** | Home, Point of Sale (POS), Cash Count | Blocked from Suppliers, Routes, Dashboard |
| `chofer` | `chofer123` | **Delivery Driver** | Home, Logistics & Routes, Delivery Confirmation | Blocked from POS, Suppliers, Dashboard |
| `finanzas` | `finanzas123` | **Finance Lead** | Home, Suppliers & General Ledger, Dashboard | Blocked from POS and Routes |

> On the login page (`login.php`), **1-Click Fast Access** buttons are provided to instantly toggle between roles during demonstrations or academic evaluation.

---

## ⚡ 100% Database Functionality (No Mock Data)

1. **Point of Sale (POS):**
   - Clean ticket initialization (no pre-loaded mock items).
   - Dynamic catalog lookup directly from MariaDB.
   - Transactional checkout: generates unique sequential receipt numbers, calculates VAT (19%), decrements warehouse stock, and records transactions in `sales`, `sale_details`, and `audit_logs`.
   - Real-time cash drawer count computed dynamically from today's completed sales by payment method (Cash, Debit Card, Wire Transfer).

2. **Procurement & Finance:**
   - Real Purchase Order (PO) creation persisted into the `purchase_orders` table.
   - Automatic volume accumulation and `last_purchase_date` updates in `suppliers`.
   - Live General Ledger view with accounts payable, accounts receivable, and cash balance computed from database records.

3. **Logistics & Dispatch:**
   - Route programming modal (`+ Programar Nueva Ruta`) with client categorization (Restaurantes & Cafés, Hoteles, Hospitalario, Sucursales, Supermercados) and fleet driver assignment.
   - Route and delivery note tracking directly linked to `dispatch_routes`.
   - Waybill delivery confirmation modal with recipient signature and cold-chain temperature inspection (+3.8°C), updating status to *Entregado* and logging to `audit_logs`.

4. **Executive Dashboard:**
   - Time period selectors: `HOY • TIEMPO REAL` (live November transactions), `7 DÍAS` (weekly trend), and `MES EN CURSO` (consolidated October + November).
   - Real-time gross and net revenue metrics aggregated directly from `sales`.
   - Operational EBITDA breakdown: flour/raw materials (31.6%), bakery payroll (24.0%), oven energy (10.0%).
   - Top 5 best-selling products calculated via SQL join across `sale_details` and `products`.
   - Live operational audit trail console connected to MariaDB 10.11.

---

## 🧪 Automated Testing Suite (QA Gate of Quality)

The project includes 25 automated unit tests validating domain services, currency formatting, relational mapping, and RBAC security policies:

```bash
# Inside Docker container:
docker compose exec web php tests/run_tests.php

# Or directly on host (PHP 8.2+):
php tests/run_tests.php
```

All tests execute self-contained in memory with resilient fallbacks, without requiring external infrastructure.

---

## 🔐 Environment Variables Specification (Section 6.3)

All sensitive settings are managed exclusively via environment variables:

| Variable | Required | Default / Fallback | Purpose & Behavior if Undefined |
| :--- | :---: | :--- | :--- |
| `DB_HOST` | **Yes** | `db` | MariaDB server hostname (use `127.0.0.1` outside Docker). |
| `DB_PORT` | **Yes** | `3306` | MariaDB listener port (defaults to 3306). |
| `DB_NAME` | **Yes** | `panyqueque_erp` | Relational database schema name. |
| `DB_USER` | **Yes** | `erp_user` | Database user account with application privileges. |
| `DB_PASS` | **Yes** | `erp_password_2026` | Database user password. |
| `MYSQL_ROOT_PASSWORD` | **Yes** | `erp_root_password_2026` | Root password for container provisioning. |
| `TZ` | No | `America/Santiago` | System timezone. |

---

## 📁 Project Architecture

```
├── Dockerfile                  # PHP 8.2 Apache + MariaDB (pdo_mysql) image
├── docker-compose.yml          # Container orchestration (Web + MariaDB 10.11)
├── .env.example               # Reference environment variables template
├── .gitignore                  # Git ignore rules (protects .env and secrets)
├── MANUAL_USUARIO.md          # Comprehensive user and operation manual (Spanish)
├── phpunit.xml                 # PHPUnit test configuration
├── Docs/
│   ├── MANUAL_DE_USO.md       # User and operational manual (mirror)
│   ├── Manual_de_codificacion.md # QA Normative Standard QA-STD-001 v2.0
│   └── PP2 REDES.pkt           # Cisco Packet Tracer network topology (P2 Redes II)
├── Plantilla/
│   └── stitch_bakery_erp_system # Reference UI designs and HTML templates
├── docker/
│   ├── apache/
│   │   └── 000-default.conf    # Apache VirtualHost (DocumentRoot in /public)
│   ├── mariadb/
│   │   └── init.sql            # MariaDB DDL/DML schema + users + October 2026 seed
│   └── postgres/
│       └── init.sql            # PostgreSQL relational schema reference
├── includes/
│   ├── config.php              # Network constants, IPv6 addressing & VLAN specs
│   ├── db.php                  # Resilient PDO MariaDB connector (Singleton)
│   ├── AuthService.php         # Role-Based Access Control (RBAC) and sessions
│   ├── ProductService.php      # Domain service for product catalog
│   ├── SupplierService.php     # Domain service for suppliers & metrics
│   ├── DispatchService.php     # Domain service for logistics & dispatch routes
│   ├── AuditService.php        # Domain service for system audit logs
│   ├── header.php              # Shared corporate navigation header with role badge
│   └── footer.php              # Shared corporate footer
├── public/
│   ├── assets/                 # Static assets, stylesheets and icons
│   ├── index.php               # ERP landing and dynamic catalog portal
│   ├── login.php               # Login portal with 1-click role switchers
│   ├── logout.php              # Secure session termination
│   ├── pos.php                 # Interactive POS sales terminal with MariaDB
│   ├── suppliers.php           # Procurement and Purchase Order (PO) module
│   ├── dispatch.php            # Logistics monitor and delivery confirmation
│   ├── dashboard.php           # Executive analytics & live audit console
│   ├── caja.php                # HTTP 301 redirect to pos.php
│   ├── proveedores.php         # HTTP 301 redirect to suppliers.php
│   └── reparto.php             # HTTP 301 redirect to dispatch.php
├── scripts/
│   └── seed_database.php       # MariaDB October 2026 dataset seeder & reset utility
└── tests/
    ├── run_tests.php           # Standalone automated test runner
    └── Unit/
        ├── FormatCurrencyTest.php
        ├── ProductServiceTest.php
        ├── SupplierServiceTest.php
        ├── DispatchServiceTest.php
        ├── AuditServiceTest.php
        └── AuthServiceTest.php
```
