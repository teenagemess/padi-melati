<x-app-layout>
    <div class="min-h-screen bg-emerald-600">
        <div class="container mx-auto py-36 px-28">
            <!-- Header with button -->
            <div class="flex justify-end mb-6">
                <button class="px-6 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">
                    Jodohkan
                </button>
            </div>

            <!-- Grid of cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @forelse ($pendaftarList as $pendaftar)
                    <!-- Card -->
                    <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg shadow">
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 overflow-hidden bg-gray-300 rounded-full">
                                <img src="{{ $pendaftar->foto_url }}" alt="{{ $pendaftar->nama_peserta }}"
                                    class="object-cover w-full h-full">
                            </div>
                            <div>
                                <h3 class="text-lg font-bold">{{ $pendaftar->nama_peserta }}</h3>
                                <p class="text-gray-600">{{ $pendaftar->jenis_kelamin }}</p>
                            </div>
                        </div>
                        <a href="{{ route('data-pendaftar.show', $pendaftar->id) }}"
                            class="px-4 py-1 bg-yellow-400 rounded-md hover:bg-yellow-500">
                            Detail
                        </a>
                    </div>
                @empty
                    <div class="col-span-2">
                        <div class="p-8 text-center bg-white rounded-lg shadow">
                            <p class="text-xl text-gray-600">Belum ada pendaftar saat ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($pendaftarList->count() > 6)
                <!-- Pagination dots -->
                <div class="flex justify-center my-8 space-x-2">
                    <span class="w-2 h-2 bg-white rounded-full"></span>
                    <span class="w-2 h-2 bg-white rounded-full opacity-50"></span>
                    <span class="w-2 h-2 bg-white rounded-full opacity-50"></span>
                </div>

                <!-- Pagination button -->
                <div class="flex justify-end mb-8">
                    <button class="flex items-center text-white hover:underline">
                        Selanjutnya
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
<x-footer></x-footer>
