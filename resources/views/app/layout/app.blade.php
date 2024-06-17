<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        <header>
            @yield('header')
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="bg-white p-4 rounded-t-2xl">
            <p class="text-gray-600 text-center text-xs">&copy; {{ date('Y') }} {{ config('app.name') }} - Todos os
                direitos
                reservados</p>
        </footer>
    </div>
</body>

</html>
