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
        style="background-image: url('https://s3-alpha-sig.figma.com/img/b06e/d4a3/807bf9c62281147b2abbb1b81ef1d589?Expires=1742774400&Key-Pair-Id=APKAQ4GOSFWCW27IBOMQ&Signature=QuqeePcqOaTfZsp1YE7U5z3O1q5tkbXTB~pniokfNrTF5MpH5DU2yviX5W7p73M2RSJFLg1oEqOCxD09SYOQh1HKzTfKxiYf7Uf2~NUbUg545M5NUsUqhrfvzwMN5k1VryZnVYq8BZURp5dh9j7BUcbnem5NMYx-QMraPUn1MO6gLkQlEj~Kn-iDSmVcAUirT-qqCYqPcfMgfFFIh2RCNtNBKC6UpZEn5OpLbJ1uI7s9Hkd4fTBHeaPto7gsKxw6yoOYAlh6wRWwt4EVNrbmJopT1Z5Ifsg6BsFCqcCnp6qplrJ5XnAn3UAS3QMn0dDUYfgu~E-N51uVdCptheJnlw__');">
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
            <img src="https://s3-alpha-sig.figma.com/img/8747/c855/d21424e65b00fa94a809dc0c050b9046?Expires=1742774400&Key-Pair-Id=APKAQ4GOSFWCW27IBOMQ&Signature=Z6owU9F6jRzMXTm-2w7cd4AzB51neq1jpXS14uT8JqtSFLCsXo0zfgHMEKbz7vPzpf3pMZUCcTBxtZxhB6yHnzjK1fQ11PnQVt6D1c3pkqp65pK6gsyS~TH1w~8U58S0WkYQ2W~iOTNRw7X9W3~ds5QtEnXIxuJNzq8zhpsPI5Tfbqx-1dlTAGGIXihqqhcoEPkpat8mfS4RGuG3kZQMJ~~t0aAIc4rvtRn2VFUmrAXiszYeWRjL85lbghlw-~2XVNyctSHtCOwt6VxR4B~PFt4tD~naPX3vORoiP4ljzy3~ZFS9dzVt3~o5Z4zJboAVmARmxBWeuy9JgDy7qXES7w__"
                alt="Logo Padi Melati" class="w-48 mx-auto md:w-64">
        </div>

    </section>
    <x-footer></x-footer>

</body>

</html>
