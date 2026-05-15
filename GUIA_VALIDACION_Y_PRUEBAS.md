# 8. VALIDACIÓN Y PRUEBAS

Este documento detalla las herramientas y los procedimientos seguidos para garantizar la calidad y el correcto funcionamiento del sistema **FishPot**.

## 8.1 Herramientas

Para la validación del proyecto se han seleccionado herramientas que cubren tanto la lógica de negocio como la interfaz de usuario y el estilo del código:

### 1. PHPUnit
Es el framework de pruebas estándar para PHP, integrado nativamente en Laravel. Se utiliza para:
- **Pruebas Unitarias:** Validar componentes aislados (modelos, servicios).
- **Pruebas de Funcionalidad (Feature Tests):** Verificar flujos completos, como la respuesta de controladores, validación de rutas y persistencia en base de datos.

### 2. Laravel Dusk (Automatización de Navegador)
Dusk permite realizar pruebas de extremo a extremo (E2E) simulando el comportamiento de un usuario real en el navegador (Chrome). Es fundamental para validar:
- Procesos de autenticación (Login/Registro).
- Flujo de compra y carrito.
- Interactividad de los componentes de Vue.js.

### 3. Laravel Pint
Es un corrector de estilo de código PHP basado en PHP-CS-Fixer. Asegura que el código siga los estándares PSR-12 y las convenciones de Laravel, manteniendo la limpieza y legibilidad del proyecto.

---

## 8.2 Ejecución

A continuación se describen los comandos necesarios para ejecutar las pruebas en los diferentes entornos.

### A. Ejecución de Pruebas Unitarias y de Funcionalidad (PHPUnit)
Laravel ofrece un comando simplificado para ejecutar todas las pruebas de la carpeta `tests/`.

**En entorno local:**
```bash
php artisan test
```

**Si se utiliza Docker:**
```bash
docker exec -it laravel-app php artisan test
```

### B. Ejecución de Pruebas de Navegador (Laravel Dusk)
*Nota: Dusk requiere que el servidor esté en ejecución.*

1. **Instalación (si no está presente):**
   ```bash
   composer require --dev laravel/dusk
   php artisan dusk:install
   ```

2. **Ejecución:**
   ```bash
   php artisan dusk
   ```

### C. Control de Estilo de Código (Laravel Pint)
Para asegurar que el código cumple con los estándares antes de subir cambios:

```bash
# Solo inspeccionar errores
./vendor/bin/pint --test

# Corregir automáticamente el estilo
./vendor/bin/pint
```

### D. Validación Manual de la Base de Datos
Para comprobar que las migraciones y los seeders (datos de prueba) funcionan correctamente:

```bash
php artisan migrate:fresh --seed
```

### E. Depuración de Consultas y Logs
Para monitorizar errores en tiempo real durante las pruebas manuales:

```bash
php artisan pail
```
