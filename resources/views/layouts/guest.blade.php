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
        <div class="hidden w-1/2 bg-center bg-cover rounded-l-3xl lg:flex"
            style="background-image: url('https://s3-alpha-sig.figma.com/img/4809/8fe8/b8844f20b3e5b0b80094e74c7cd38919?Expires=1742774400&Key-Pair-Id=APKAQ4GOSFWCW27IBOMQ&Signature=IA0ahPhGOKO-lGKQND5m4XPyk0WvhqIyC9Ws7BF4t9DQQjZHRdks81MqO8rCPVezOCxiUfai99mb0SyPk2EtD-RI7EuGdNUL-1s4MkHSjY5m~AfMb~2RVl35IyfMUrtpkaI0b0obJDTXU4dyyKB~8qZ1jtBHHwhfwRfzwcuzl-fwsFtEErgPSxwYDMlprLmMmfs6pegkyBQjhSqhW1VaJX23eZ-lixsIpvK-6UDkvJ7Do3J1x~V6NhPhl7oVj-48DiQ-H-Mzo26qJYTx5sjRgCHH8UPKolPSpvcjteWUDD6EKmFsUNfzW9Jkthj0SgG843qGb9gXpxEQBuYXbgkHCg__');">
        </div>
    </div>
</body>

</html>
