<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Valores Predeterminados de Autenticación
    |--------------------------------------------------------------------------
    |
    | Esta opción define el "guardia" de autenticación y el "agente" de
    | restablecimiento de contraseña predeterminados para tu aplicación.
    | Puedes cambiar estos valores según sea necesario.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Guardias de Autenticación
    |--------------------------------------------------------------------------
    |
    | A continuación, puedes definir cada guardia de autenticación para tu
    | aplicación. Se ha definido una configuración predeterminada que
    | utiliza el almacenamiento de sesión y el proveedor de usuarios Eloquent.
    |
    | Todos los guardias tienen un proveedor de usuarios, que define cómo se
    | recuperan los usuarios de la base de datos u otro sistema.
    |
    | Soportados: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'sanctum' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Proveedores de Usuarios
    |--------------------------------------------------------------------------
    |
    | Todos los guardias de autenticación tienen un proveedor de usuarios, que
    | define cómo se recuperan los usuarios de la base de datos. Normalmente
    | se utiliza Eloquent.
    |
    | Si tienes múltiples tablas o modelos de usuario, puedes configurar
    | múltiples proveedores para representar el modelo / tabla.
    |
    | Soportados: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Restablecimiento de Contraseñas
    |--------------------------------------------------------------------------
    |
    | Estas opciones especifican el comportamiento de la funcionalidad de
    | restablecimiento de contraseña de Laravel, incluyendo la tabla utilizada
    | para tokens y el proveedor de usuarios invocado.
    |
    | El tiempo de expiración es el número de minutos que el token será válido.
    | Esta función de seguridad mantiene los tokens con vida corta.
    |
    | El ajuste de aceleración (throttle) es el número de segundos que un
    | usuario debe esperar antes de generar más tokens de restablecimiento.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tiempo de Expiración de la Confirmación de Contraseña
    |--------------------------------------------------------------------------
    |
    | Aquí puedes definir el número de segundos antes de que expire la ventana
    | de confirmación de contraseña y se pida a los usuarios que reingresen
    | su contraseña. Por defecto, dura tres horas.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
