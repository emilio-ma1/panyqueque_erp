# Manual de Usuario - Sistema ERP Pan y Queque

Guía completa de uso y operación para el sistema ERP de **Panadería y Pastelería Pan y Queque**. Este documento explica el funcionamiento de cada módulo, roles de usuario, flujo de transacciones e instrucciones paso a paso para el uso diario.

---

## 📋 Tabla de Contenidos

1. [Inicio Rápido y Despliegue](#1-inicio-rápido-y-despliegue)
2. [Cuentas de Acceso y Control de Roles (RBAC)](#2-cuentas-de-acceso-y-control-de-roles-rbac)
3. [Módulo 01: Portal Principal y Catálogo Maestro](#3-módulo-01-portal-principal-y-catálogo-maestro)
4. [Módulo 02: Punto de Venta (POS) y Cajas](#4-módulo-02-punto-de-venta-pos-y-cajas)
5. [Módulo 03: Proveedores y Finanzas](#5-módulo-03-proveedores-y-finanzas)
6. [Módulo 04: Logística y Rutas de Despacho HORECA](#6-módulo-04-logística-y-rutas-de-despacho-horeca)
7. [Módulo 05: Dashboard Ejecutivo y Auditoría](#7-módulo-05-dashboard-ejecutivo-y-auditoría)
8. [Administración de Base de Datos y Semillas](#8-administración-de-base-de-datos-y-semillas)
9. [Preguntas Frecuentes y Solución de Problemas](#9-preguntas-frecuentes-y-solución-de-problemas)

---

## 1. Inicio Rápido y Despliegue

### Requisitos Previos
- Docker Desktop instalado y en ejecución.

### Pasos para iniciar el sistema:
1. Abra su terminal en la carpeta raíz del proyecto.
2. Inicie los contenedores Docker:
   ```bash
   docker compose up -d
   ```
3. Abra su navegador web en:
   👉 **[http://localhost:8080](http://localhost:8080)**

---

## 2. Cuentas de Acceso y Control de Roles (RBAC)

El ERP cuenta con **seguridad perimetral basada en roles**. Cada usuario tiene acceso únicamente a los módulos pertinentes a su función operativa.

| Usuario | Contraseña | Rol Institucional | Módulos Autorizados |
| :--- | :--- | :--- | :--- |
| `gerente` | `admin123` | **Gerente General** | Acceso total a todos los módulos |
| `cajero` | `caja123` | **Cajero de Mostrador** | Portal Principal, Punto de Venta (POS) y Arqueo |
| `finanzas` | `finanzas123` | **Jefe de Finanzas** | Portal Principal, Proveedores & Libro Mayor, Dashboard |
| `chofer` | `chofer123` | **Chofer de Reparto** | Portal Principal, Logística & Rutas de Despacho |

> **Tip de Acceso Rápido:** En la pantalla de Login ([http://localhost:8080/login.php](http://localhost:8080/login.php)) encontrará botones de **Acceso Rápido 1-Click** para iniciar sesión inmediatamente con cualquiera de las cuentas de prueba.

---

## 3. Módulo 01: Portal Principal y Catálogo Maestro

**URL:** `http://localhost:8080/index.php`  
**Acceso:** Todos los roles autenticados.

### Funcionalidades:
- **Vista Panorámica del Obrador:** Muestra la capacidad operativa diaria, lotes en maduración en cámaras frías a 4°C y pedidos HORECA activos.
- **Acceso Directo:** Enlaces rápidos a cada subsistema según los permisos del usuario.
- **Catálogo de Producción:** Muestra todos los productos disponibles con su categoría, precio unitario en pesos chilenos (CLP) y stock disponible en tiempo real en la base de datos MariaDB.
- **Filtros por Categoría:** Filtre rápidamente entre `[TODOS]`, `[PANADERÍA]`, `[PASTELERÍA]` y `[ROTISERÍA & SALADOS]`.

---

## 4. Módulo 02: Punto de Venta (POS) y Cajas

**URL:** `http://localhost:8080/pos.php`  
**Roles Autorizados:** `gerente`, `cajero`.

### Paso a paso para realizar una venta:
1. **Seleccionar Productos:** En la pantalla táctil izquierda, haga clic sobre los productos para añadirlos al ticket. Cada clic suma una unidad.
2. **Ajustar Cantidades:** En el panel derecho (*Ticket de Venta*), use los botones `+` o `-` para modificar la cantidad, o la papelera para quitar un ítem.
3. **Elegir Método de Pago:** Seleccione entre:
   - `Efectivo`
   - `Tarjeta Débito`
   - `Transferencia`
4. **Completar la Venta:** Presione el botón **Completar Venta y Cobrar**.
5. **Comportamiento automático del sistema:**
   - Asigna un número de folio correlativo único (ej. `BOL-000446`).
   - Calcula el Subtotal Neto y el IVA (19%).
   - Descuenta automáticamente el stock de los productos vendidos en MariaDB.
   - Registra el evento en la bitácora de auditoría.
   - Limpia el ticket para la siguiente atención.

### Realizar Arqueo y Cuadratura de Caja:
1. En la barra superior del POS, haga clic en el botón **Arqueo de Caja**.
2. Se abrirá una ventana modal con:
   - Fondo inicial de caja base.
   - Total de ventas del día actual desglosadas por Efectivo, Tarjeta Débito y Transferencia.
   - Total recaudado en el turno.
3. Puede imprimir el reporte de cuadratura presionando **Imprimir Cuadratura**.

---

## 5. Módulo 03: Proveedores y Finanzas

**URL:** `http://localhost:8080/suppliers.php`  
**Roles Autorizados:** `gerente`, `finanzas`.

### Funcionalidades:
- **Métricas de Pasivos:** Tarjetas con el total de *Cuentas por Pagar (AP)*, *Cuentas por Cobrar (AR)* y el *Balance General*.
- **Lista de Proveedores Homologados:** Control de empresas proveedoras (Harinas, Mantequillas, Azúcares, Levaduras, Coberturas de Chocolate) con su RUT, contacto y estado de cuenta (*Al día*, *Pendiente*, *En proceso*).

### Paso a paso para emitir una Orden de Compra (PO):
1. Haga clic en el botón negro superior **+ Nueva Orden de Compra (PO)** (o en el botón *Emitir Orden* en la fila del proveedor correspondiente).
2. Complete el formulario modal:
   - **Proveedor Homologado:** Seleccione la empresa (ej. *Harina Los Andes S.A.*).
   - **Monto Bruto Total (CLP):** Ingrese el monto en pesos (ej. `2500000`).
   - **Detalle de Insumos y Observaciones:** Especifique el pedido (ej. `50 sacos Harina Flor Especial 50kg en andén de descarga`).
3. Presione **Emitir Orden en BD**.
4. **Impacto en el sistema:**
   - Se crea el registro en la tabla `purchase_orders` con folio `PO-2026-XXX`.
   - Se actualiza el volumen de compras acumulado del proveedor y su última fecha de compra.
   - El monto pasa a sumar al pasivo corriente (*Cuentas por Pagar*).

---

## 6. Módulo 04: Logística y Rutas de Despacho HORECA

**URL:** `http://localhost:8080/dispatch.php`  
**Roles Autorizados:** `gerente`, `chofer`.

### Monitoreo de Rutas:
Permite llevar la trazabilidad de entregas a hoteles, casinos, hospitales, cafeterías y sucursales propias con control estricto de cadena de frío (+3.8°C).

### Paso a paso para programar una nueva ruta:
1. En la parte superior, presione el botón color ámbar **+ Programar Nueva Ruta**.
2. Complete los campos del formulario:
   - **Horario Estimado:** ej. `08:30 AM`.
   - **Tipo de Cliente:** Restaurantes & Cafés, Hoteles & Eventos, Hospitalario, Sucursales, Supermercados.
   - **Título de la Ruta:** ej. `Ruta 05 - Reparto Cafeterías Casco Histórico`.
   - **Cliente / Destino:** ej. `Café Colonial La Serena`.
   - **Conductor Asignado:** Seleccione a *Carlos Mendoza* (Furgón 01 Frío) o *Juan Pablo Riquelme* (Furgón 02 Seco).
   - **Dirección de Entrega:** ej. `Prat 420, La Serena`.
   - **Detalle de Carga:** ej. `50 kg Marraqueta, 25 Baguettes, 10 Tortas Ópera`.
   - **Observaciones:** Instrucciones particulares o rango térmico.
3. Presione **Guardar y Programar Ruta**. Aparecerá en la tabla como estado **Pendiente** (⏳).

### Paso a paso para liquidar / confirmar una entrega:
1. En la tabla de rutas, ubique el albarán correspondiente y haga clic en **Confirmar Entrega**.
2. Ingrese el **Nombre de Quien Recibe** (ej. `Camila Morales (Jefa de Bodega)`).
3. Indique las observaciones de temperatura o conformidad (ej. `Recepcionado conforme a +3.8°C`).
4. Presione **Registrar Entrega**.
5. La ruta cambiará inmediatamente a estado **Entregado** con el distintivo verde **✓ RECIBIDO**.

---

## 7. Módulo 05: Dashboard Ejecutivo y Auditoría

**URL:** `http://localhost:8080/dashboard.php`  
**Roles Autorizados:** `gerente`, `finanzas`.

### Selectores de Período:
- **HOY • TIEMPO REAL:** Muestra la facturación neta, boletas emitidas y ticket promedio generados durante el día en curso (Noviembre 2026).
- **7 DÍAS:** Muestra el rendimiento acumulado de los últimos 7 días con gráfico comparativo de ingresos vs costes operativos.
- **MES EN CURSO:** Muestra el consolidado de los últimos 30 días auditados (Octubre completo + lo acumulado de Noviembre).

### Principales Métricas e Informes:
1. **Tarjetas KPI:** Facturación Neta, Ticket Promedio, Margen Bruto de Explotación (Target > 35%) y Cuentas por Pagar.
2. **Gráfico Semanal de Barras:** Comparativa de Ingresos Brutos vs Costes Operativos Directos por cada día de la semana.
3. **Estado de Resultados Operativo (EBITDA):** Desglose de ingresos brutos menos costos de harinas/insumos (31.6%), nómina de obrador (24.0%) y consumo energético de hornos (10.0%).
4. **Top 5 Productos más Vendidos:** Ranking ordenado por ingresos y unidades comercializadas (calculado directamente desde la base de datos).
5. **Consola de Auditoría en Vivo:** Registro cronológico de todas las acciones del sistema con módulo, acción, detalle, IP y marca de tiempo.

---

## 8. Administración de Base de Datos y Semillas

### Reiniciar la Base de Datos con el Dataset Oficial:
Si en algún momento desea reiniciar los datos a su estado original (Octubre 2026 completo con actividades pasadas y Noviembre 2026 vacío):

```bash
docker exec panyqueque_erp_web php scripts/seed_database.php
```

### Ejecutar Pruebas Automatizadas de Calidad (QA):
Para validar la integridad de los servicios de dominio, cálculos monetarios y reglas de acceso RBAC:

```bash
docker exec panyqueque_erp_web php tests/run_tests.php
```

### Acceso a MariaDB por Terminal:
```bash
docker exec -it panyqueque_erp_db mariadb -u erp_user -perp_password_2026 panyqueque_erp
```

---

## 9. Preguntas Frecuentes y Solución de Problemas

#### ¿Por qué el Dashboard en "HOY • TIEMPO REAL" muestra $0?
Porque Noviembre 2026 se dejó limpio intencionalmente. En cuanto emita su primera venta en el [Punto de Venta (POS)](http://localhost:8080/pos.php), verá cómo el Dashboard se actualiza automáticamente con la venta en vivo.

#### ¿Cómo cerrar sesión o cambiar de usuario?
En la esquina superior derecha de cualquier pantalla, haga clic en el botón con el icono de usuario o **Cerrar Sesión** (`/logout.php`), lo que lo devolverá a la pantalla de login para ingresar con otro rol.

#### ¿Dónde se configuran las credenciales de la base de datos?
Todas las variables de entorno se definen en el archivo [`.env`](../.env) en la raíz del proyecto.
