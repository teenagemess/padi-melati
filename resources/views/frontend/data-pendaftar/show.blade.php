<x-app-layout>
    <div class="flex items-center py-60 h-[50vh] px-10 bg-emerald-600">
    </div>

    <div class="max-w-3xl mx-auto mt-[-200px]" x-data="{ tab: 'data-diri' }">
        <div class="relative p-6 text-center bg-white rounded-lg shadow-lg">
            <img src="{{ $dataDiri->foto_url ?? 'images/fotodummy.jpg' }}"
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

        <!-- Data Diri Tab -->
        <!-- Data Diri Tab -->
        <div x-show="tab === 'data-diri'" class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <div class="space-y-6">
                <h3 class="mb-4 text-xl font-bold">Data Diri</h3>

                <div class="space-y-4">
                    <!-- NIK -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">NBM</span>
                        <span class="w-2/3">: {{ $dataDiri->nbm ?? '-' }}</span>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Jenis Kelamin</span>
                        <span class="w-2/3">: {{ $dataDiri->jenis_kelamin ?? '-' }}</span>
                    </div>


                    <!-- Tempat Lahir dan Tanggal Lahir -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Tempat Lahir, tanggal lahir</span>
                        <span class="w-2/3">: {{ $dataDiri->tempat_lahir ?? '-' }},
                            {{ $dataDiri->tanggal_lahir ? \Carbon\Carbon::parse($dataDiri->tanggal_lahir)->format('d F Y') : '-' }}</span>
                    </div>

                    {{-- <!-- Tanggal Lahir -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Tanggal Lahir</span>
                        <span class="w-2/3">:
                            {{ $dataDiri->tanggal_lahir ? \Carbon\Carbon::parse($dataDiri->tanggal_lahir)->format('d F Y') : '-' }}</span>
                    </div> --}}

                    <!-- Alamat -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Alamat</span>
                        <span class="w-2/3">: {{ $dataDiri->alamat ?? '-' }}</span>
                    </div>

                    <!-- No. Telepon -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">No. Telepon</span>
                        <span class="w-2/3">: {{ $dataDiri->no_telepon ?? '-' }}</span>
                    </div>

                    <!-- Berat Badan -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Berat Badan</span>
                        <span class="w-2/3">: {{ $dataDiri->berat_badan ?? '-' }}</span>
                    </div>

                    <!-- Tinggi Badan -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Tinggi Badan</span>
                        <span class="w-2/3">: {{ $dataDiri->tinggi_badan ?? '-' }}</span>
                    </div>

                    <!-- Riwayat Penyakit -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Riwayat Penyakit</span>
                        <span class="w-2/3">: {{ $dataDiri->riwayat_penyakit ?? '-' }}</span>
                    </div>

                    <!-- Riwayat Organisasi -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Riwayat Organisasi</span>
                        <span class="w-2/3">: {{ $dataDiri->riwayat_organisasii ?? '-' }}</span>
                    </div>

                    <!-- Pendidikan -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Pendidikan</span>
                        <span class="w-2/3">: {{ $dataDiri->pendidikan ?? '-' }}</span>
                    </div>

                    <!-- Pekerjaan -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Pekerjaan</span>
                        <span class="w-2/3">: {{ $dataDiri->pekerjaan ?? '-' }}</span>
                    </div>

                    <!-- Status -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Status</span>
                        <span class="w-2/3">: {{ $dataDiri->status ?? '-' }}</span>
                    </div>

                    <!-- Status -->
                    <div class="flex items-start">
                        <span class="w-1/3 font-semibold">Penghasilan</span>
                        <span class="w-2/3">: {{ $dataDiri->penghasilan ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua Tab -->
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

        <!-- Kriteria Calon Tab -->
        <div x-show="tab === 'kriteria-calon'" class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <div class="space-y-4">
                <h3 class="text-xl font-bold">Kriteria Calon</h3>
                @if ($dataDiri->kriteria)
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <p class="font-semibold">Kriteria Diri</p>
                            <p>{{ $dataDiri->kriteria->kriteria_diri ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Kriteria Pasangan</p>
                            <p>{{ $dataDiri->kriteria->kriteria_pasangan ?? '-' }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Data kriteria calon belum tersedia</p>
                @endif
            </div>
        </div>

        <!-- Pandangan Pernikahan -->
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
                            <p class="font-semibold">Kriteria Pasangan</p>
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
    </div>
</x-app-layout>
