<x-app-layout>
    <div class="max-w-4xl px-4 py-8 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Data Diri</h1>

        <!-- Data Orang Tua -->
        <div class="mb-8">
            <h2 class="pb-2 mb-4 text-xl font-semibold text-gray-700 border-b">Data Orang Tua</h2>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Data Pria -->
                <div class="p-5 bg-white rounded-lg shadow">
                    <h3 class="mb-3 text-lg font-bold">{{ $lakiLaki->nama_peserta }}</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><strong>RIBu:</strong> {{ $lakiLaki->nomor_induk ?? 'N/A' }}</li>
                        <li><strong>Tempat/Tanggal Lahir:</strong> {{ $lakiLaki->tempat_lahir }},
                            {{ $lakiLaki->tanggal_lahir }}</li>
                        <li><strong>Alamat:</strong> {{ $lakiLaki->alamat }}</li>
                        <li><strong>Telepon:</strong> {{ $lakiLaki->nomor_telepon }}</li>
                        <li><strong>Berat Badan:</strong> {{ $lakiLaki->berat_badan }} kg</li>
                        <li><strong>Tinggi Badan:</strong> {{ $lakiLaki->tinggi_badan }} cm</li>
                        <li><strong>Riwayat Penyakit:</strong>
                            @if (is_array($lakiLaki->riwayat_penyakit))
                                {{ implode(', ', $lakiLaki->riwayat_penyakit) }}
                            @else
                                {{ $lakiLaki->riwayat_penyakit ?? 'Tidak ada' }}
                            @endif
                        </li>
                        <li><strong>Organisasi:</strong> {{ $lakiLaki->organisasi ?? 'Tidak ada' }}</li>
                    </ul>
                </div>

                <!-- Data Wanita -->
                <div class="p-5 bg-white rounded-lg shadow">
                    <h3 class="mb-3 text-lg font-bold">{{ $wanita->nama_peserta }}</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><strong>RIBu:</strong> {{ $wanita->nomor_induk ?? 'N/A' }}</li>
                        <li><strong>Tempat/Tanggal Lahir:</strong> {{ $wanita->tempat_lahir }},
                            {{ $wanita->tanggal_lahir }}</li>
                        <li><strong>Alamat:</strong> {{ $wanita->alamat }}</li>
                        <li><strong>Telepon:</strong> {{ $wanita->nomor_telepon }}</li>
                        <li><strong>Berat Badan:</strong> {{ $wanita->berat_badan }} kg</li>
                        <li><strong>Tinggi Badan:</strong> {{ $wanita->tinggi_badan }} cm</li>
                        <li><strong>Riwayat Penyakit:</strong>
                            @if (is_array($wanita->riwayat_penyakit))
                                {{ implode(', ', $wanita->riwayat_penyakit) }}
                            @else
                                {{ $wanita->riwayat_penyakit ?? 'Tidak ada' }}
                            @endif
                        </li>
                        <li><strong>Organisasi:</strong> {{ $wanita->organisasi ?? 'Tidak ada' }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Kriteria Calon -->
        <div class="mb-8">
            <h2 class="pb-2 mb-4 text-xl font-semibold text-gray-700 border-b">Kriteria Calon</h2>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Kriteria Pria -->
                <div class="p-5 bg-white rounded-lg shadow">
                    <h3 class="mb-3 text-lg font-bold">{{ $lakiLaki->nama_peserta }} menginginkan:</h3>
                    <ul class="space-y-2 text-gray-700">
                        @foreach ($kriteriaPasanganLaki as $kriteria)
                            <li class="flex items-center">
                                <span class="mr-2">•</span>
                                <span>{{ $kriteria }}</span>
                                @if (in_array($kriteria, $kriteriaDiriWanita))
                                    <span class="ml-2 text-green-500">✓</span>
                                @else
                                    <span class="ml-2 text-red-500">✗</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Kriteria Wanita -->
                <div class="p-5 bg-white rounded-lg shadow">
                    <h3 class="mb-3 text-lg font-bold">{{ $wanita->nama_peserta }} menginginkan:</h3>
                    <ul class="space-y-2 text-gray-700">
                        @foreach ($kriteriaPasanganWanita as $kriteria)
                            <li class="flex items-center">
                                <span class="mr-2">•</span>
                                <span>{{ $kriteria }}</span>
                                @if (in_array($kriteria, $kriteriaDiriLaki))
                                    <span class="ml-2 text-green-500">✓</span>
                                @else
                                    <span class="ml-2 text-red-500">✗</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Pandangan Nikah -->
        <div class="mb-8">
            <h2 class="pb-2 mb-4 text-xl font-semibold text-gray-700 border-b">Pandangan Nikah</h2>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="p-5 bg-white rounded-lg shadow">
                    <h3 class="mb-3 text-lg font-bold">{{ $lakiLaki->nama_peserta }}</h3>
                    <p class="text-gray-700">{{ $lakiLaki->pandangan_nikah ?? 'Tidak ada data' }}</p>
                </div>
                <div class="p-5 bg-white rounded-lg shadow">
                    <h3 class="mb-3 text-lg font-bold">{{ $wanita->nama_peserta }}</h3>
                    <p class="text-gray-700">{{ $wanita->pandangan_nikah ?? 'Tidak ada data' }}</p>
                </div>
            </div>
        </div>

        <!-- Persentase Kecocokan -->
        <div class="p-6 mb-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mb-4 text-2xl font-bold text-gray-800">Persentase Kecocokan: <span
                        class="text-green-600">{{ $persentase }}%</span></h2>

                <div class="flex items-center justify-center mb-6 space-x-12">
                    <div class="text-center">
                        <img src="{{ asset('storage/foto/' . ($lakiLaki->foto ?? 'default.jpg')) }}"
                            alt="{{ $lakiLaki->nama_peserta }}"
                            class="object-cover w-20 h-20 mx-auto mb-2 border-2 border-gray-300 rounded-full">
                        <p class="font-medium">{{ $lakiLaki->nama_peserta }}</p>
                    </div>

                    <div class="text-4xl text-red-500">
                        ❤
                    </div>

                    <div class="text-center">
                        <img src="{{ asset('storage/foto/' . ($wanita->foto ?? 'default.jpg')) }}"
                            alt="{{ $wanita->nama_peserta }}"
                            class="object-cover w-20 h-20 mx-auto mb-2 border-2 border-gray-300 rounded-full">
                        <p class="font-medium">{{ $wanita->nama_peserta }}</p>
                    </div>
                </div>

                <div class="mb-6 text-gray-700">
                    <p>Kecocokan {{ $lakiLaki->nama_peserta }} ke {{ $wanita->nama_peserta }}:
                        <strong>{{ $lakiKeWanita }}</strong> dari {{ count($kriteriaPasanganLaki) }} kriteria
                        terpenuhi
                    </p>
                    <p>Kecocokan {{ $wanita->nama_peserta }} ke {{ $lakiLaki->nama_peserta }}:
                        <strong>{{ $wanitaKeLaki }}</strong> dari {{ count($kriteriaPasanganWanita) }} kriteria
                        terpenuhi
                    </p>
                </div>

                <form action="{{ route('data-cocok.konfirmasi') }}" method="POST">
                    @csrf
                    <input type="hidden" name="laki_id" value="{{ $lakiLaki->user_id }}">
                    <input type="hidden" name="wanita_id" value="{{ $wanita->user_id }}">
                    <input type="hidden" name="persentase" value="{{ $persentase }}">
                    <button type="submit"
                        class="px-6 py-2 font-medium text-white bg-green-600 rounded-lg shadow hover:bg-green-700">
                        Konfirmasi Pasangan
                    </button>
                </form>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('data-cocok.rekomendasi', $lakiLaki->user_id) }}"
                class="font-medium text-blue-600 hover:text-blue-800">
                ← Kembali ke Rekomendasi
            </a>
        </div>
    </div>
</x-app-layout>
