<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FishPot Admin') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            color: #1c1a17; /* nautical-950 */
        }
        h1, h2, h3, h4, .font-display {
            font-family: 'Playfair Display', serif;
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Custom scrollbar nautical */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f7f5f2; }
        ::-webkit-scrollbar-thumb { background: #0c3f6e; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #08294a; }
    </style>
</head>
<body class="antialiased flex min-h-screen overflow-x-hidden">
    <!-- Subtle Paper Texture Overlay -->
    <div class="fixed inset-0 pointer-events-none z-0 opacity-[0.03]" 
         style="background-image: url('https://www.transparenttextures.com/patterns/canvas-orange.png')"></div>

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ml-64 relative z-10">
        <!-- Navbar -->
        @include('layouts.navbar')

        <!-- Page Content -->
        <main class="flex-1 p-10">
            <div class="animate-fade-in">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        @include('layouts.footer')
    </div>
</body>
</html>
