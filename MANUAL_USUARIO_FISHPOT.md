# Manual de Usuario de FishPot - Paso a Paso

Bienvenido a **FishPot**, tu plataforma especializada en artículos de pesca y servicios para el pescador. Este manual te guiará a través de todas las funcionalidades del sistema, desde la compra de material hasta la gestión administrativa.

---

## 1. Introducción y Acceso
FishPot es una aplicación web moderna diseñada para facilitar la adquisición de material de pesca y proporcionar información útil (como mareas) para los entusiastas de este deporte.

### Cómo acceder
Abre tu navegador y dirígete a la URL de la aplicación (por defecto `http://localhost:8000` en entorno de desarrollo).

---

## 2. Guía para el Usuario (Cliente)

### 2.1 Crear una Cuenta
Para realizar compras, debes estar registrado:
1.  Haz clic en **"Registrarse"** en la esquina superior derecha.
2.  Rellena el formulario con tu **Nombre, Email y Contraseña**.
3.  Pulsa en **"Registrarse"**. Recibirás una confirmación y serás redirigido a la página de inicio.

### 2.2 Iniciar Sesión
Si ya tienes cuenta:
1.  Haz clic en el enlace de acceso (configurado como **"Gestor Privado"** en la barra de navegación o dirígete a `/gestor-privado`).
2.  Introduce tu correo electrónico y contraseña.
3.  Pulsa **"Iniciar Sesión"**.

### 2.3 Explorar Productos y Mareas
*   **Catálogo:** En la página principal o en la sección de "Productos", puedes ver todos los artículos disponibles (cañas, carretes, hilos, etc.).
*   **Mareas:** En la sección correspondiente, podrás consultar la previsión de mareas en tiempo real para planificar tus salidas de pesca en Lanzarote.

### 2.4 Realizar una Compra (Paso a Paso)
1.  **Selección:** Busca el producto que te interesa y haz clic en él para ver sus detalles.
2.  **Añadir al Carrito:** Haz clic en el botón **"Añadir al Carrito"**. Puedes seguir navegando y añadir más artículos.
3.  **Revisar Carrito:** Pulsa en el icono del carrito en la parte superior. Aquí puedes modificar cantidades o eliminar productos.
4.  **Checkout:** Haz clic en **"Tramitar Pedido"**.
5.  **Pago con Stripe:** Serás redirigido a la pasarela segura de Stripe. Introduce los datos de tu tarjeta (puedes usar tarjetas de prueba en entorno de desarrollo).
6.  **Confirmación:** Una vez completado el pago, verás una pantalla de éxito y recibirás un correo con el detalle de tu compra.

### 2.5 Consultar Pedidos y Perfil
*   **Mis Pedidos:** En tu perfil, puedes ver el historial de todas tus compras y el estado actual (Pendiente, Aceptado, Enviado).
*   **Facturas:** Desde el historial de pedidos, puedes descargar la **factura en formato PDF** de cada compra.

---

## 3. Guía para el Administrador

*Nota: Solo los usuarios con el rol "Admin" pueden acceder a estas funciones.*

### 3.1 Acceso al Panel de Control
Dirígete a la sección `/admin` o selecciona "Administración" en tu menú de usuario.

### 3.2 Gestión de Usuarios
1.  Ve a la sección **"Usuarios"**.
2.  Aquí verás una lista de todos los registrados.
3.  **Cambiar Roles:** Puedes ascender a un usuario a "Administrador" o degradarlo a "Usuario" estándar.
4.  **Eliminar:** Puedes dar de baja cuentas de usuario.

### 3.3 Gestión del Catálogo (Productos)
1.  Ve a la sección **"Productos"**.
2.  **Crear Nuevo:** Pulsa en "Añadir Producto". Sube una imagen, añade nombre, descripción, categoría, precio y stock inicial.
3.  **Editar:** Haz clic en el icono de edición de un producto existente para actualizar su precio o stock.
4.  **Eliminar:** Si un producto ya no se vende, puedes eliminarlo del catálogo.

### 3.4 Gestión de Pedidos
Como administrador, debes gestionar el flujo de las ventas:
1.  Ve a la sección **"Pedidos"**.
2.  **Aceptar Pedido:** Cuando verifiques la disponibilidad, marca el pedido como "Aceptado".
3.  **Enviar Pedido:** Una vez empaquetado y depositado en el transporte, márcalo como "Enviado". El cliente recibirá una notificación.
4.  **Cancelar:** Si hay algún problema, puedes cancelar el pedido y gestionar la devolución.

---

## 4. Resolución de Problemas Comunes

*   **¿Olvidaste tu contraseña?** Utiliza el enlace "¿Olvidaste tu contraseña?" en la pantalla de login para recibir un email de recuperación.
*   **¿El pago falla?** Asegúrate de que los datos de la tarjeta son correctos y que tienes conexión a internet. FishPot utiliza Stripe para garantizar la máxima seguridad.
*   **¿No ves el panel de Admin?** Tu cuenta debe tener permisos de administrador. Contacta con el desarrollador principal si necesitas acceso.

---
*FishPot - Tu puerto de confianza para la pesca.*
