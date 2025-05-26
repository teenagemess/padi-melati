<x-app-layout>
    <div class="min-h-screen py-12 bg-primary">
        <div class="container px-4 mx-auto">
            <h1 class="mb-10 text-4xl font-bold text-center text-white">
                Rekomendasi: {{ $lakiLaki->nama_peserta }}
            </h1>

            @if (session('error'))
                <div class="p-4 mb-6 text-red-700 bg-red-100 rounded-lg">{{ session('error') }}</div>
            @endif

            @forelse($matches as $match)
                <div class="p-6 mb-6 bg-white shadow-md rounded-2xl">
                    <div class="flex flex-col items-center justify-between md:flex-row">
                        {{-- Male Participant --}}
                        <div class="flex flex-col items-center mb-4 md:mb-0">
                            <img src="{{ asset('storage/foto/' . ($lakiLaki->foto ?? 'default.jpg')) }}"
                                class="object-cover w-24 h-24 mb-3 border-2 border-gray-300 rounded-full">
                            <div class="font-semibold">{{ $lakiLaki->nama_peserta }}</div>
                            <div class="text-gray-500">Laki-laki</div>
                        </div>

                        {{-- Match Percentage --}}
                        <div class="mb-4 text-center md:mb-0">
                            <div class="text-xl font-bold text-gray-800">Level Kecocokan: {{ $match['persentase'] }}%
                            </div>
                            @if (isset($isMatched) && $isMatched)
                                <div class="px-4 py-2 mt-2 text-sm font-bold text-white bg-green-600 rounded-lg">
                                    Sudah Dijodohkan
                                </div>
                            @endif
                        </div>

                        {{-- Female Participant --}}
                        <div class="flex flex-col items-center mb-4 md:mb-0">
                            <img src="{{ asset('storage/foto/' . ($match['wanita']->foto ?? 'default.jpg')) }}"
                                class="object-cover w-24 h-24 mb-3 border-2 border-gray-300 rounded-full">
                            <div class="font-semibold">{{ $match['wanita']->nama_peserta }}</div>
                            <div class="text-gray-500">Perempuan</div>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
                            @if (!isset($isMatched) || !$isMatched)
                                <form action="{{ route('data-cocok.konfirmasi') }}" method="POST" class="inline-block">
                                    @csrf
                                    <input type="hidden" name="laki_id" value="{{ $lakiLaki->user_id }}">
                                    <input type="hidden" name="wanita_id" value="{{ $match['wanita']->user_id }}">
                                    <input type="hidden" name="persentase" value="{{ $match['persentase'] }}">
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        Konfirmasi
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('data-cocok.detail', ['laki_id' => $lakiLaki->user_id, 'wanita_id' => $match['wanita']->user_id]) }}"
                                class="px-4 py-2 text-sm font-medium text-center text-gray-800 bg-yellow-400 rounded-lg hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-blue-800 bg-blue-100 rounded-lg">
                    Tidak ada rekomendasi yang tersedia untuk peserta ini.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
