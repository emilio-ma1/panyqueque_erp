# QA-STD-001 · Estándar General de Construcción y Codificación de Software

> **Código Normativo:** QA-STD-001  
> **Versión Vigente:** v2.0 (General / Multi-stack)  
> **Propietario:** Área de Aseguramiento de Calidad de Software (QA / SQA)  
> **Aprobación Técnica:** Responsable de Ingeniería y Arquitectura de Software  
> **Ámbito de Aplicación:** Proyectos de Desarrollo de Software, Servicios Web, APIs, Frontend y Aplicaciones Empresariales  

---

## Índice General

1. [Objetivo, Alcance y Principios Rectores](#1-objetivo-alcance-y-principios-rectores)
   - 1.1 [Objetivo](#11-objetivo)
   - 1.2 [Alcance](#12-alcance)
   - 1.3 [Principios Rectores de Ingeniería de Software](#13-principios-rectores-de-ingeniería-de-software)
   - 1.4 [Métricas Críticas de Calidad y Reglas Duras (Hard Rules)](#14-métricas-críticas-de-calidad-y-reglas-duras-hard-rules)
2. [Clasificación y Mecanismos de Control](#2-clasificación-y-mecanismos-de-control)
3. [Reglas Generales de Calidad de Código](#3-reglas-generales-de-calidad-de-código)
4. [Lógica de Aplicación y Backend (Agnóstico de Lenguaje)](#4-lógica-de-aplicación-y-backend-agnóstico-de-lenguaje)
   - 4.1 [Convenciones de Nomenclatura y Contratos de Tipado](#41-convenciones-de-nomenclatura-y-contratos-de-tipado)
   - 4.2 [Manejo Estructurado de Errores y Excepciones](#42-manejo-estructurado-de-errores-y-excepciones)
   - 4.3 [Modularidad y Control de Flujo](#43-modularidad-y-control-de-flujo)
   - 4.4 [Recomendaciones de Arquitectura](#44-recomendaciones-de-arquitectura)
5. [Persistencia y Gestión de Bases de Datos](#5-persistencia-y-gestión-de-bases-de-datos)
   - 5.1 [Conexiones y Mínimo Privilegio](#51-conexiones-y-mínimo-privilegio)
   - 5.2 [Consultas Parametrizadas y Prevención de Inyecciones](#52-consultas-parametrizadas-y-prevención-de-inyecciones)
   - 5.3 [Transacciones ACID e Integridad](#53-transacciones-acid-e-integridad)
   - 5.4 [Convenciones SQL y Modelado de Datos](#54-convenciones-sql-y-modelado-de-datos)
6. [Frontend e Interfaces de Usuario](#6-frontend-e-interfaces-de-usuario)
   - 6.1 [Estructura y HTML Semántico](#61-estructura-y-html-semántico)
   - 6.2 [Estilos y Diseño Adaptable (CSS)](#62-estilos-y-diseño-adaptable-css)
   - 6.3 [Lógica de Cliente y Estado](#63-lógica-de-cliente-y-estado)
7. [Entornos, Contenedores y Configuración Operacional](#7-entornos-contenedores-y-configuración-operacional)
   - 7.1 [Contenedorización (Docker / OCI)](#71-contenedorización-docker--oci)
   - 7.2 [Servidores Web, Proxies Inversos y Transporte](#72-servidores-web-proxies-inversos-y-transporte)
   - 7.3 [Gestión de Configuración y Secretos (Twelve-Factor App)](#73-gestión-de-configuración-y-secretos-twelve-factor-app)
8. [Seguridad de la Aplicación (Alineada con OWASP Top 10)](#8-seguridad-de-la-aplicación-alineada-con-owasp-top-10)
9. [Control de Versiones: Git y Flujo de Integración](#9-control-de-versiones-git-y-flujo-de-integración)
10. [Criterios Mínimos antes del Pull Request (QA Quality Gate)](#10-criterios-mínimos-antes-del-pull-request-qa-quality-gate)
11. [Verificación y Límites del Estándar](#11-verificación-y-límites-del-estándar)
    - 11.1 [Mecanismos de Verificación](#111-mecanismos-de-verificación)
    - 11.2 [Límites y Autonomía de los Equipos Técnicos](#112-límites-y-autonomía-de-los-equipos-técnicos)

---

## 1. Objetivo, Alcance y Principios Rectores

### 1.1 Objetivo
Establecer, formalizar y unificar los criterios obligatorios y las buenas prácticas de construcción, diseño y revisión de software. El propósito fundamental es garantizar la **consistencia, mantenibilidad, seguridad perimetral, legibilidad y testeabilidad** de los sistemas desarrollados, facilitando revisiones de código objetivas y reduciendo la deuda técnica.

### 1.2 Alcance
Este estándar aplica de forma transversal a **todos los proyectos de desarrollo de software** que involucren:
- Lógica de backend (APIs RESTful, microservicios, servicios monolíticos o scripts operacionales, sin importar el lenguaje de programación: TypeScript, JavaScript, Python, PHP, Go, C#, Java, etc.).
- Capas de persistencia de datos (bases de datos relacionales SQL y motores NoSQL).
- Interfaces de usuario frontend (aplicaciones web, plantillas renderizadas en servidor o arquitecturas SPA).
- Infraestructura de despliegue contenerizada (Docker, Docker Compose, Kubernetes) y servidores web/proxies inversos.
- Gestión de control de versiones y ciclo de integración en Git y plataformas colaborativas (GitHub, GitLab, Bitbucket).

### 1.3 Principios Rectores de Ingeniería de Software
1. **Clean Code (Código Limpio):** El código debe escribirse para ser leído por humanos primero y ejecutado por computadoras después. La claridad precede al artificio.
2. **SOLID:** Responsabilidad única (SRP), abierto/cerrado (OCP), sustitución de Liskov (LSP), segregación de interfaces (ISP) e inversión de dependencias (DIP).
3. **DRY (Don't Repeat Yourself):** Cada porción de conocimiento o lógica de negocio debe tener una representación única, inequívoca y autorizada dentro del sistema.
4. **KISS (Keep It Simple, Stupid):** Evitar sobreingeniería, patrones innecesarios y optimizaciones prematuras.
5. **Defensa en Profundidad y Mínimo Privilegio:** Ninguna capa confía ciegamente en otra; cada proceso, servicio y credencial debe disponer estrictamente de los permisos indispensables para su función.

### 1.4 Métricas Críticas de Calidad y Reglas Duras (Hard Rules)
Para asegurar el rigor del proceso de construcción de software y garantizar la superación de las compuertas de calidad (Quality Gates) en revisiones por pares y pipelines de integración, se establecen como innegociables las siguientes directrices y umbrales cuantitativos:

- **Complejidad Ciclomática:** $M \le 10$ por función/método (`STD-COD-007`).
- **Profundidad de Anidación:** Máximo 2 niveles de anidación condicional o bucles (`max nesting <= 2`).
- **Longitud de Rutinas:** Límite de 30 a 50 líneas efectivas de código.
- **Protocolo de Documentación Formal (Docstrings):** Obligatoriedad de bloques con `@param`, `@return` y `@throws` (`STD-COD-008`).
- **Idioma de Construcción:** Nombres de código, tablas y mensajes de commit en inglés técnico (`STD-COD-009`).
- **Arquitectura Web:** Thin Controllers (controladores delgados) y Domain Services desacoplados (`STD-COD-010`).
- **Cobertura Mínima de Pruebas Unitarias:** Mínimo 70% de cobertura sobre lógica de negocio y servicios de dominio.

---

## 2. Clasificación y Mecanismos de Control

Las directrices de este estándar se clasifican en dos niveles normativos:

| Categoría | Nivel de Cumplimiento | Impacto en la Revisión |
| :--- | :--- | :--- |
| **Regla Obligatoria (STD-*)** | Cumplimiento mandatorio e innegociable. | Su incumplimiento genera observaciones bloqueantes e impide la aprobación del Pull Request. |
| **Recomendación de Ingeniería** | Práctica técnicamente conveniente y sugerida. | No bloquea por sí sola un Pull Request, pero promueve la excelencia técnica del equipo. |

### Mecanismos Oficiales de Control
- **Manual (Code Review):** Exige revisión y validación humana por parte de un par técnico o revisor asignado.
- **Automatizable:** Control susceptible de ser verificado mediante linters, analizadores estáticos de código (SAST), formateadores o pipelines de CI/CD.
- **Manual / Automatizable:** Control híbrido respaldado por herramientas automáticas pero auditado en última instancia por el revisor técnico.

---

## 3. Reglas Generales de Calidad de Código

| ID | Regla Obligatoria | Control |
| :--- | :--- | :--- |
| **STD-GEN-001** | **Uniformidad de Formato e Indentación:** Un mismo archivo y módulo debe mantener una convención uniforme de indentación, uso de llaves, espacios y saltos de línea. Está terminantemente prohibido mezclar tabuladores y espacios para la indentación en un mismo archivo. | Manual / Automatizable |
| **STD-GEN-002** | **Prohibición de Código Muerto y Depuración:** No deben subirse ni integrarse fragmentos de código comentado sin uso, archivos temporales, volcados de memoria, volcados de depuración (ej. `console.log`, `var_dump`, `print_r`, `print` de depuración o llamadas a `exit/die` informales), ni textos de prueba visibles al usuario. | Manual / Automatizable |
| **STD-GEN-003** | **Comentarios de Intención y Valor:** Los comentarios deben explicar *por qué* se toma una decisión no evidente, una restricción arquitectónica o un motivo de negocio; nunca deben limitarse a parafrasear o repetir lo que el código ya expresa explícitamente. | Manual |
| **STD-GEN-004** | **Trazabilidad de Deuda Técnica (TODO / FIXME):** Todo marcador `TODO` o `FIXME` que permanezca integrado en una rama compartida debe describir con precisión la acción técnica pendiente y hacer referencia al identificador del ticket o issue asociado. No se toleran marcadores vacíos o sin contexto. | Manual / Automatizable |
| **STD-GEN-005** | **Modularidad y Reutilización (DRY):** No debe duplicarse el mismo bloque de lógica de negocio o validación de datos en múltiples ubicaciones cuando pueda encapsularse en una función, método o servicio reutilizable sin introducir acoplamiento artificial. | Manual |
| **STD-GEN-006** | **Externalización de Parámetros de Entorno:** Ningún valor que varíe entre ambientes (URLs, hosts, puertos, flags de entorno, certificados) debe quedar cableado (*hardcoded*) directamente en el código fuente; debe resolverse mediante el mecanismo centralizado de configuración del proyecto. | Manual / Automatizable |
| **STD-GEN-007** | **Codificación Universal UTF-8:** Todos los archivos fuente, plantillas, scripts de migración y archivos de configuración textual deben crearse y versionarse en codificación **UTF-8 sin BOM**. La aplicación debe asegurar UTF-8 en la capa de datos y en las respuestas enviadas al cliente. | Manual / Automatizable |
| **STD-GEN-008** | **Bitácora Estructurada y Protección de Datos Sensibles en Logs:** Todo proyecto debe contar con un mecanismo formal de registro de eventos y errores técnicos. Los logs **jamás deben contener** contraseñas, tokens de autenticación, llaves criptográficas privadas, identificadores de sesión, números de tarjetas de crédito ni datos personales innecesarios. Cuando un dato sensible sea estrictamente indispensable para el diagnóstico, debe enmascararse. | Manual / Automatizable |

---

## 4. Lógica de Aplicación y Backend (Agnóstico de Lenguaje)

### 4.1 Convenciones de Nomenclatura y Contratos de Tipado

| ID | Regla Obligatoria | Control |
| :--- | :--- | :--- |
| **STD-COD-001** | **Nomenclatura Semántica y Descriptiva:** Los identificadores deben reflejar con claridad su propósito funcional. Clases, tipos, interfaces y estructuras de datos deben nombrarse en `PascalCase`. Funciones, métodos y variables deben utilizar la convención predominante del ecosistema (`camelCase` o `snake_case`) de manera consistente en todo el repositorio. Las constantes globales y enumeraciones fijas deben nombrarse en `UPPER_SNAKE_CASE`. | Manual / Automatizable |
| **STD-COD-002** | **Contratos de Tipado Explícitos:** En código nuevo o refactorizado, declarar explícitamente los tipos de datos de los parámetros de entrada y valores de retorno cuando el lenguaje lo admita (o utilizar herramientas de tipado como TypeScript, Type Hints, etc.). Prohibido declarar tipos comodín (como `any` o equivalentes no supervisados) para evadir verificaciones estáticas. | Manual / Automatizable |
| **STD-COD-003** | **Tratamiento Seguro de Nulos y Opcionales:** Si un valor puede ser nulo o indefinido, debe declararse expresamente mediante tipos opcionales/anulables. Se debe validar su existencia antes de acceder a sus propiedades o métodos subordinados para prevenir excepciones de referencia nula en tiempo de ejecución. | Manual / Automatizable |
| **STD-COD-004** | **Comparaciones Estrictas:** Utilizar operadores de comparación estricta de tipo y valor (ej. `===`, `!==` o métodos de igualdad explícita) en lugar de comparaciones que apliquen coerción implícita de tipos, salvo que la conversión automática esté plenamente justificada y documentada. | Manual / Automatizable |

### 4.2 Manejo Estructurado de Errores y Excepciones

| ID | Regla Obligatoria | Control |
| :--- | :--- | :--- |
| **STD-COD-005** | **Prohibición de Captura Silenciosa:** Queda terminantemente prohibido utilizar bloques de captura de excepciones (`try/catch`) vacíos o que ignoren el error sin acción. Cuando una excepción no pueda ser subsanada localmente, debe registrarse con contexto suficiente mediante el logger del sistema y transformarse o relanzarse hacia capas superiores. | Manual / Automatizable |
| **STD-COD-006** | **Hermetismo de Trazas Técnicas en Respuestas:** Las trazas internas del sistema (`stack traces`), rutas del sistema de archivos, consultas SQL internas o credenciales nunca deben ser expuestas al cliente final o consumidor de la API. El cliente debe recibir un mensaje de error controlado con un código de estado adecuado (ej. HTTP 400, 404, 500), mientras que el detalle técnico exhaustivo debe quedar registrado en el log del servidor. | Manual / Automatizable |

| **STD-COD-007** | **Límites de Complejidad Ciclomática y Anidación (Hard Rules):** Toda función o método debe mantener una complejidad ciclomática máxima de 10 ($M \le 10$). Queda estrictamente prohibido anidar más de dos (2) niveles de estructuras de control o bucles (`max nesting <= 2`). La longitud de funciones no debe exceder las 30 a 50 líneas efectivas de código para preservar su legibilidad. | Manual / Automatizable |
| **STD-COD-008** | **Protocolo Formal de Documentación (Docstrings):** Toda función, método y clase pública debe contar con un bloque de documentación formal (Docstring / JSDoc / Docblock) que describa su propósito, declare los tipos y nombres de cada parámetro (`@param`), el valor de retorno (`@return`) y las excepciones que puede propagar (`@throws`). | Manual / Automatizable |
| **STD-COD-009** | **Idioma de Construcción en Inglés Técnico:** La nomenclatura técnica del código fuente (clases, funciones, variables, métodos, constantes), los nombres de tablas y columnas en bases de datos, y los mensajes de commit deben redactarse en **inglés técnico** consistente (respetando `snake_case` en bases de datos y `camelCase`/`PascalCase` en código). Los textos en español quedan reservados exclusivamente para la interfaz gráfica y contenidos dirigidos al usuario final. | Manual / Automatizable |
| **STD-COD-010** | **Controladores Delgados y Servicios de Dominio (Thin Controllers):** En arquitecturas web y APIs, los controladores deben ser estrictamente delgados (*Thin Controllers*), restringiéndose a recibir la petición HTTP, verificar autorización, validar la entrada y despachar la respuesta. La lógica de negocio, validaciones complejas y cálculos financieros/operacionales deben residir en servicios de dominio (*Domain Services*) desacoplados y fácilmente testeables. | Manual |

### 4.3 Modularidad y Control de Flujo
- **Retorno Temprano (Guard Clauses):** Preferir validar condiciones de fallo al inicio de las funciones y retornar inmediatamente (`early return`), evitando niveles excesivos de anidación condicional (`if/else` piramidales).
- **Funciones de Responsabilidad Única:** Los métodos y funciones deben realizar una única tarea conceptual. Si una rutina realiza validación, transformación de datos, persistencia en base de datos y envío de correos, debe descomponerse en servicios desacoplados.

---

## 5. Persistencia y Gestión de Bases de Datos

### 5.1 Conexiones y Mínimo Privilegio

| ID | Regla Obligatoria | Control |
| :--- | :--- | :--- |
| **STD-DB-001** | **Gestión Eficiente de Conexiones:** No debe abrirse ni cerrarse una nueva conexión física a la base de datos por cada consulta unitaria. Se debe utilizar un pool de conexiones gestionado o un patrón singleton controlado, reutilizando la instancia durante el ciclo de vida del flujo o petición. | Manual |
| **STD-DB-002** | **Principio de Mínimo Privilegio en Cuentas de Acceso:** La cuenta de base de datos que utiliza la aplicación en su operación regular no debe poseer privilegios de superusuario (`root`, `postgres`, `sa`) ni facultades DDL sobre el esquema en caliente (crear o eliminar tablas). Los cambios de esquema y migraciones deben ejecutarse bajo un usuario o pipeline administrativo separado. | Manual |
| **STD-DB-003** | **Segregación de Credenciales de Conexión:** Las credenciales de base de datos (host, puerto, nombre del esquema, usuario y contraseña) deben suministrarse estrictamente mediante variables de entorno del sistema. Jamás deben incrustarse en el código fuente, archivos versionados ni imágenes de contenedor. | Manual / Automatizable |

### 5.2 Consultas Parametrizadas y Prevención de Inyecciones

| ID | Regla Obligatoria | Control |
| :--- | :--- | :--- |
| **STD-DB-004** | **Consultas Parametrizadas Obligatorias:** Todo valor proveniente del exterior (usuarios, clientes API, parámetros de consulta, archivos o fuentes no confiables) que deba incorporarse en una consulta SQL debe enviarse exclusivamente mediante **consultas preparadas y parámetros enlazados** (prepared statements). Queda estrictamente prohibida la concatenación o interpolación directa de cadenas en sentencias SQL. | Manual / Automatizable |
| **STD-DB-005** | **Listas Blancas para Identificadores Dinámicos:** Dado que los motores de base de datos no permiten enlazar nombres de tablas, columnas o cláusulas (`ORDER BY ASC/DESC`) como parámetros, cualquier identificador dinámico debe validarse contra una **lista blanca cerrada** (*allowlist*) definida rígidamente en el código. Nunca permitir que el cliente decida arbitrariamente nombres de columnas o tablas. | Manual |

### 5.3 Transacciones ACID e Integridad

| ID | Regla Obligatoria | Control |
| :--- | :--- | :--- |
| **STD-DB-006** | **Garantía Transaccional Atómica:** Toda operación de negocio que involucre dos o más modificaciones dependientes en la base de datos debe ejecutarse dentro de una transacción explícita (`begin`, `commit`, `rollback`). El rollback debe garantizarse de forma automática ante cualquier excepción o fallo imprevisto. | Manual |
| **STD-DB-007** | **Restricciones de Integridad en el Motor:** Las invariantes de dominio (claves foráneas, unicidad, checks de valor y estados no nulos) deben declararse a nivel de motor relacional y no delegarse exclusivamente a validaciones en la capa de software. | Manual |

### 5.4 Convenciones SQL y Modelado de Datos
- **Proyección Explícita de Columnas:** Evitar el uso de `SELECT *` en consultas de aplicación. Se deben enumerar explícitamente las columnas necesarias para minimizar la sobrecarga de I/O de red y memoria.
- **Auditoría Temporal y Zonas Horarias:** Para el registro de marcas de tiempo de auditoría (`created_at`, `updated_at`), utilizar tipos de datos con soporte explícito de zona horaria (ej. `TIMESTAMP WITH TIME ZONE` o instantes UTC en formato ISO 8601).

---

## 6. Frontend e Interfaces de Usuario

### 6.1 Estructura y HTML Semántico

| ID | Regla Obligatoria | Control |
| :--- | :--- | :--- |
| **STD-UI-001** | **Estructura Estándar y Doctype:** Todo documento web completo debe declarar `<!doctype html>`, especificar el atributo de idioma `<html lang="...">` y configurar `<meta charset="UTF-8">`. | Manual / Automatizable |
| **STD-UI-002** | **Semántica y Jerarquía de Contenidos:** Utilizar los elementos estructurales nativos de HTML5 (`<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<footer>`) en lugar de estructuras genéricas basadas únicamente en `<div>`. La jerarquía de encabezados (`<h1>` a `<h6>`) debe ser lógica y no saltarse niveles conceptuales. | Manual / Automatizable |
| **STD-UI-003** | **Accesibilidad Universal (A11y):** Los controles de formulario deben poseer una etiqueta `<label>` asociada programáticamente (mediante `for` o anidamiento). Las imágenes informativas deben tener un atributo `alt` descriptivo. Los elementos interactivos deben poder operarse mediante navegación por teclado y el foco visual nunca debe eliminarse sin proveer un reemplazo accesible. | Manual / Automatizable |
| **STD-UI-004** | **Identificadores Únicos:** Todo atributo `id` en el DOM debe ser estrictamente único dentro del documento. Los atributos generados dinámicamente deben sanearse y escaparse adecuadamente. | Manual / Automatizable |

### 6.2 Estilos y Diseño Adaptable (CSS)

| ID | Regla Obligatoria | Control |
| :--- | :--- | :--- |
| **STD-UI-005** | **Separación Estricta de Presentación:** Los estilos visuales deben residir en hojas de estilo o sistemas de diseño centralizados. Prohibido el uso de estilos en línea (`style="..."`) salvo casos técnicos excepcionales y documentados (ej. valores de cálculo dinámico absoluto). | Manual / Automatizable |
| **STD-UI-006** | **Prohibición del Abuso de `!important`:** No debe utilizarse `!important` como mecanismo habitual para forzar la especificidad de selectores en cascada. | Manual / Automatizable |
| **STD-UI-007** | **Diseño Responsivo sin Desbordamiento:** Las interfaces deben adaptarse a los dispositivos y resoluciones objetivo del proyecto. Queda prohibido introducir desbordamientos horizontales accidentales (*horizontal scrolling*) en pantallas reducidas. | Manual |
| **STD-UI-008** | **Uso de Unidades Relativas:** Preferir el uso de unidades relativas (`rem`, `em`, `%`, `vh/vw`) para tipografías, espaciados y rejillas de contenido, permitiendo la correcta adaptación a las preferencias de zoom del usuario. | Manual |

### 6.3 Lógica de Cliente y Estado
- **Sanitización del DOM:** Nunca insertar contenido HTML externo no confiable mediante propiedades inseguras (ej. `innerHTML`) sin sanitización previa a través de librerías confiables (como DOMPurify) o usando `textContent` para valores de texto plano.
- **Manejo Asíncrono Resiliente:** Toda llamada asíncrona a APIs externas (HTTP/Fetch) debe gestionar los tres estados del ciclo: carga (*loading*), éxito (*success*) y error controlado con notificación clara al usuario.

---

## 7. Entornos, Contenedores y Configuración Operacional

### 7.1 Contenedorización (Docker / OCI)

| ID | Regla Obligatoria | Control |
| :--- | :--- | :--- |
| **STD-OPS-001** | **Fijación de Versiones de Imágenes Base:** En los archivos `Dockerfile` y `docker-compose.yml`, las imágenes base deben fijar versiones específicas reconocidas (ej. `alpine:3.19`, `node:20-alpine`, `mariadb:10.11`). Queda **estrictamente prohibido** el uso del tag genérico `:latest` en entornos de desarrollo compartido y producción. | Manual / Automatizable |
| **STD-OPS-002** | **Construcciones Limpias y Principio de Imagen Mínima:** El `Dockerfile` debe contener exclusivamente las instrucciones indispensables para empaquetar y ejecutar la aplicación. Se deben emplear construcciones multietapa (*multi-stage builds*) cuando sea necesario para separar herramientas de compilación de las imágenes finales de ejecución. | Manual |
| **STD-OPS-003** | **Ejecución como Usuario sin Privilegios:** Las imágenes de producción deben configurar un usuario de sistema sin privilegios (`USER nonroot`) para ejecutar la aplicación, evitando ejecutar procesos como `root` dentro del contenedor. | Manual / Automatizable |
| **STD-OPS-004** | **Archivo `.dockerignore` Obligatorio:** Todo repositorio con contenedorización debe incluir un archivo `.dockerignore` exhaustivo que excluya el directorio `.git`, archivos `.env` locales, dependencias locales (`node_modules`, `vendor`), temporales y volcados de datos. | Manual / Automatizable |
| **STD-OPS-005** | **Persistencia de Datos en Volúmenes:** Los servicios de bases de datos o almacenamiento de archivos persistentes deben montar volúmenes gestionados o bind-mounts dedicados. Nunca depender de la capa efímera del contenedor para datos críticos. | Manual |
| **STD-OPS-006** | **Cero Secretos en Archivos de Infraestructura:** Contraseñas, tokens y llaves criptográficas **jamás** deben incluirse como valores fijos en directivas `ENV`, `ARG` o en archivos de orquestación versionados. | Manual / Automatizable |

### 7.2 Servidores Web, Proxies Inversos y Transporte

| ID | Regla Obligatoria | Control |
| :--- | :--- | :--- |
| **STD-OPS-007** | **Aislamiento de la Raíz Pública (DocumentRoot):** El punto de entrada público del servidor web debe apuntar a un directorio público dedicado (`/public`, `/dist`, etc.). Archivos de configuración interna, código de backend no público, scripts de migración y `.env` deben ubicarse fuera del alcance directo del servidor HTTP. | Manual |
| **STD-OPS-008** | **Deshabilitación de Listado de Directorios:** Los servidores web deben tener deshabilitada la directiva de listado automático de directorios (*Directory Browsing* / *Options -Indexes*), impidiendo que atacantes descubran la estructura interna de carpetas. | Manual |
| **STD-OPS-009** | **Cifrado en Tránsito Obligatorio (HTTPS/TLS):** En ambientes expuestos a usuarios o redes externas, todo el tráfico debe circular sobre HTTPS. Las peticiones entrantes por HTTP inseguro deben redirigirse automáticamente a su equivalente TLS seguro. | Manual |
| **STD-OPS-010** | **Cabeceras HTTP de Seguridad Mandatorias:** Las respuestas web deben emitir como mínimo las cabeceras de endurecimiento estándar: `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`, y protección contra framing mediante `Content-Security-Policy: frame-ancestors 'self'` o `X-Frame-Options: SAMEORIGIN`. | Manual / Automatizable |

### 7.3 Gestión de Configuración y Secretos (Twelve-Factor App)
- **Principio de Doce Factores:** La configuración debe estar estrictamente separada del código fuente y administrarse mediante variables de entorno inyectadas al proceso.
- **Plantillas `.env.example`:** Todo proyecto debe mantener un archivo `.env.example` versionado con la totalidad de variables requeridas por el sistema, utilizando valores ficticios o documentados, sirviendo como contrato oficial para nuevos desarrolladores y despliegues.

---

## 8. Seguridad de la Aplicación (Alineada con OWASP Top 10)

| ID | Regla Obligatoria | Control |
| :--- | :--- | :--- |
| **STD-SEC-004** | **Validación Rigurosa de Entradas:** Toda entrada proveniente de usuarios o clientes externos debe validarse en el punto de recepción según tipo, formato, rango, longitud y lista de valores permitidos. La sanitización nunca sustituye la validación de formato. | Manual |
| **STD-SEC-005** | **Escapado Contextual contra XSS:** Todo dato dinámico insertado en respuestas hacia el navegador debe escaparse de acuerdo con el contexto de salida específico (contexto HTML, atributos, JavaScript, JSON o URL). | Manual / Automatizable |
| **STD-SEC-006** | **Protección contra Falsificación de Solicitudes (CSRF):** Cualquier operación autenticada que mute estado (creación, edición o eliminación) debe validar un token anti-CSRF criptográficamente impredecible vinculado a la sesión del usuario. Las operaciones mutables nunca deben ejecutarse mediante métodos `GET` idempotentes. | Manual |
| **STD-SEC-007** | **Seguridad en Cookies y Ciclo de Vida de Sesión:** Las cookies de sesión deben configurarse obligatoriamente con las banderas `HttpOnly` (para evitar accesos vía JavaScript), `Secure` (en contextos HTTPS) y un atributo `SameSite` adecuado (`Lax` o `Strict`). El identificador de sesión debe regenerarse inmediatamente después de la autenticación para mitigar la fijación de sesión. | Manual |
| **STD-SEC-008** | **Hashing Criptográfico de Contraseñas:** Las contraseñas de usuarios deben procesarse exclusivamente mediante algoritmos de derivación de claves diseñados para tal fin (`Argon2id`, `bcrypt` con factor de coste adecuado, o `PBKDF2`). Está **estrictamente prohibido** almacenar contraseñas en texto plano, con algoritmos obsoletos (`MD5`, `SHA-1`) o utilizando cifrado reversible. | Manual / Automatizable |
| **STD-SEC-009** | **Autorización Obligatoria en el Servidor (Mitigación IDOR):** El control de acceso debe verificarse en el servidor en **cada** solicitud. Ocultar enlaces o botones en la interfaz de usuario no constituye seguridad. Cuando un usuario solicite un recurso por identificador, el backend debe verificar que el usuario posee permisos legítimos sobre ese objeto en particular. | Manual |
| **STD-SEC-010** | **Protección contra Fuerza Bruta y Abuso de Autenticación:** Los endpoints de login y recuperación de credenciales deben implementar mecanismos de limitación de tasa (*rate limiting*), retardos progresivos o bloqueos temporales para prevenir ataques automatizados. | Manual |
| **STD-SEC-011** | **Gestión Segura de Carga de Archivos:** Cuando la aplicación permita subir archivos, debe verificar la extensión, validar el tipo MIME real inspeccionando los bytes de cabecera en el servidor, limitar el tamaño máximo permitido, generar un nombre aleatorio seguro y almacenar los archivos fuera de la raíz de ejecución de código. | Manual |

---

## 9. Control de Versiones: Git y Flujo de Integración

| ID | Regla Obligatoria | Control |
| :--- | :--- | :--- |
| **STD-GIT-001** | **Commits Atómicos y Coherentes:** Cada commit debe representar un cambio lógico unitario. Queda prohibido mezclar en un mismo commit refactorizaciones masivas de estilo, cambios de dependencias y nuevas funcionalidades independientes cuando puedan separarse limpiamente. | Manual |
| **STD-GIT-002** | **Mensajes de Commit Descriptivos:** Los mensajes de commit deben describir con claridad el propósito del cambio y el problema que resuelven. Queda prohibido el uso de mensajes vacíos, genéricos o sin contexto como `"fix"`, `"update"`, `"changes"`, `"wip"` o `"subiendo archivos"`. | Manual |
| **STD-GIT-003** | **Estructura Formal del Pull Request (PR):** Todo Pull Request destinado a una rama compartida debe incluir: <br>1. Objetivo y contexto del cambio.<br>2. Alcance de las modificaciones.<br>3. Evidencia de verificación o pruebas ejecutadas.<br>4. Cambios requeridos de configuración o migraciones de base de datos.<br>5. Enlace o referencia al ticket/issue correspondiente. | Manual |
| **STD-GIT-004** | **Exclusión Rigurosa de Secretos en el Historial:** El historial de Git no debe contener secretos, archivos `.env` reales, llaves privadas ni volcados de base de datos. Si un secreto es commiteado por error, su mera eliminación en un commit posterior no mitiga el riesgo: el secreto debe considerarse comprometido y rotarse inmediatamente. | Manual / Automatizable |
| **STD-GIT-005** | **Integración Protegida y Revisión por Pares (Peer Review):** Todo cambio destinado a las ramas principales de integración (`main`, `master`, `develop`) debe ser revisado y aprobado formalmente por al menos un revisor técnico calificado antes de ser fusionado (*merge*). | Manual |

---

## 10. Criterios Mínimos antes del Pull Request (QA Quality Gate)

Antes de marcar un Pull Request como listo para revisión, el autor debe validar exhaustivamente la siguiente lista de verificación:

1. **Cumplimiento Funcional:** El cambio satisface exactamente los requerimientos del ticket o issue, sin incluir alteraciones ajenas o no documentadas.
2. **Conformidad con el Estándar:** Se cumplen todas las reglas obligatorias aplicables de este manual (`QA-STD-001`).
3. **Ausencia de Secretos y Basura:** No existen credenciales, tokens, archivos `.env` reales, temporales ni logs en los archivos modificados.
4. **Seguridad en Datos:** Todas las consultas a bases de datos utilizan parámetros enlazados y las transacciones aseguran atomicidad.
5. **Control de Errores y Excepciones:** No existen capturas silenciosas (`catch` vacíos) y ninguna traza de error técnico es visible al usuario final.
6. **Autenticación y Autorización:** Las operaciones protegidas validan sesión, autorización a nivel de recurso y protección contra CSRF.
7. **Interfaz y Accesibilidad:** El HTML es semántico, cuenta con atributos `alt` y `label`, y los estilos no generan desbordamientos horizontales.
8. **Configuración y Despliegue:** Todo nuevo parámetro de entorno está documentado en `.env.example` y el `Dockerfile` / `compose` mantiene versiones fijas.
9. **Pruebas Automatizadas y Cobertura QA:** Se ejecutó la suite de pruebas unitarias alcanzando una cobertura mínima del **70%** sobre la lógica de negocio y servicios de dominio (con 100% de tests aprobados), garantizando la testeabilidad mediante inyección de dependencias y sin fallos por infraestructura externa.
10. **Documentación:** Se actualizaron los manuales, diagramas o archivos `README` si la funcionalidad o el despliegue sufrieron modificaciones.

---

## 11. Verificación y Límites del Estándar

### 11.1 Mecanismos de Verificación

| Dominio Técnico | Control Primario | Apoyo Automatizado Recomendado |
| :--- | :--- | :--- |
| **Formato y Estilo de Código** | Revisión por pares en PR | Linters y formateadores (Prettier, ESLint, Flake8, Black, Checkstyle, etc.) |
| **Defectos Estáticos y Seguridad** | Inspección en Code Review | Herramientas SAST (SonarQube, Trivy, Dependabot, Snyk, Semgrep) |
| **Contenedores y Despliegue** | Validación de infraestructura | `docker compose config`, escáneres de imágenes OCI |
| **Detección de Secretos** | Auditoría de commits | Pre-commit hooks, detectores de fugas (GitGuardian, Trufflehog, Gitleaks) |
| **Integridad de Pruebas** | Quality Gate en CI/CD | Test runners automatizados (Jest, PyTest, JUnit, Go Test, PHPUnit) |

### 11.2 Límites y Autonomía de los Equipos Técnicos
Este estándar (`QA-STD-001`) regula transversalmente los principios de calidad, seguridad y mantenibilidad. Quedan bajo la autonomía técnica de cada equipo y proyecto las siguientes decisiones particulares:
- Selección del lenguaje de programación y frameworks específicos (React, Vue, Angular, Django, FastAPI, Spring Boot, Express, NestJS, Laravel, ASP.NET, etc.).
- Metodología de versionamiento de ramas (GitFlow, Trunk-Based Development, GitHub Flow).
- Selección de herramientas específicas de formateo y runners de pruebas unitarias.
- Estrategias de particionamiento de bases de datos y mecanismos de caché distribuida.

---

*Manual emitido por el Área de Aseguramiento de Calidad de Software (QA / SQA). Vigencia a partir de su publicación oficial.*
