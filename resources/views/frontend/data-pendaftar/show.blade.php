<x-app-layout>
    <div class="flex items-center h-[50vh] px-10 bg-primary">
    </div>

    <div class="max-w-3xl mx-auto mt-[-200px]" x-data="{ tab: 'data-diri' }">
        <div class="relative p-6 text-center bg-white rounded-lg shadow-lg">
            <img src="images/fotodummy.jpg" class="mx-auto -mt-16 border-4 border-white rounded-full w-52 h-52"
                alt="Profile">
            {{-- @auth --}}
            {{-- <h2 class="mt-4 text-xl font-bold">{{ Auth::user()->name }}</h2> --}}
            <h2 class="mt-4 text-xl font-bold">Fahrudin</h2>
            {{-- @endauth --}}
            <p class="text-gray-500">Laki-laki</p>

            <div class="flex justify-center mt-4 border-b">
                <button @click="tab = 'data-diri'" class="w-1/2 px-4 py-2 border-b-2"
                    :class="{ 'border-black font-bold': tab === 'data-diri' }">Data Diri</button>
                <button @click="tab = 'data-orang-tua'" class="w-1/2 px-4 py-2 border-b-2"
                    :class="{ 'border-black font-bold': tab === 'data-orang-tua' }">Data Orang Tua</button>
                <button @click="tab = 'kriteria-calon'" class="w-1/2 px-4 py-2 border-b-2"
                    :class="{ 'border-black font-bold': tab === 'kriteria-calon' }">Kriteria Calon</button>
                <button @click="tab = 'pandangan-nikah'" class="w-1/2 px-4 py-2 border-b-2"
                    :class="{ 'border-black font-bold': tab === 'pandangan-nikah' }">Pandangan Nikah</button>
            </div>
        </div>

        <div x-show="tab === 'data-diri'" class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <div class="space-y-4">
            </div>
        </div>

        <div x-show="tab === 'data-orang-tua'" class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <div class="space-y-4">
            </div>
        </div>

        <div x-show="tab === 'kriteria-calon'" class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <div class="space-y-4">
            </div>
        </div>

        <div x-show="tab === 'pandangan-nikah'" class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <div class="space-y-4">
            </div>
        </div>
</x-app-layout>
