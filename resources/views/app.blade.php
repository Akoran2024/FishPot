<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FishPot - Pesca en Lanzarote</title>
    
    <link rel="icon" type="image/png" href="{{ asset('imagenes/Vieja.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Eliminamos cualquier fondo sólido aquí para que mande el CSS */
        body {
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
    </style>
</head>
<body class="antialiased selection:bg-primary-500/30">
    <div id="app"></div>
</body>
</html>
