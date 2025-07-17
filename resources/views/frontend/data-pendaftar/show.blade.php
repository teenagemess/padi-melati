<x-app-layout>
    <div class="flex items-center py-60 h-[50vh] px-10 bg-emerald-600">
    </div>

    <div class="max-w-3xl mx-auto mt-[-200px]" x-data="{ tab: 'data-diri', showKtpModal: false }">
        <div class="relative p-6 text-center bg-white rounded-lg shadow-lg">
            <img src="{{ $dataDiri->user->image ? asset('storage/' . $dataDiri->user->image) : asset('images/default-profile.jpg') }}"
                class="mx-auto -mt-16 border-4 border-white rounded-full w-52 h-52" alt="Profile">
            <h2 class="mt-4 text-2xl font-bold">{{ $dataDiri->nama_peserta ?? 'Nama Peserta' }}</h2>
            <p class="text-gray-500">{{ $dataDiri->jenis_kelamin ?? 'Jenis Kelamin' }}</p>

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
            <div class="space-y-6">
                <h3 class="mb-4 text-xl font-bold">Data Diri</h3>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">NBM</span>
                        <span class="w-2/3">: {{ $dataDiri->nbm ?? '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Jenis Kelamin</span>
                        <span class="w-2/3">: {{ $dataDiri->jenis_kelamin ?? '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Tempat Lahir, tanggal lahir</span>
                        <span class="w-2/3">: {{ $dataDiri->tempat_lahir ?? '-' }},
                            {{ $dataDiri->tanggal_lahir ? \Carbon\Carbon::parse($dataDiri->tanggal_lahir)->format('d F Y') : '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Alamat</span>
                        <span class="w-2/3">: {{ $dataDiri->alamat ?? '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">No. Telepon</span>
                        <span class="w-2/3">: {{ $dataDiri->no_telepon ?? '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Berat Badan</span>
                        <span class="w-2/3">: {{ $dataDiri->berat_badan ?? '-' }} kg</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Tinggi Badan</span>
                        <span class="w-2/3">: {{ $dataDiri->tinggi_badan ?? '-' }} cm</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Riwayat Penyakit</span>
                        <span class="w-2/3">: {{ $dataDiri->riwayat_penyakit ?? '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Riwayat Organisasi</span>
                        <span class="w-2/3">: {{ $dataDiri->riwayat_organisasi ?? '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Pendidikan</span>
                        <span class="w-2/3">: {{ $dataDiri->pendidikan ?? '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Pekerjaan</span>
                        <span class="w-2/3">: {{ $dataDiri->pekerjaan ?? '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Status Pernikahan</span>
                        <span class="w-2/3">: {{ $dataDiri->status_pernikahan ?? '-' }}</span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Penghasilan</span>
                        <span class="w-2/3">: {{ $dataDiri->penghasilan ?? '-' }}</span>
                    </div>

                    <!-- KTP Section -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">KTP</span>
                        <span class="w-2/3">:
                            @if ($dataDiri->ktp_file)
                                <button @click="showKtpModal = true"
                                    class="text-blue-600 hover:text-blue-800 hover:underline focus:outline-none">
                                    Lihat KTP
                                </button>
                            @else
                                <span class="text-gray-500">Tidak ada file KTP</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="tab === 'data-orang-tua'" class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <div class="space-y-4">
                <h3 class="text-xl font-bold">Data Orang Tua</h3>
                @if ($dataDiri->orangtua)
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <p class="font-semibold">Nama Ayah</p>
                            <p>{{ $dataDiri->orangtua->nama_ayah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Pekerjaan Ayah</p>
                            <p>{{ $dataDiri->orangtua->pekerjaan_ayah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Nama Ibu</p>
                            <p>{{ $dataDiri->orangtua->nama_ibu ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Pekerjaan Ibu</p>
                            <p>{{ $dataDiri->orangtua->pekerjaan_ibu ?? '-' }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Data orang tua belum tersedia</p>
                @endif
            </div>
        </div>

        <div x-show="tab === 'kriteria-calon'" class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <div class="space-y-4">
                <h3 class="text-xl font-bold">Kriteria Calon</h3>
                @if ($dataDiri->kriteria)
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <p class="font-semibold">Kriteria Diri</p>
                            @php
                                $kriteriaDiri = $dataDiri->kriteria->kriteria_diri_array;
                            @endphp
                            @if (!empty($kriteriaDiri))
                                <ul class="text-gray-700 list-disc list-inside">
                                    @foreach ($kriteriaDiri as $kriteriaItem)
                                        <li>{{ $kriteriaItem }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500">- Tidak ada kriteria diri atau data tidak valid -</p>
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold">Kriteria Pasangan</p>
                            @php
                                $kriteriaPasangan = $dataDiri->kriteria->kriteria_pasangan_array;
                            @endphp
                            @if (!empty($kriteriaPasangan))
                                <ul class="text-gray-700 list-disc list-inside">
                                    @foreach ($kriteriaPasangan as $kriteriaItem)
                                        <li>{{ $kriteriaItem }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500">- Tidak ada kriteria pasangan atau data tidak valid -</p>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Data kriteria calon belum tersedia</p>
                @endif
            </div>
        </div>

        <div x-show="tab === 'pandangan-nikah'" class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <div class="space-y-4">
                <h3 class="text-xl font-bold">Pandangan Pernikahan</h3>
                @if ($dataDiri->pandanganNikah)
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <p class="font-semibold">Visi Pernikahan</p>
                            <p>{{ $dataDiri->pandanganNikah->visi_pernikahan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Misi Pernikahan</p>
                            <p>{{ $dataDiri->pandanganNikah->misi_pernikahan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Cita Pernikahan</p>
                            <p>{{ $dataDiri->pandanganNikah->cita_pernikahan ?? '-' }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Data Pandangan Pernikahan Belum Ada</p>
                @endif
            </div>
        </div>

        <!-- KTP Modal -->
        <div x-show="showKtpModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            @click="showKtpModal = false">

            <div class="relative max-w-4xl max-h-[90vh] mx-4 bg-white rounded-lg shadow-xl overflow-hidden"
                @click.stop>

                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold">KTP - {{ $dataDiri->nama_peserta }}</h3>
                    <button @click="showKtpModal = false"
                        class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-4 max-h-[80vh] overflow-auto">
                    @if ($dataDiri->ktp_file)
                        @php
                            $extension = pathinfo($dataDiri->ktp_file, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                        @endphp

                        @if ($isImage)
                            <img src="{{ asset('storage/' . $dataDiri->ktp_file) }}"
                                alt="KTP {{ $dataDiri->nama_peserta }}"
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
                                <a href="{{ asset('storage/' . $dataDiri->ktp_file) }}" target="_blank"
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
    </div>
</x-app-layout>
