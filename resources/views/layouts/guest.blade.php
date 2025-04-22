<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900">
    <div class="flex min-h-screen bg-primary dark:bg-gray-900">
        <!-- Bagian Kiri: Form Login -->
        <div class="flex w-full lg:justify-start sm:justify-center lg:w-1/2">
            <div class="content-center w-full max-w-md p-6 rounded-lg dark:bg-gray-900">
                {{ $slot }}
            </div>
        </div>

        <!-- Bagian Kanan: Gambar -->
        <div "
            style="background-image: url();">
        </div>

        <img class="hidden w-1/2 bg-center bg-cover rounded-l-2xl lg:flex" src="images/bungacincin.jpg" alt="">
    </div>
</body>

</html>
