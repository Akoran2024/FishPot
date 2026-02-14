<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased text-primary-900 bg-primary-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            <!-- Decorative background elements -->
            <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary-100 rounded-full blur-3xl opacity-50"></div>
                <div class="absolute top-1/2 -left-24 w-80 h-80 bg-primary-100 rounded-full blur-3xl opacity-40"></div>
                <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-primary-50 rounded-full blur-3xl opacity-30"></div>
            </div>

            <div class="z-10 mb-8">
                <a href="/">
                    <x-application-logo />
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white/80 backdrop-blur-xl border border-primary-200 shadow-2xl overflow-hidden sm:rounded-[2.5rem] z-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
