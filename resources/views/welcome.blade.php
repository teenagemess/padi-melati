<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PadiMelati</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased">


    @include('layouts.navigation')
    <!-- Hero Section -->
    <section class="relative h-[70vh] bg-cover bg-[center_bottom_-100px] bg-no-repeat"
        style="background-image: url('images/hero.jpg');">
        <div
            class="absolute inset-0 flex flex-col items-center justify-center px-6 text-center text-white bg-black bg-opacity-50">
            <h1 class="text-3xl font-bold md:text-5xl">Forum Taaruf Padi Melati Muhammadiyah</h1>
            <p class="mt-2 text-lg md:text-xl">Membantu menemukan pasangan hidup dan mewujudkan keluarga Sakinah,
                Mawaddah, wa Rahmah.</p>
            <a href="#about" class="absolute left-1/2 bottom-[-30px] transform -translate-x-1/2 animate-bounce">
                <div class="flex items-center justify-center w-14 h-14 bg-[#BFD834] opacity-95 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </a>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang" class="px-6 py-16 text-center text-white bg-primary">
        <h2 class="mb-6 text-3xl font-bold">Tentang Kami</h2>
        <div class="flex flex-col items-center justify-center w-full gap-6 px-20 md:flex-row">
            <p class="max-w-2xl text-lg text-center">
                Forum Taaruf Padi Melati adalah forum taaruf yang terbentuk pada tahun 2017 dan bertujuan untuk membantu
                orang-orang yang ingin menemukan jodohnya.
                Forum ini dinisiasi sebagai tindak lanjut dari peserta kajian yang ingin menemukan jodoh, di mana kajian
                tersebut membahas tentang jodoh dan pernikahan.
            </p>
            <img src="images/logo.png" alt="Logo Padi Melati" class="w-48 mx-auto md:w-64">
        </div>

    </section>
    <x-footer></x-footer>

</body>

</html>
