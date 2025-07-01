<x-app-layout>
    <div class="min-h-screen bg-primary">
        <div class="container mx-auto py-36 px-28">
            <div
                class="flex flex-col items-start justify-between mb-6 space-y-4 md:flex-row md:items-center md:space-y-0">
                <div class="flex-1 max-w-md">
                    <form method="GET" action="{{ route('data-pendaftar.index') }}" class="flex space-x-2">
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

                        <select name="gender"
                            class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                            <option value="">Semua Gender</option>
                            <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>

                        <button type="submit"
                            class="px-4 py-2 text-gray-800 transition-colors duration-200 bg-yellow-400 rounded-lg hover:bg-yellow-500">
                            Cari
                        </button>

                        @if (request('search') || request('gender'))
                            <a href="{{ route('data-pendaftar.index') }}"
                                class="px-4 py-2 text-white transition-colors duration-200 bg-gray-500 rounded-lg hover:bg-gray-600">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            @if (request('search') || request('gender'))
                <div class="p-3 mb-4 border border-blue-200 rounded-lg bg-blue-50">
                    <p class="text-blue-700">
                        Menampilkan hasil untuk:
                        @if (request('search'))
                            <span class="font-semibold">"{{ request('search') }}"</span>
                        @endif
                        @if (request('gender'))
                            <span
                                class="font-semibold">{{ request('gender') == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        @endif
                        ({{ $pendaftarList->total() }} hasil ditemukan)
                    </p>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @forelse ($pendaftarList as $pendaftar)
                    <div
                        class="flex items-center justify-between p-4 transition-shadow duration-200 bg-gray-100 rounded-lg shadow hover:shadow-md">
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 overflow-hidden bg-gray-300 rounded-full">
                                <img src="{{ $pendaftar->user->image ? asset('storage/' . $pendaftar->user->image) : asset('images/default-profile.jpg') }}"
                                    alt="{{ $pendaftar->nama_peserta }}" class="object-cover w-full h-full"
                                    loading="lazy">
                            </div>
                            <div>
                                <h3 class="text-lg font-bold">{{ $pendaftar->nama_peserta }}</h3>
                                <p class="text-gray-600">
                                    {{ $pendaftar->jenis_kelamin == 'Laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                                    {{-- *** PERUBAHAN DI SINI *** --}}
                                    @if ($pendaftar->umur)
                                        • {{ $pendaftar->umur }} tahun
                                    @endif
                                </p>
                                @if ($pendaftar->created_at)
                                    <p class="text-sm text-gray-500">
                                        Bergabung {{ $pendaftar->created_at->diffForHumans() }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('data-pendaftar.show', $pendaftar->id) }}"
                            class="px-4 py-1 transition-colors duration-200 bg-yellow-400 rounded-md hover:bg-yellow-500">
                            Detail
                        </a>
                    </div>
                @empty
                    <div class="col-span-2">
                        <div class="p-8 text-center bg-white rounded-lg shadow">
                            @if (request('search') || request('gender'))
                                <div class="mb-4">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <p class="mb-2 text-xl text-gray-600">Tidak ada hasil yang ditemukan</p>
                                <p class="mb-4 text-gray-500">Coba ubah kata kunci pencarian atau filter Anda</p>
                                <a href="{{ route('data-pendaftar.index') }}"
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
                                <p class="text-xl text-gray-600">Belum ada pendaftar saat ini.</p>
                                <p class="mt-2 text-gray-500">Silakan kembali lagi nanti untuk melihat pendaftar baru.
                                </p>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($pendaftarList->hasPages())
                <div class="mt-8">
                    <div class="flex justify-center mb-4">
                        <p class="text-sm text-white">
                            Menampilkan {{ $pendaftarList->firstItem() ?? 0 }} - {{ $pendaftarList->lastItem() ?? 0 }}
                            dari {{ $pendaftarList->total() }} pendaftar
                        </p>
                    </div>

                    <div class="flex justify-center">
                        <nav class="flex items-center space-x-2">
                            {{-- Previous Page Link --}}
                            @if ($pendaftarList->onFirstPage())
                                <span class="px-3 py-2 text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $pendaftarList->previousPageUrl() }}"
                                    class="px-3 py-2 text-gray-700 transition-colors duration-200 bg-white rounded-md hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $start = max($pendaftarList->currentPage() - 2, 1);
                                $end = min($start + 4, $pendaftarList->lastPage());
                                $start = max($end - 4, 1);
                            @endphp

                            @if ($start > 1)
                                <a href="{{ $pendaftarList->url(1) }}"
                                    class="px-3 py-2 text-gray-700 transition-colors duration-200 bg-white rounded-md hover:bg-gray-100">1</a>
                                @if ($start > 2)
                                    <span class="px-3 py-2 text-gray-500">...</span>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $pendaftarList->currentPage())
                                    <span
                                        class="px-3 py-2 font-semibold text-white bg-yellow-500 rounded-md">{{ $i }}</span>
                                @else
                                    <a href="{{ $pendaftarList->url($i) }}"
                                        class="px-3 py-2 text-gray-700 transition-colors duration-200 bg-white rounded-md hover:bg-gray-100">{{ $i }}</a>
                                @endif
                            @endfor

                            @if ($end < $pendaftarList->lastPage())
                                @if ($end < $pendaftarList->lastPage() - 1)
                                    <span class="px-3 py-2 text-gray-500">...</span>
                                @endif
                                <a href="{{ $pendaftarList->url($pendaftarList->lastPage()) }}"
                                    class="px-3 py-2 text-gray-700 transition-colors duration-200 bg-white rounded-md hover:bg-gray-100">{{ $pendaftarList->lastPage() }}</a>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($pendaftarList->hasMorePages())
                                <a href="{{ $pendaftarList->nextPageUrl() }}"
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

            @if ($pendaftarList->total() > 0)
                <div class="grid grid-cols-1 gap-4 mt-8 md:grid-cols-3">
                    <div class="p-4 text-center rounded-lg bg-white/10 backdrop-blur-sm">
                        <div class="text-2xl font-bold text-white">{{ $pendaftarList->total() }}</div>
                        <div class="text-sm text-white/80">Total Pendaftar</div>
                    </div>
                    <div class="p-4 text-center rounded-lg bg-white/10 backdrop-blur-sm">
                        <div class="text-2xl font-bold text-white">
                            {{ \App\Models\Datadiri::where('jenis_kelamin', 'Laki-laki')->whereNotIn('user_id',\App\Models\MatchResult::where('status', 'confirmed')->pluck('laki_id')->merge(\App\Models\MatchResult::where('status', 'confirmed')->pluck('wanita_id'))->unique())->count() }}
                            {{-- *** PERUBAHAN DI SINI *** --}}
                        </div>
                        <div class="text-sm text-white/80">Laki-laki</div>
                    </div>
                    <div class="p-4 text-center rounded-lg bg-white/10 backdrop-blur-sm">
                        <div class="text-2xl font-bold text-white">
                            {{ \App\Models\Datadiri::where('jenis_kelamin', 'Perempuan')->whereNotIn('user_id',\App\Models\MatchResult::where('status', 'confirmed')->pluck('laki_id')->merge(\App\Models\MatchResult::where('status', 'confirmed')->pluck('wanita_id'))->unique())->count() }}
                            {{-- *** PERUBAHAN DI SINI *** --}}
                        </div>
                        <div class="text-sm text-white/80">Perempuan</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
<x-footer></x-footer>
