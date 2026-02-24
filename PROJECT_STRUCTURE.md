C:\Usersodri\OneDrive\Documentos\GitHub\FishPot
├───.editorconfig
├───.env
├───.env.example
├───.git... (contains git repository files)
├───.gitattributes
├───.gitignore
├───artisan
├───composer.json
├───composer.lock
├───docker-compose.yml
├───Dockerfile
├───node_modules... (contains Node.js modules)
├───package-lock.json
├───package.json
├───phpunit.xml
├───postcss.config.js
├───README.md
├───tailwind.config.js
├───vendor... (contains PHP Composer dependencies)
├───vite.config.js
├───app
│   ├───Http
│   │   ├───Controllers
│   │   │   ├───Admin
│   │   │   │   └───UserController.php
│   │   │   ├───Auth
│   │   │   │   ├───AuthenticatedSessionController.php
│   │   │   │   ├───ConfirmablePasswordController.php
│   │   │   │   ├───EmailVerificationNotificationController.php
│   │   │   │   ├───EmailVerificationPromptController.php
│   │   │   │   ├───NewPasswordController.php
│   │   │   │   ├───PasswordController.php
│   │   │   │   ├───PasswordResetLinkController.php
│   │   │   │   ├───RegisteredUserController.php
│   │   │   │   └───VerifyEmailController.php
│   │   │   ├───ClientController.php
│   │   │   ├───Controller.php
│   │   │   ├───OrderController.php
│   │   │   ├───ProductController.php
│   │   │   ├───ProfileController.php
│   │   │   └───TideController.php
│   │   ├───Middleware
│   │   │   └───AdminMiddleware.php
│   │   └───Requests
│   │       ├───Auth
│   │       │   └───LoginRequest.php
│   │       └───ProfileUpdateRequest.php
│   ├───Models
│   │   ├───Client.php
│   │   ├───Order.php
│   │   ├───OrderItem.php
│   │   ├───Product.php
│   │   └───User.php
│   ├───Providers
│   │   └───AppServiceProvider.php
│   └───View
│       └───Components
│           └───GuestLayout.php
├───bootstrap
│   ├───cache\... (contains cached framework files)
│   ├───app.php
│   └───providers.php
├───config
│   ├───app.php
│   ├───auth.php
│   ├───cache.php
│   ├───database.php
│   ├───filesystems.php
│   ├───logging.php
│   ├───mail.php
│   ├───queue.php
│   ├───services.php
│   ├───session.php
│   └───view.php
├───database
│   ├───factories
│   │   └───UserFactory.php
│   ├───migrations
│   │   ├───0001_01_01_000000_create_users_table.php
│   │   ├───0001_01_01_000001_create_cache_table.php
│   │   ├───0001_01_01_000002_create_jobs_table.php
│   │   ├───2026_02_11_113134_create_clients_table.php
│   │   ├───2026_02_11_123333_add_role_to_users_table.php
│   │   ├───2026_02_12_102212_create_products_table.php
│   │   └───2026_02_13_091935_create_orders_table.php
│   └───seeders
│       ├───DatabaseSeeder.php
│       └───ProductSeeder.php
├───nginx
│   └───default.conf
├───public
│   ├───imagenes
│   │   ├───aligote.jpg
│   │   ├───anzuelos.png
│   │   ├───barco.jpg
│   │   ├───burgados.jpg
│   │   ├───cangrejoblanco.jpg
│   │   ├───cangrejomoro.jpg
│   │   ├───caña.png
│   │   ├───carrete.png
│   │   ├───chopa.jpg
│   │   ├───estornino.jpg
│   │   ├───famara.jpg
│   │   ├───gitano.jpg
│   │   ├───golfo.webp
│   │   ├───hilo.png
│   │   ├───images.jpeg
│   │   ├───jurel.jpg
│   │   ├───lapablanca.jpg
│   │   ├───lapanegra.jpeg
│   │   ├───lasanta.jpg
│   │   ├───mero.jpg
│   │   ├───orzola.webp
│   │   ├───pargo.jpeg
│   │   ├───patudo.jpg
│   │   ├───pesca.jpg
│   │   ├───pescador.jpeg
│   │   ├───playablanca.webp
│   │   ├───puertodelcarmen.jpg
│   │   ├───pulpocomun.jpg
│   │   ├───salema.jpg
│   │   ├───sargo.jpg
│   │   ├───senuelo.png
│   │   ├───vieja.jpg
│   │   └───Vieja.png
│   ├───.htaccess
│   ├───favicon.ico
│   ├───index.php
│   └───robots.txt
├───resources
│   ├───css
│   │   └───app.css
│   ├───js
│   │   ├───admin\... (empty directory now)
│   │   ├───router
│   │   │   └───index.js
│   │   ├───stores
│   │   │   ├───auth.js
│   │   │   └───cart.js
│   │   ├───views
│   │   │   ├───Carrito.vue
│   │   │   ├───Clientes.vue
│   │   │   ├───Especies.vue
│   │   │   ├───Home.vue
│   │   │   ├───Login.vue
│   │   │   ├───Lugares.vue
│   │   │   ├───Mareas.vue
│   │   │   ├───Pedidos.vue
│   │   │   ├───Productos.vue
│   │   │   ├───Tienda.vue
│   │   │   └───Usuarios.vue
│   │   ├───app.js
│   │   ├───App.vue
│   │   └───bootstrap.js
│   └───views
│       ├───admin
│       │   ├───pedidos\... (empty directory now)
│       │   ├───products\... (empty directory now)
│       │   ├───users
│       │   │   ├───create.blade.php
│       │   │   ├───edit.blade.php
│       │   │   └───index.blade.php
│       │   └───dashboard.blade.php
│       ├───auth
│       │   ├───confirm-password.blade.php
│       │   ├───forgot-password.blade.php
│       │   ├───login.blade.php
│       │   ├───register.blade.php
│       │   ├───reset-password.blade.php
│       │   └───verify-email.blade.php
│       ├───components
│       │   ├───application-logo.blade.php
│       │   ├───auth-session-status.blade.php
│       │   ├───danger-button.blade.php
│       │   ├───dropdown-link.blade.php
│       │   ├───dropdown.blade.php
│       │   ├───input-error.blade.php
│       │   ├───input-label.blade.php
│       │   ├───modal.blade.php
│       │   ├───nav-link.blade.php
│       │   ├───primary-button.blade.php
│       │   ├───responsive-nav-link.blade.php
│       │   ├───secondary-button.blade.php
│       │   └───text-input.blade.php
│       ├───layouts
│       │   ├───admin.blade.php
│       │   ├───footer.blade.php
│       │   ├───guest.blade.php
│       │   ├───navbar.blade.php
│       │   ├───navigation.blade.php
│       │   └───sidebar.blade.php
│       └───profile
│           ├───partials
│           │   ├───delete-user-form.blade.php
│           │   ├───update-password-form.blade.php
│           │   └───update-profile-information-form.blade.php
│           └───edit.blade.php
├───routes
│   ├───auth.php
│   ├───console.php
│   └───web.php
├───storage
│   ├───app\... (contains app storage files)
│   ├───framework\... (contains framework cache and session files)
│   └───logs\... (contains log files)
└───tests
    ├───Feature
    │   ├───Auth
    │   │   ├───AuthenticationTest.php
│   │   ├───EmailVerificationTest.php
│   │   ├───PasswordConfirmationTest.php
│   │   ├───PasswordResetTest.php
│   │   ├───PasswordUpdateTest.php
│   │   └───RegistrationTest.php
│   ├───ExampleTest.php
│   └───ProfileTest.php
├───Unit
│   └───ExampleTest.php
└───TestCase.php
