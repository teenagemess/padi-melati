{{-- resources/views/data-cocok/index.blade.php --}}
<x-app-layout>
    <div class="min-h-screen px-4 py-56 bg-primary">
        <div class="max-w-4xl mx-auto space-y-6">

            {{-- START: FITUR SEARCH BARU --}}
            <div
                class="flex flex-col items-start justify-between mb-6 space-y-4 md:flex-row md:items-center md:space-y-0">
                <div class="flex-1 w-full max-w-md">
                    <form method="GET" action="{{ route('data-cocok.index') }}" class="flex space-x-2">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama pendaftar..."
                                class="w-full px-4 py-2 pl-10 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <button type="submit"
                            class="px-4 py-2 text-gray-800 transition-colors duration-200 bg-yellow-400 rounded-lg hover:bg-yellow-500">
                            Cari
                        </button>

                        {{-- Tombol Reset hanya muncul jika ada pencarian aktif --}}
                        @if (request('search'))
                            <a href="{{ route('data-cocok.index') }}"
                                class="px-4 py-2 text-white transition-colors duration-200 bg-gray-500 rounded-lg hover:bg-gray-600">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

            </div>

            @if (request('search'))
                <div class="p-3 mb-4 border border-blue-200 rounded-lg bg-blue-50">
                    <p class="text-blue-700">
                        Menampilkan hasil untuk:
                        <span class="font-semibold">"{{ request('search') }}"</span>
                        ({{ $lakiLaki->total() }} hasil ditemukan)
                    </p>
                </div>
            @endif
            {{-- END: FITUR SEARCH BARU --}}

            {{-- Konten Asli Anda, Loop Kartu Pendaftar --}}
            <div class="space-y-6 ">
                @forelse($lakiLaki as $index => $laki)
                    <div class="flex items-center justify-between p-4 space-x-4 bg-gray-200 rounded-lg shadow-md">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $laki->user->image ? asset('storage/' . $laki->user->image) : asset('images/default-profile.jpg') }}"
                                class="object-cover w-16 h-16 rounded-full" alt="Foto">
                            <div>
                                <p class="flex items-center text-lg font-bold">
                                    {{ $laki->nama_peserta }}
                                    @if ($laki->is_matched)
                                        <span class="ml-2 text-green-500" title="Sudah Berjodoh">
                                            {{-- Icon Ceklis --}}
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </span>
                                    @else
                                        <span class="ml-2 text-red-500" title="Belum Berjodoh">
                                            {{-- Icon Silang --}}
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </span>
                                    @endif
                                </p>
                                <p class="text-sm">Laki-laki</p>
                                @if ($laki->created_at)
                                    <p class="text-xs text-gray-500">
                                        Bergabung {{ $laki->created_at->diffForHumans() }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('data-cocok.rekomendasi', $laki->user_id) }}"
                            class="px-4 py-1 text-gray-800 transition-colors duration-200 bg-yellow-400 rounded-md hover:bg-yellow-500">
                            Lihat Rekomendasi
                        </a>
                    </div>
                @empty
                    <div class="col-span-1 text-center md:col-span-2">
                        <div class="p-8 text-center bg-white rounded-lg shadow">
                            @if (request('search'))
                                <div class="mb-4">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <p class="mb-2 text-xl text-gray-600">Tidak ada hasil yang ditemukan untuk pencarian
                                    ini.</p>
                                <p class="mb-4 text-gray-500">Coba ubah kata kunci pencarian Anda</p>
                                <a href="{{ route('data-cocok.index') }}"
                                    class="inline-flex items-center px-4 py-2 text-gray-800 transition-colors duration-200 bg-yellow-400 rounded-md hover:bg-yellow-500">
                                    Lihat Semua Pendaftar
                                </a>
                            @else
                                <div class="mb-4">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <p class="text-xl text-gray-600">Belum ada pendaftar laki-laki saat ini.</p>
                                <p class="mt-2 text-gray-500">Silakan kembali lagi nanti untuk melihat pendaftar baru.
                                </p>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- START: PAGINATION LINKS --}}
            @if ($lakiLaki->hasPages())
                <div class="mt-8">
                    <div class="flex justify-center mb-4">
                        <p class="text-sm text-white">
                            Menampilkan {{ $lakiLaki->firstItem() ?? 0 }} - {{ $lakiLaki->lastItem() ?? 0 }}
                            dari {{ $lakiLaki->total() }} pendaftar
                        </p>
                    </div>

                    <div class="flex justify-center">
                        <nav class="flex items-center space-x-2">
                            {{-- Previous Page Link --}}
                            @if ($lakiLaki->onFirstPage())
                                <span class="px-3 py-2 text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $lakiLaki->previousPageUrl() }}"
                                    class="px-3 py-2 text-gray-700 transition-colors duration-200 bg-white rounded-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif

                            {{-- Pagination Elements (Page Numbers) --}}
                            @php
                                $start = max($lakiLaki->currentPage() - 2, 1);
                                $end = min($start + 4, $lakiLaki->lastPage());
                                $start = max($end - 4, 1);
                            @endphp

                            @if ($start > 1)
                                <a href="{{ $lakiLaki->url(1) }}"
                                    class="px-3 py-2 text-gray-700 transition-colors duration-200 bg-white rounded-md hover:bg-gray-100">1</a>
                                @if ($start > 2)
                                    <span class="px-3 py-2 text-gray-500">...</span>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $lakiLaki->currentPage())
                                    <span
                                        class="px-3 py-2 font-semibold text-white bg-yellow-500 rounded-md">{{ $i }}</span>
                                @else
                                    <a href="{{ $lakiLaki->url($i) }}"
                                        class="px-3 py-2 text-gray-700 transition-colors duration-200 bg-white rounded-md hover:bg-gray-100">{{ $i }}</a>
                                @endif
                            @endfor

                            @if ($end < $lakiLaki->lastPage())
                                @if ($end < $lakiLaki->lastPage() - 1)
                                    <span class="px-3 py-2 text-gray-500">...</span>
                                @endif
                                <a href="{{ $lakiLaki->url($lakiLaki->lastPage()) }}"
                                    class="px-3 py-2 text-gray-700 transition-colors duration-200 bg-white rounded-md hover:bg-gray-100">{{ $lakiLaki->lastPage() }}</a>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($lakiLaki->hasMorePages())
                                <a href="{{ $lakiLaki->nextPageUrl() }}"
                                    class="px-3 py-2 text-gray-700 transition-colors duration-200 bg-white rounded-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @else
                                <span class="px-3 py-2 text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @endif
                        </nav>
                    </div>
                </div>
            @endif
            {{-- END: PAGINATION LINKS --}}

            {{-- START: Keterangan Berjodoh dan Belum Berjodoh (DITARUH DI BAWAH HALAMAN) --}}
            <div class="grid grid-cols-1 gap-4 mt-8 md:grid-cols-2">
                <div class="p-4 text-center rounded-lg bg-white/10 backdrop-blur-sm">
                    <div class="text-2xl font-bold text-white">{{ $matchedMaleCount }}</div>
                    <div class="text-sm text-white/80">Laki-laki Sudah Berjodoh</div>
                </div>
                <div class="p-4 text-center rounded-lg bg-white/10 backdrop-blur-sm">
                    <div class="text-2xl font-bold text-white">{{ $unmatchedMaleCount }}</div>
                    <div class="text-sm text-white/80">Laki-laki Belum Berjodoh</div>
                </div>
            </div>
            {{-- END: Keterangan Berjodoh dan Belum Berjodoh --}}

        </div>
    </div>

    {{-- Footer --}}
    <x-footer />
</x-app-layout>
