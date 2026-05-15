# Índice general

12.11 Anexo I: Manual de Instalación ................................................................... 2
12.11.1 Requerimientos del Sistema ................................................................... 2
12.11.2 Clonación del Proyecto ......................................................................... 2
12.11.3 Instalación de Dependencias (Backend) ..................................................... 3
12.11.4 Instalación de Dependencias (Frontend) ..................................................... 3
12.11.5 Configuración del Entorno (.env) ............................................................ 4
12.11.6 Configuración de la Base de Datos ........................................................... 5
12.11.7 Puesta en Marcha ................................................................................ 6

12.12 Anexo J: Manual de Usuario ...................................................................... 7
12.12.1 Pantalla de Inicio y Navegación ............................................................. 7
12.12.2 Gestión de Cuenta (Registro e Inicio de Sesión) .......................................... 8
12.12.3 Catálogo de Productos y Detalles ............................................................ 9
12.12.4 Carrito de Compra y Proceso de Pago (Stripe) ........................................... 10
12.12.5 Mi Perfil y Mis Pedidos ....................................................................... 11
12.12.6 Administración de Usuarios .................................................................. 12
12.12.7 Administración de Productos ................................................................ 13
12.12.8 Gestión de Pedidos ............................................................................ 14

13 Glosario ............................................................................................... 15

---

## 12.11 Anexo I: Manual de Instalación

El manual de instalación tiene como objetivo servir de guía para el despliegue del sistema **FishPot** en un entorno local de desarrollo. FishPot es una plataforma de comercio electrónico especializada en artículos de pesca, desarrollada con el framework Laravel y Vue.js.

### 12.11.1 Requerimientos del Sistema

Para el correcto funcionamiento de la aplicación, el servidor o equipo local debe contar con los siguientes componentes instalados:

*   **PHP:** Versión 8.2 o superior.
*   **Composer:** Gestor de dependencias de PHP.
*   **Node.js & NPM:** Para la gestión de activos del frontend y compilación con Vite.
*   **Sistema Gestor de Bases de Datos:** MySQL 8.0 o compatible (MariaDB).
*   **Servidor Web:** Apache o Nginx (aunque Laravel proporciona un servidor de desarrollo incorporado).
*   **Git:** Para la clonación del repositorio.

### 12.11.2 Clonación del Proyecto

El primer paso consiste en obtener una copia del código fuente desde el repositorio oficial. Para ello, abra una terminal y ejecute el siguiente comando:

```bash
git clone https://github.com/usuario/FishPot.git
cd FishPot
```

*Ilustración 12.11.2.1: Proceso de clonación del repositorio FishPot*

### 12.11.3 Instalación de Dependencias (Backend)

Una vez dentro de la carpeta del proyecto, se deben instalar las librerías de PHP necesarias utilizando Composer. Estas dependencias incluyen el propio framework Laravel, el cliente de Stripe para pagos y la librería para generación de facturas en PDF.

```bash
composer install
```

Este comando leerá el archivo `composer.json` y descargará todos los paquetes necesarios en el directorio `vendor/`.

### 12.11.4 Instalación de Dependencias (Frontend)

El frontend de FishPot utiliza Vue 3 y Tailwind CSS, gestionados a través de Vite. Para instalar las dependencias de JavaScript, ejecute:

```bash
npm install
```

Posteriormente, para compilar los activos por primera vez, puede usar:

```bash
npm run build
```

*Ilustración 12.11.4.1: Instalación de paquetes de Node.js*

### 12.11.5 Configuración del Entorno (.env)

Laravel utiliza un archivo `.env` para almacenar variables de configuración sensibles (credenciales de base de datos, claves de API, etc.). El proyecto incluye un archivo de ejemplo que debemos copiar:

```bash
cp .env.example .env
```

Tras copiarlo, genere la clave única de la aplicación:

```bash
php artisan key:generate
```

A continuación, edite el archivo `.env` con un editor de texto y configure los parámetros de su base de datos local:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fishpot_db
DB_USERNAME=root
DB_PASSWORD=tu_contraseña

STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
WORLD_TIDES_API_KEY=tu_clave_de_worldtides_api
```

*Tabla 12.11.5.1: Configuración básica del archivo .env*

### 12.11.6 Configuración de la Base de Datos

Con la base de datos creada en su gestor (ej. vía phpMyAdmin), proceda a ejecutar las migraciones para crear la estructura de tablas y los "seeders" para cargar datos iniciales (productos de prueba y usuarios administrador).

```bash
php artisan migrate --seed
```

Este comando creará tablas para usuarios, productos, pedidos, clientes y sesiones, e insertará los productos por defecto (cañas, carretes, hilos, etc.).

*Ilustración 12.11.6.1: Ejecución de migraciones y seeders*

### 12.11.7 Puesta en Marcha

Para iniciar el sistema, se requieren dos procesos activos: el servidor de backend y el servidor de desarrollo del frontend (si se desea hot-reload).

1.  **Backend:** `php artisan serve` (Habilitará el sitio en http://localhost:8000)
2.  **Frontend:** `npm run dev` (Gestionará la compilación en tiempo real de Vue y CSS)

---

## 12.12 Anexo J: Manual de Usuario

Este manual detalla las funcionalidades de la plataforma **FishPot** desde la perspectiva del usuario final y del administrador del sistema.

### 12.12.1 Pantalla de Inicio y Navegación

Al acceder a FishPot, el usuario es recibido por una interfaz moderna que destaca los productos estrella y ofrece información relevante sobre la pesca en Lanzarote, incluyendo una sección de **Previsión de Mareas** integrada.

*   **Menú Superior:** Enlaces a Productos, Carrito, y opciones de Cuenta.
*   **Sección de Mareas:** Información en tiempo real para planificar jornadas de pesca.

*Ilustración 12.12.1.1: Página de inicio de FishPot*

### 12.12.2 Gestión de Cuenta (Registro e Inicio de Sesión)

Para realizar compras, los usuarios deben estar registrados. El sistema utiliza Laravel Breeze para garantizar un flujo de autenticación seguro.

1.  **Registro:** El usuario introduce nombre, email y contraseña.
2.  **Login:** Acceso seguro a su historial de pedidos y carrito guardado.
3.  **Perfil:** Posibilidad de editar datos personales y cambiar la contraseña.

*Ilustración 12.12.2.1: Formulario de Registro de Usuario*

### 12.12.3 Catálogo de Productos y Detalles

La sección de productos permite filtrar por categorías (Cañas, Carretes, Hilos, etc.). Al hacer clic en un producto, se muestra:
*   Descripción detallada.
*   Precio y disponibilidad de stock.
*   Botón de "Añadir al carrito".

*Ilustración 12.12.3.1: Vista del catálogo de productos*

### 12.12.4 Carrito de Compra y Proceso de Pago (Stripe)

El carrito permite gestionar las cantidades de los artículos seleccionados. Una vez revisado, el usuario procede al "Checkout".
FishPot integra **Stripe**, permitiendo pagos seguros con tarjeta de crédito/débito. Tras el pago, el sistema genera automáticamente un pedido y reduce el stock del inventario.

*Ilustración 12.12.4.1: Pantalla de carrito y pasarela de pago Stripe*

### 12.12.5 Mi Perfil y Mis Pedidos

En el panel personal, el usuario puede consultar el estado de sus pedidos (Pendiente, Aceptado, Enviado, Cancelado). También puede descargar la factura en PDF de cada transacción.

### 12.12.6 Administración de Usuarios (Solo Admin)

Los administradores tienen acceso a una zona protegida donde pueden:
*   Visualizar la lista completa de usuarios registrados.
*   Asignar roles (User / Admin).
*   Eliminar cuentas de usuario si fuera necesario.

*Ilustración 12.12.6.1: Panel de administración - Gestión de usuarios*

### 12.12.7 Administración de Productos (Solo Admin)

Desde esta interfaz, el administrador puede gestionar el inventario de la tienda:
*   **Nuevo Producto:** Subir imágenes, descripción, precio y categoría.
*   **Editar:** Modificar precios o descripciones de productos existentes.
*   **Stock:** Actualizar el inventario disponible.

*Ilustración 12.12.7.1: Formulario de creación/edición de productos*

### 12.12.8 Gestión de Pedidos (Solo Admin)

El administrador visualiza todos los pedidos realizados en la plataforma. Puede cambiar el estado de los mismos para informar al cliente sobre el progreso de su compra (ej. marcar como "Enviado" tras depositar el paquete).

---

## 13 Glosario

*   **API (Application Programming Interface):** Interfaz que permite la comunicación entre el frontend (Vue.js) y el backend (Laravel).
*   **Backend:** Parte lógica de la aplicación que se ejecuta en el servidor.
*   **CSRF (Cross-Site Request Forgery):** Token de seguridad utilizado por Laravel para prevenir ataques maliciosos en formularios.
*   **Eloquent:** El ORM (Object-Relational Mapper) de Laravel para interactuar con la base de datos de forma sencilla.
*   **Frontend:** Interfaz visual con la que interactúa el usuario.
*   **Middleware:** Filtros que inspeccionan las peticiones HTTP (ej. verificar si un usuario es administrador antes de dejarle entrar al panel).
*   **Migración:** Archivo que define la estructura de una tabla en la base de datos, permitiendo el control de versiones de la misma.
*   **ORM (Object-Relational Mapping):** Técnica que permite interactuar con la base de datos usando objetos de programación en lugar de SQL puro.
*   **Seeder:** Script encargado de rellenar la base de datos con registros iniciales de prueba.
*   **SPA (Single Page Application):** Aplicación web que carga una sola página y actualiza el contenido dinámicamente sin recargar el navegador.
*   **Stripe:** Plataforma tecnológica que permite a particulares y empresas aceptar pagos por Internet.
*   **Vite:** Herramienta de construcción que permite una experiencia de desarrollo rápida para proyectos web modernos.
