# Guía de Carga y Pruebas en Cisco Packet Tracer
## Sistema ERP Pan y Queque (Versión HTTP Nativa)

Este directorio contiene la versión estática y autónoma del ERP de **Panadería y Pastelería Pan y Queque**, adaptada específicamente para ejecutarse en el servidor **HTTP nativo de Cisco Packet Tracer**.

---

## 📁 Archivos Disponibles en este Directorio

| Archivo | Módulo Representado | Perfil / Segmento de Red Asociado |
| :--- | :--- | :--- |
| **`index.html`** | Portal Principal de la Intranet y Catálogo Maestro | Acceso general desde todas las terminales autorizadas |
| **`caja.html`** | Punto de Venta (POS), Boletas y Arqueo de Caja | **VLAN 20** (`2001:db8:acad:20::/64`) - Cajas y Mostrador |
| **`proveedores.html`** | Finanzas, Libro Mayor y Órdenes de Compra (PO) | **VLAN 10** (`2001:db8:acad:10::/64`) - Administración |
| **`reparto.html`** | Logística, Despacho HORECA y Cadena de Frío | **VPN Choferes** (`2001:db8:wan::100`) - Repartidores |
| **`dashboard.html`** | Dashboard Gerencial Confidencial y EBITDA | **VPN Gerencia** (`2001:db8:wan::200`) / **VLAN 30** |

---

## 🚀 Paso a Paso: Cómo Cargar los Archivos en Cisco Packet Tracer

### 1. Ubicar el Servidor Web Corporativo
1. Abra su topología en Cisco Packet Tracer (`Docs/PP2 REDES.pkt`).
2. Haga clic sobre el dispositivo **Server** asignado al ERP corporativo (Servidor Web en **VLAN 30**, dirección IPv6 `2001:db8:acad:30::80` / IPv4 `192.168.30.80`).

### 2. Acceder al Gestor de Archivos HTTP
1. En la ventana emergente del servidor, vaya a la pestaña **Services**.
2. En la barra lateral izquierda, seleccione el servicio **HTTP**.
3. Verifique que las opciones de **HTTP** y **HTTPS** estén seleccionadas en **On**.

### 3. Cargar los 5 Archivos HTML
Tiene dos opciones según la versión de Packet Tracer:

#### Opción A: Botón "Import" (Recomendada)
1. Presione el botón **Import** ubicado en la parte superior derecha de la lista de archivos.
2. Navegue hasta la carpeta del proyecto:
   ```
   /home/beto/Documentos/Proyectos/panyqueque_erp/pt_erp/
   ```
3. Seleccione e importe consecutivamente:
   - `index.html`
   - `caja.html`
   - `proveedores.html`
   - `reparto.html`
   - `dashboard.html`

#### Opción B: Crear Nuevo Archivo ("New File")
Si el diálogo de importación no está disponible:
1. Haga clic en **New File**.
2. En **File Name**, escriba el nombre exacto del archivo (ej. `index.html`).
3. Abra el archivo correspondiente de `/pt_erp/` en su editor de texto, copie todo su contenido y péguelo en el recuadro de texto de Packet Tracer.
4. Haga clic en **Save** y confirme el reemplazo si existía un archivo previo.
5. Repita este proceso para los 5 archivos.

---

## 🌐 Pruebas de Acceso, Navegación y Políticas de Red (ACL)

### 1. Acceso General al Portal de Intranet
Desde cualquier PC o Laptop de la red interna (VLAN 10, VLAN 20 o terminales con VPN activa):
1. Vaya a la pestaña **Desktop** &rarr; aplicación **Web Browser**.
2. En la barra de direcciones URL, ingrese:
   ```text
   http://[2001:db8:acad:30::80]/index.html
   ```
   *(o en IPv4: `http://192.168.30.80/index.html`)*
3. Deberá ver la portada institucional de **PAN Y QUEQUE** con sus 4 módulos operativos y el catálogo de panificación filtrable.

---

### 2. Pruebas por Módulo

- **Punto de Venta (`caja.html`):**
  - Haga clic en **Abrir Módulo de Caja**.
  - Agregue unidades de *Marraqueta*, *Empanadas* o *Tortas* al ticket de venta.
  - Compruebe cómo se calculan automáticamente el Subtotal, IVA (19%) y Total.
  - Seleccione la forma de pago y presione **EMITIR BOLETA Y COBRAR**.
  - Verifique que la boleta se agrega con su correlativo único (`BOL-004896`), descuenta el stock simulado y actualiza el arqueo de caja en vivo.

- **Proveedores & Finanzas (`proveedores.html`):**
  - Haga clic en **Gestionar Proveedores**.
  - Revise el estado de pasivos de materias primas ($28.150.000).
  - Emita una nueva Orden de Compra (PO) seleccionando a *Harina Los Andes S.A.* o *Lácteos del Sur SpA*.
  - Compruebe que la orden se añade al registro histórico con folio `PO-2026-017` y actualiza el pasivo en el DOM.

- **Logística & Despachos (`reparto.html`):**
  - Haga clic en **Ver Hojas de Reparto**.
  - Revise la telemetría de frío (+3.8°C) y las rutas de los furgones.
  - En las rutas con estado *En camino* o *Pendiente*, haga clic en **Confirmar Entrega**.
  - Verifique que el estado cambia inmediatamente a **✓ ENTREGADO** y aumenta el contador de cumplimiento de la flota.

- **Dashboard Gerencial (`dashboard.html`):**
  - Haga clic en **Abrir Dashboard Gerencial**.
  - Compruebe la visualización de la alerta roja de confidencialidad, el desglose EBITDA operativo y el Top 5 de productos más vendidos.

---

### 3. Prueba de Seguridad Perimetral y Filtrado por ACL

El proyecto incluye listas de control de acceso IPv6 configuradas en el Router R1 (`comandos.txt`):

```cisco
ipv6 access-list ACL_PERFIL_CHOFERES
 permit tcp host 2001:db8:wan::100 host 2001:db8:acad:30::80 eq 80
 permit tcp host 2001:db8:wan::100 host 2001:db8:acad:30::80 eq 443
 deny ipv6 host 2001:db8:wan::100 2001:db8:acad::/48
 permit ipv6 any any
```

#### Cómo forzar el bloqueo (Request Timeout) para Choferes:
1. En `index.html`, ubique la tarjeta del **Dashboard Gerencial**.
2. Cambie el hipervínculo según el comentario predeterminado en el código:
   ```html
   <!-- Cambiar: -->
   <a href="dashboard.html" class="btn btn-warning">Abrir Dashboard Gerencial &rarr;</a>

   <!-- Por: -->
   <a href="http://[2001:db8:acad:30::db]/dashboard.html" class="btn btn-warning">Abrir Dashboard Gerencial &rarr;</a>
   ```
3. Si la terminal del Chofer (`2001:db8:wan::100`) intenta acceder al Dashboard en el servidor de base de datos (`2001:db8:acad:30::db`), la regla `deny ipv6 host 2001:db8:wan::100 2001:db8:acad::/48` descartará los paquetes TCP SYN, produciendo el mensaje de **Request Timeout** en Packet Tracer, validando con éxito la política de seguridad perimetral.

