# Panadería y Pastelería Pan y Queque - ERP System

> **Language**: **English** | [Versión en Español (README.es.md)](README.es.md)

Integrated Enterprise Resource Planning (ERP) and operational control intranet platform for **Panadería y Pastelería Pan y Queque**, built with native PHP 8.2, Tailwind CSS, and a relational persistence layer on **PostgreSQL 15**.

Adheres to the **Coding and Deliverables Standards Guide (V1.8)** issued by Quality Assurance (QA) - Universidad de La Serena.

---

## 🚀 Quick Deployment with Docker Compose

The project includes a ready-to-run containerised environment with **PHP 8.2 + Apache + PostgreSQL 15**.

### 1. Environment Setup
Copy the environment example file and configure local credentials:

```bash
cp .env.example .env
```

### 2. Start Services
Launch the background containers from the project root:

```bash
docker compose up -d --build
```

### 3. Access ERP Endpoints
Once the containers are running, navigate to:

- 🏠 **Landing & Portal:** [http://localhost:8080](http://localhost:8080)
- 🥖 **Point of Sale (POS) [VLAN 20]:** [http://localhost:8080/pos.php](http://localhost:8080/pos.php)
- 📋 **Accounting & Suppliers [VLAN 10]:** [http://localhost:8080/suppliers.php](http://localhost:8080/suppliers.php)
- 🚚 **Logistics & Dispatch [Drivers VPN]:** [http://localhost:8080/dispatch.php](http://localhost:8080/dispatch.php)
- 🔒 **Executive Dashboard [Management VPN]:** [http://localhost:8080/dashboard.php](http://localhost:8080/dashboard.php)

> *Note: Legacy Spanish URLs (`caja.php`, `proveedores.php`, `reparto.php`) issue permanent HTTP 301 redirects to their canonical English routes.*

---

## 🧪 Automated Testing Suite (QA Gate of Quality)

The project includes an isolated unit test suite covering domain services and utilities, satisfying the minimum **70% code coverage** requirement (Section 8 of the Standards Guide).

To execute the test suite:

```bash
php tests/run_tests.php
```

All tests run in-memory with resilient fallbacks, requiring no external databases to execute.

---

## 🔐 Environment Variables Specification (Section 6.3)

All sensitive settings are managed exclusively via environment variables.

| Variable | Required | Default / Fallback | Purpose & Behavior if Undefined |
| :--- | :---: | :--- | :--- |
| `DB_HOST` | **Yes** | `db` | Database hostname or Docker service name. If undefined, attempts local service connection. |
| `DB_PORT` | **Yes** | `5432` | PostgreSQL listener port. Defaults to standard 5432. |
| `DB_NAME` | **Yes** | `panyqueque_erp` | Relational database schema name. |
| `DB_USER` | **Yes** | `erp_user` | Database user account with application privileges. |
| `DB_PASS` | **Yes** | *(empty string)* | Database user password. If undefined or empty, connection will fail fast and trigger resilient in-memory mode without exposing credentials. |
| `APP_ENV` | No | `production` | Execution environment (`development`, `staging`, `production`). |

---

## 📁 Project Architecture

```
├── Dockerfile                  # PHP 8.2 Apache + PostgreSQL image
├── docker-compose.yml          # Container orchestration (Web + DB)
├── .env.example               # Reference environment variables template
├── .gitignore                  # Git ignore rules (protects .env and secrets)
├── phpunit.xml                 # PHPUnit test configuration
├── docker/
│   ├── apache/
│   │   └── 000-default.conf    # Apache VirtualHost configuration
│   └── postgres/
│       └── init.sql            # DDL / DML database initialization schema (English)
├── includes/
│   ├── config.php              # Institutional constants & network settings
│   ├── db.php                  # Resilient PDO database connector (Singleton)
│   ├── ProductService.php      # Domain service for products catalog
│   ├── SupplierService.php     # Domain service for suppliers & metrics
│   ├── DispatchService.php     # Domain service for logistics & dispatch routes
│   ├── AuditService.php        # Domain service for system audit logs
│   ├── header.php              # Shared corporate navigation header
│   └── footer.php              # Shared corporate footer
├── public/
│   ├── index.php               # ERP landing and navigation portal
│   ├── pos.php                 # Canonical Point of Sale terminal
│   ├── suppliers.php           # Canonical Procurement & Accounting module
│   ├── dispatch.php            # Canonical Logistics & Delivery route manager
│   ├── dashboard.php           # Executive analytics and audit view
│   ├── caja.php                # HTTP 301 redirect to pos.php
│   ├── proveedores.php         # HTTP 301 redirect to suppliers.php
│   ├── reparto.php             # HTTP 301 redirect to dispatch.php
│   └── assets/css/custom.css   # Custom styling & print utilities
└── tests/
    ├── run_tests.php           # Automated CLI test runner
    └── Unit/                   # Automated unit test cases
```
