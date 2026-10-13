# Panadería y Pastelería Pan y Queque - Sistema ERP

Sistema integrado de gestión empresarial (ERP) y control operativo para la intranet de **Panadería y Pastelería Pan y Queque**, desarrollado en PHP nativo con Tailwind CSS y persistencia relacional en **PostgreSQL 15**.

---

## 🚀 Despliegue Rápido con Docker Compose

El proyecto incluye un entorno Docker listo con **PHP 8.2 + Apache + PostgreSQL 15**.

### 1. Iniciar los contenedores
Ejecute en la terminal en la raíz del proyecto:

```bash
docker compose up -d --build
```

### 2. Acceder al Sistema ERP
Una vez levantado el servicio, abra su navegador web en:

- 🏠 **Portal Principal (Inicio):** [http://localhost:8080](http://localhost:8080)
- 🥖 **Módulo de Cajas y POS (VLAN 20):** [http://localhost:8080/caja.php](http://localhost:8080/caja.php)
- 📋 **Contabilidad y Proveedores (VLAN 10):** [http://localhost:8080/proveedores.php](http://localhost:8080/proveedores.php)
- 🚚 **Logística y Despachos (VPN Choferes):** [http://localhost:8080/reparto.php](http://localhost:8080/reparto.php)
- 🔒 **Dashboard Gerencial Crítico (VPN Gerencia):** [http://localhost:8080/dashboard.php](http://localhost:8080/dashboard.php)

---

## 🗄️ Servicios Incluidos en Docker

| Servicio | Contenedor | Puerto Local | Descripción |
| :--- | :--- | :--- | :--- |
| **Web ERP** | `panyqueque_erp_web` | `8080` (HTTP) | Servidor Apache con PHP 8.2, mod_rewrite y extensiones PDO/PostgreSQL. |
| **Base de Datos** | `panyqueque_erp_db` | `5432` (PostgreSQL) | Servidor PostgreSQL 15 con esquema relacional y semillas iniciales. |

### Credenciales de la Base de Datos
- **Host:** `db` (desde el contenedor web) o `localhost` (desde el equipo anfitrión en puerto `5432`)
- **Base de Datos:** `panyqueque_erp`
- **Usuario:** `erp_user`
- **Contraseña:** `erp_password_2026`

---

## 📁 Estructura del Proyecto

```
├── Dockerfile                  # Configuración de imagen PHP 8.2 Apache + PostgreSQL
├── docker-compose.yml          # Orquestación de servicios Web y PostgreSQL
├── .dockerignore               # Archivos omitidos en compilación de imágenes
├── .gitignore                  # Archivos ignorados por Git
├── .htaccess                   # Reescritura y seguridad web
├── docker/
│   ├── apache/
│   │   └── 000-default.conf    # VirtualHost Apache (DocumentRoot en /public)
│   └── postgres/
│       └── init.sql            # Script DDL/DML de tablas y semillas iniciales
├── includes/
│   ├── config.php              # Constantes institucionales y parámetros de red
│   ├── db.php                  # Conector resiliente PDO PostgreSQL
│   ├── header.php              # Cabecera institucional con navegación
│   └── footer.php              # Pie de página y monitoreo de estado
└── public/
    ├── index.php               # Portal de acceso general
    ├── caja.php                # Terminal POS de ventas
    ├── proveedores.php         # Módulo contable de compras
    ├── reparto.php             # Control de rutas y despacho
    ├── dashboard.php           # Analítica ejecutiva para gerencia
    └── assets/
        └── css/custom.css      # Estilos personalizados y utilidades de impresión
```
