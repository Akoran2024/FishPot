<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'FishPot Admin') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-primary-50 min-h-screen flex">
    
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ml-64">
        <!-- Navbar -->
        @include('layouts.navbar')

        <!-- Page Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.footer')
    </div>
</body>
</html>