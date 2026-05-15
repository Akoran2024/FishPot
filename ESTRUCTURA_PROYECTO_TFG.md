# Anexo: Arquitectura y Estructura de Directorios del Proyecto FishPot

Este documento detalla la organización de los archivos y la arquitectura del software de **FishPot**, desarrollada como Proyecto de Fin de Grado. La aplicación sigue un patrón de diseño moderno basado en una **API REST (Laravel)** y una **SPA (Single Page Application - Vue.js)**.

---

## 1. Árbol de Directorios del Sistema

```text
FishPot/
├── app/                        # Capa de Negocio (Backend PHP)
│   ├── Http/                   # Controladores, Middlewares y Requests
│   ├── Models/                 # Modelos Eloquent (Abstracción de Base de Datos)
│   ├── Mail/                   # Clases para envío de correos (Facturas)
│   └── Providers/              # Proveedores de servicios del framework
├── bootstrap/                  # Configuración de arranque del sistema
├── config/                     # Archivos de configuración global (App, Auth, DB)
├── database/                   # Gestión de la Base de Datos
│   ├── migrations/             # Definición de tablas y esquema
│   ├── seeders/                # Datos de prueba iniciales
│   └── factories/              # Generación de datos aleatorios para tests
├── public/                     # Punto de entrada y recursos públicos (CSS/JS compilado)
├── resources/                  # Código fuente del Frontend
│   ├── js/                     # Componentes Vue.js, Vue-Router y Pinia
│   ├── css/                    # Estilos con TailwindCSS
│   └── views/                  # Plantillas Blade (Entry point y PDFs)
├── routes/                     # Definición de rutas (api.php, web.php)
├── storage/                    # Archivos generados (Logs, Facturas, Caché)
├── tests/                      # Suite de pruebas automatizadas
├── .env                        # Variables de entorno y secretos
├── composer.json               # Gestión de dependencias PHP
├── package.json                # Gestión de dependencias JavaScript
└── vite.config.js              # Configuración del empaquetador de módulos
```

---

## 2. Descripción de Componentes Clave

### 2.1 Backend (Laravel)
- **`app/Http/Controllers/`**: Contiene la lógica que procesa las solicitudes. Destacan `StripeController.php` para pagos y `TideController.php` para la integración de datos meteorológicos.
- **`app/Models/`**: Define la estructura de datos. Incluye `Product`, `Order`, `Client` y `User`, estableciendo las relaciones necesarias para el e-commerce.
- **`app/Http/Middleware/`**: Implementa la seguridad. `AdminMiddleware.php` garantiza que solo usuarios con rol administrativo accedan al panel de gestión.
- **`routes/web.php`**: Define los puntos de acceso a la API y la ruta principal que sirve la aplicación Vue.

### 2.2 Frontend (Vue.js 3)
- **`resources/js/views/`**: Alberga las páginas de la aplicación. Ejemplos:
    - `Shop.vue`: Interfaz del catálogo de productos.
    - `Tides.vue`: Visualización de datos de mareas de Lanzarote.
    - `MyOrders.vue`: Área personal del cliente para ver historial.
- **`resources/js/stores/`**: Utiliza **Pinia** para el manejo del estado global:
    - `cart.js`: Gestión reactiva del carrito (añadir, eliminar, calcular totales).
    - `auth.js`: Control de la sesión del usuario.
- **`resources/js/router/`**: Gestiona la navegación SPA mediante `vue-router`, permitiendo una experiencia de usuario fluida sin recargas.

### 2.3 Infraestructura y DevOps
- **`docker-compose.yml`**: Define un entorno de ejecución contenedorizado mediante Docker, incluyendo servicios para PHP, Nginx y MySQL.
- **`vite.config.js`**: Configura la compilación optimizada del código JavaScript y CSS para producción.
- **`database/migrations/`**: Documenta la evolución del esquema de datos, permitiendo recrear la base de datos en cualquier entorno con un solo comando.

---

## 3. Justificación de la Estructura
La organización del proyecto se basa en los principios de **Responsabilidad Única** y **Separación de Preocupaciones (SoC)**. Al separar el código por capas (Presentación en `resources/`, Negocio en `app/` y Datos en `database/`), se facilita el mantenimiento a largo plazo y la colaboración en equipo, cumpliendo con los estándares de calidad exigidos en un Proyecto de Fin de Grado de Ingeniería Informática.
