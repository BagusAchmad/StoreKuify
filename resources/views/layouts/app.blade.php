<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'StoreKuify')</title>
    
    <!-- Global StoreKuify Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=1.2">
    <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=1.2">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}?v=1.2">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles and Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col">
    @yield('content')
</body>
</html>
