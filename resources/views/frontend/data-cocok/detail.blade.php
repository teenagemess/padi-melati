<x-app-layout>
    <!-- Header with Green Background -->
    <div class="h-40 bg-emerald-600"></div>

    <!-- Main Content -->
    <div class="max-w-4xl px-4 mx-auto -mt-20" x-data="{ tab: 'data-diri', showKtpModalLaki: false, showKtpModalWanita: false }">
        <!-- Profile Cards -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <!-- Male Profile -->
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <div class="text-center">
                    <img src="{{ $lakiLaki->user->image ? asset('storage/' . $lakiLaki->user->image) : asset('images/default-profile.jpg') }}"
                        class="object-cover w-32 h-32 mx-auto mb-4 border-4 rounded-full">
                    <h2 class="text-xl font-bold">{{ $lakiLaki->nama }}</h2>
                    <p class="text-gray-600">{{ $lakiLaki->jenis_kelamin }}</p>
                </div>

                <div class="mt-6 space-y-3">
                    <!-- Basic Info -->
                    <div class="flex">
                        <span class="w-1/3 font-semibold">NBM</span>
                        <span class="w-2/3">: {{ $lakiLaki->nbm ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">TTL</span>
                        <span class="w-2/3">: {{ $lakiLaki->tempat_lahir ?? '-' }},
                            {{ $lakiLaki->tanggal_lahir ? \Carbon\Carbon::parse($lakiLaki->tanggal_lahir)->format('d F Y') : '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Alamat</span>
                        <span class="w-2/3">: {{ $lakiLaki->alamat ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Telepon</span>
                        <span class="w-2/3">: {{ $lakiLaki->no_telepon ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Email</span>
                        <span class="w-2/3">: {{ $lakiLaki->user->email ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Tinggi</span>
                        <span class="w-2/3">: {{ $lakiLaki->tinggi_badan ?? '-' }} cm</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Berat</span>
                        <span class="w-2/3">: {{ $lakiLaki->berat_badan ?? '-' }} kg</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Penghasilan</span>
                        <span class="w-2/3">: {{ $lakiLaki->penghasilan ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Riwayat Penyakit</span>
                        <span class="w-2/3">: {{ $lakiLaki->riwayat_penyakit ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Organisasi</span>
                        <span class="w-2/3">: {{ $lakiLaki->riwayat_organisasi ?? '-' }}</span>
                    </div>
                    <!-- KTP Section -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">KTP</span>
                        <span class="w-2/3">:
                            @if ($lakiLaki->ktp_file)
                                <button @click="showKtpModalLaki = true"
                                    class="text-blue-600 hover:text-blue-800 hover:underline focus:outline-none">
                                    Lihat KTP
                                </button>
                            @else
                                <span class="text-gray-500">Tidak ada file KTP</span>
                            @endif
                        </span>
                    </div>

                    <!-- Male's Parents -->
                    <div class="pt-4 mt-4 border-t">
                        <h4 class="mb-3 font-semibold text-center">Data Orang Tua</h4>
                        <div class="space-y-2">
                            <div class="flex">
                                <span class="w-1/3 font-medium">Ayah</span>
                                <span class="w-2/3">: {{ $lakiLaki->orangtua->nama_ayah ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-1/3 font-medium">Pekerjaan</span>
                                <span class="w-2/3">: {{ $lakiLaki->orangtua->pekerjaan_ayah ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-1/3 font-medium">Ibu</span>
                                <span class="w-2/3">: {{ $lakiLaki->orangtua->nama_ibu ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-1/3 font-medium">Pekerjaan</span>
                                <span class="w-2/3">: {{ $lakiLaki->orangtua->pekerjaan_ibu ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Female Profile -->
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <div class="text-center">
                    <img src="{{ $wanita->user->image ? asset('storage/' . $wanita->user->image) : asset('images/default-profile.jpg') }}"
                        class="object-cover w-32 h-32 mx-auto mb-4 border-4 rounded-full">
                    <h2 class="text-xl font-bold">{{ $wanita->nama }}</h2>
                    <p class="text-gray-600">{{ $wanita->jenis_kelamin }}</p>
                </div>

                <div class="mt-6 space-y-3">
                    <!-- Basic Info -->
                    <div class="flex">
                        <span class="w-1/3 font-semibold">NBM</span>
                        <span class="w-2/3">: {{ $wanita->nbm ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">TTL</span>
                        <span class="w-2/3">: {{ $wanita->tempat_lahir ?? '-' }},
                            {{ $wanita->tanggal_lahir ? \Carbon\Carbon::parse($wanita->tanggal_lahir)->format('d F Y') : '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Alamat</span>
                        <span class="w-2/3">: {{ $wanita->alamat ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Telepon</span>
                        <span class="w-2/3">: {{ $wanita->no_telepon ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Email</span>
                        <span class="w-2/3">: {{ $wanita->user->email ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Tinggi</span>
                        <span class="w-2/3">: {{ $wanita->tinggi_badan ?? '-' }} cm</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Berat</span>
                        <span class="w-2/3">: {{ $wanita->berat_badan ?? '-' }} kg</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Penghasilan</span>
                        <span class="w-2/3">: {{ $wanita->penghasilan ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Riwayat Penyakit</span>
                        <span class="w-2/3">: {{ $wanita->riwayat_penyakit ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-1/3 font-semibold">Organisasi</span>
                        <span class="w-2/3">: {{ $wanita->riwayat_organisasi ?? '-' }}</span>
                    </div>
                    <!-- KTP Section -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">KTP</span>
                        <span class="w-2/3">:
                            @if ($wanita->ktp_file)
                                <button @click="showKtpModalWanita = true"
                                    class="text-blue-600 hover:text-blue-800 hover:underline focus:outline-none">
                                    Lihat KTP
                                </button>
                            @else
                                <span class="text-gray-500">Tidak ada file KTP</span>
                            @endif
                        </span>
                    </div>

                    <!-- Female's Parents -->
                    <div class="pt-4 mt-4 border-t">
                        <h4 class="mb-3 font-semibold text-center">Data Orang Tua</h4>
                        <div class="space-y-2">
                            <div class="flex">
                                <span class="w-1/3 font-medium">Ayah</span>
                                <span class="w-2/3">: {{ $wanita->orangtua->nama_ayah ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-1/3 font-medium">Pekerjaan</span>
                                <span class="w-2/3">: {{ $wanita->orangtua->pekerjaan_ayah ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-1/3 font-medium">Ibu</span>
                                <span class="w-2/3">: {{ $wanita->orangtua->nama_ibu ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-1/3 font-medium">Pekerjaan</span>
                                <span class="w-2/3">: {{ $wanita->orangtua->pekerjaan_ibu ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KTP Modal for Male -->
        <div x-show="showKtpModalLaki" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            @click="showKtpModalLaki = false">

            <div class="relative max-w-4xl max-h-[90vh] mx-4 bg-white rounded-lg shadow-xl overflow-hidden"
                @click.stop>

                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold">KTP - {{ $lakiLaki->nama }}</h3>
                    <button @click="showKtpModalLaki = false"
                        class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-4 max-h-[80vh] overflow-auto">
                    @if ($lakiLaki->ktp_file)
                        @php
                            $extension = pathinfo($lakiLaki->ktp_file, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                        @endphp

                        @if ($isImage)
                            <img src="{{ asset('storage/' . $lakiLaki->ktp_file) }}" alt="KTP {{ $lakiLaki->nama }}"
                                class="h-auto max-w-full mx-auto rounded-lg shadow-md">
                        @else
                            <div class="py-8 text-center">
                                <div class="mb-4">
                                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="mb-4 text-gray-600">File KTP ({{ strtoupper($extension) }})</p>
                                <a href="{{ asset('storage/' . $lakiLaki->ktp_file) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Download KTP
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- KTP Modal for Female -->
        <div x-show="showKtpModalWanita" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            @click="showKtpModalWanita = false">

            <div class="relative max-w-4xl max-h-[90vh] mx-4 bg-white rounded-lg shadow-xl overflow-hidden"
                @click.stop>

                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold">KTP - {{ $wanita->nama }}</h3>
                    <button @click="showKtpModalWanita = false"
                        class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-4 max-h-[80vh] overflow-auto">
                    @if ($wanita->ktp_file)
                        @php
                            $extension = pathinfo($wanita->ktp_file, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                        @endphp

                        @if ($isImage)
                            <img src="{{ asset('storage/' . $wanita->ktp_file) }}" alt="KTP {{ $wanita->nama }}"
                                class="h-auto max-w-full mx-auto rounded-lg shadow-md">
                        @else
                            <div class="py-8 text-center">
                                <div class="mb-4">
                                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="mb-4 text-gray-600">File KTP ({{ strtoupper($extension) }})</p>
                                <a href="{{ asset('storage/' . $wanita->ktp_file) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Download KTP
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Compatibility Section -->
        <div class="p-6 mt-8 bg-white rounded-lg shadow-lg">
            <h3 class="mb-4 text-xl font-bold text-center">Persentase Kecocokan: {{ $persentase }}%</h3>

            <!-- Progress Bar -->
            <div class="w-full h-4 mb-6 bg-gray-200 rounded-full">
                <div class="h-4 rounded-full bg-emerald-600" style="width: {{ $persentase }}%"></div>
            </div>

            <!-- Compatibility Details -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Male to Female -->
                <div class="p-4 rounded-lg bg-gray-50">
                    <h4 class="font-semibold">{{ $lakiLaki->nama }} → {{ $wanita->nama }}</h4>
                    <p class="text-sm text-gray-600">Skor: {{ $lakiKeWanita }} dari
                        {{ count($kriteriaPasanganLaki) }} kriteria</p>

                    <div class="mt-3 space-y-2">
                        @foreach ($kriteriaPasanganLaki as $kriteria)
                            <div class="flex items-center">
                                <span class="mr-2">•</span>
                                <span>{{ $kriteria }}</span>
                                @if (in_array($kriteria, $kriteriaDiriWanita))
                                    <span class="ml-2 text-green-500">✓</span>
                                @else
                                    <span class="ml-2 text-red-500">✗</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Female to Male -->
                <div class="p-4 rounded-lg bg-gray-50">
                    <h4 class="font-semibold">{{ $wanita->nama }} → {{ $lakiLaki->nama }}</h4>
                    <p class="text-sm text-gray-600">Skor: {{ $wanitaKeLaki }} dari
                        {{ count($kriteriaPasanganWanita) }} kriteria</p>

                    <div class="mt-3 space-y-2">
                        @foreach ($kriteriaPasanganWanita as $kriteria)
                            <div class="flex items-center">
                                <span class="mr-2">•</span>
                                <span>{{ $kriteria }}</span>
                                @if (in_array($kriteria, $kriteriaDiriLaki))
                                    <span class="ml-2 text-green-500">✓</span>
                                @else
                                    <span class="ml-2 text-red-500">✗</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
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
        </div>
    </div>
</x-app-layout>
