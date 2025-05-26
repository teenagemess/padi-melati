<x-app-layout>
    <!-- Header with Green Background -->
    <div class="h-40 bg-emerald-600"></div>

    <!-- Main Content -->
    <div class="max-w-4xl px-4 mx-auto -mt-20">
        <!-- Profile Cards -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <!-- Male Profile -->
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <!-- ... (keep existing male profile content) ... -->
            </div>

            <!-- Female Profile -->
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <!-- ... (keep existing female profile content) ... -->
            </div>
        </div>

        <!-- Compatibility Section -->
        <div class="p-6 mt-8 bg-white rounded-lg shadow-lg">
            <!-- ... (keep existing compatibility content) ... -->
        </div>

        <!-- Pandangan Nikah Section -->
        <div class="p-6 mt-8 bg-white rounded-lg shadow-lg">
            <h3 class="mb-4 text-xl font-bold text-center">Pandangan Pernikahan</h3>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Male's View -->
                <div class="p-4 rounded-lg bg-gray-50">
                    <h4 class="font-semibold">{{ $lakiLaki->nama }}</h4>
                    @if ($pandanganNikahLaki)
                        <div class="mt-3 space-y-3">
                            <div>
                                <p class="font-medium">Visi Pernikahan:</p>
                                <p>{{ $pandanganNikahLaki->visi_pernikahan ?? 'Tidak ada data' }}</p>
                            </div>
                            <div>
                                <p class="font-medium">Misi Pernikahan:</p>
                                <p>{{ $pandanganNikahLaki->misi_pernikahan ?? 'Tidak ada data' }}</p>
                            </div>
                            <div>
                                <p class="font-medium">Cita-cita Pernikahan:</p>
                                <p>{{ $pandanganNikahLaki->cita_pernikahan ?? 'Tidak ada data' }}</p>
                            </div>
                        </div>
                    @else
                        <p class="mt-2 text-gray-700">Tidak ada data pandangan pernikahan</p>
                    @endif
                </div>

                <!-- Female's View -->
                <div class="p-4 rounded-lg bg-gray-50">
                    <h4 class="font-semibold">{{ $wanita->nama }}</h4>
                    @if ($pandanganNikahWanita)
                        <div class="mt-3 space-y-3">
                            <div>
                                <p class="font-medium">Visi Pernikahan:</p>
                                <p>{{ $pandanganNikahWanita->visi_pernikahan ?? 'Tidak ada data' }}</p>
                            </div>
                            <div>
                                <p class="font-medium">Misi Pernikahan:</p>
                                <p>{{ $pandanganNikahWanita->misi_pernikahan ?? 'Tidak ada data' }}</p>
                            </div>
                            <div>
                                <p class="font-medium">Cita-cita Pernikahan:</p>
                                <p>{{ $pandanganNikahWanita->cita_pernikahan ?? 'Tidak ada data' }}</p>
                            </div>
                        </div>
                    @else
                        <p class="mt-2 text-gray-700">Tidak ada data pandangan pernikahan</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center mt-8 space-x-4">
            <a href="{{ route('data-cocok.index') }}"
                class="px-6 py-2 text-white transition bg-gray-500 rounded-lg hover:bg-gray-600">
                Kembali
            </a>

            @if (!isset($isMatched) || !$isMatched)
                <form action="{{ route('data-cocok.konfirmasi') }}" method="POST">
                    @csrf
                    <input type="hidden" name="laki_id" value="{{ $lakiLaki->user_id }}">
                    <input type="hidden" name="wanita_id" value="{{ $wanita->user_id }}">
                    <input type="hidden" name="persentase" value="{{ $persentase }}">
                    <button type="submit"
                        class="px-6 py-2 text-white transition rounded-lg bg-emerald-600 hover:bg-emerald-700">
                        Konfirmasi Pasangan
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
