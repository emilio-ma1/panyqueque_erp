# Panadería y Pastelería Pan y Queque - Sistema ERP

> **Idioma**: [English Version (README.md)](README.md) | **Español**

Sistema integrado de gestión empresarial (ERP) y control operativo para la intranet corporativa de **Panadería y Pastelería Pan y Queque**, desarrollado en PHP 8.2 nativo con Tailwind CSS y persistencia relacional en **PostgreSQL 15**.

Diseñado bajo la **Guía de Estándares de Codificación y Entregables para Desarrollo (V1.8)** emitida por Quality Assurance (QA) - Universidad de La Serena.

---

## 🚀 Despliegue Rápido con Docker Compose

El proyecto incluye un entorno listo en contenedores con **PHP 8.2 + Apache + PostgreSQL 15**.

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
- 🥖 **Punto de Venta (POS) [VLAN 20]:** [http://localhost:8080/pos.php](http://localhost:8080/pos.php)
- 📋 **Contabilidad & Proveedores [VLAN 10]:** [http://localhost:8080/suppliers.php](http://localhost:8080/suppliers.php)
- 🚚 **Logística & Despachos [VPN Choferes]:** [http://localhost:8080/dispatch.php](http://localhost:8080/dispatch.php)
- 🔒 **Dashboard Gerencial [VPN Gerencia]:** [http://localhost:8080/dashboard.php](http://localhost:8080/dashboard.php)

> *Nota: Las rutas legacy (`caja.php`, `proveedores.php`, `reparto.php`) aplican redirección permanente HTTP 301 a sus equivalentes canónicos en inglés.*

---

## 🧪 Suite de Pruebas Automatizadas (Gate de Calidad QA)

El proyecto incluye una base de pruebas unitarias aisladas que validan los servicios de dominio y utilidades con una **cobertura superior al 70%** (Sección 8 de la Guía de Estándares).

Para ejecutar la suite de pruebas:

```bash
php tests/run_tests.php
```

Todas las pruebas se ejecutan de forma autónoma con datos en memoria y degradación resiliente, sin depender de infraestructura externa.

---

## 🔐 Gestión de Variables de Entorno (Sección 6.3)

Toda configuración sensible se gestiona exclusivamente mediante variables de entorno:

| Variable | Obligatoria | Valor por Defecto | Propósito y Comportamiento en caso de Ausencia |
| :--- | :---: | :--- | :--- |
| `DB_HOST` | **Sí** | `db` | Nombre de host o servicio Docker de PostgreSQL. |
| `DB_PORT` | **Sí** | `5432` | Puerto de escucha de PostgreSQL (5432 por defecto). |
| `DB_NAME` | **Sí** | `panyqueque_erp` | Nombre de la base de datos relacional. |
| `DB_USER` | **Sí** | `erp_user` | Usuario de PostgreSQL con permisos sobre el esquema. |
| `DB_PASS` | **Sí** | *(cadena vacía)* | Contraseña del usuario. Si no se define, la conexión falla de inmediato y activa el modo resiliente en memoria sin exponer credenciales. |
| `APP_ENV` | No | `production` | Entorno de ejecución (`development`, `staging`, `production`). |

---

## 📁 Estructura del Proyecto

```
├── Dockerfile                  # Imagen PHP 8.2 Apache + PostgreSQL
├── docker-compose.yml          # Orquestación de servicios (Web + BD)
├── .env.example               # Plantilla de variables de entorno requeridas
├── .gitignore                  # Reglas de omisión de Git (protege .env y secretos)
├── phpunit.xml                 # Configuración de pruebas PHPUnit
├── docker/
│   ├── apache/
│   │   └── 000-default.conf    # VirtualHost Apache (DocumentRoot en /public)
│   └── postgres/
│       └── init.sql            # Esquema relacional DDL/DML en inglés snake_case
├── includes/
│   ├── config.php              # Constantes de red, direccionamiento IPv6 y VLANs
│   ├── db.php                  # Conector resiliente PDO PostgreSQL (Singleton)
│   ├── ProductService.php      # Servicio de dominio para catálogo de productos
│   ├── SupplierService.php     # Servicio de dominio para proveedores y finanzas
│   ├── DispatchService.php     # Servicio de dominio para rutas logísticas
│   ├── AuditService.php        # Servicio de dominio para eventos de auditoría
│   ├── header.php              # Cabecera compartida y barra de navegación
│   └── footer.php              # Pie de página compartido
├── public/
│   ├── index.php               # Portal de inicio y navegación
│   ├── pos.php                 # Terminal POS de ventas (Punto de Venta)
│   ├── suppliers.php           # Módulo de proveedores y cuentas por pagar
│   ├── dispatch.php            # Monitor de despacho y logística
│   ├── dashboard.php           # Analítica ejecutiva y auditoría en tiempo real
│   ├── caja.php                # Redirección HTTP 301 a pos.php
│   ├── proveedores.php         # Redirección HTTP 301 a suppliers.php
│   ├── reparto.php             # Redirección HTTP 301 a dispatch.php
│   └── assets/css/custom.css   # Estilos personalizados y utilidades de impresión
└── tests/
    ├── run_tests.php           # Ejecutor automatizado de pruebas por consola
    └── Unit/                   # Casos de prueba unitaria
```
