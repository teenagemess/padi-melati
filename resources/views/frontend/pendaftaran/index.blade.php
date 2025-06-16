<x-app-layout>
    <!-- Alpine.js State -->
    <div x-data="{
        tab: 'informasi',
        formData: {
            nbm: '',
            nama_peserta: '',
            tempat_lahir: '',
            tanggal_lahir: '',
            jenis_kelamin: '',
            status: '',
            tinggi_badan: '',
            berat_badan: '',
            alamat: '',
            no_telepon: '',
            pendidikan: '',
            pekerjaan: '',
            penghasilan: '',
            riwayat_penyakit: [],
            riwayat_penyakit_lain: '',
            ktp: null,
            riwayat_organisasi: '',
            nama_ayah: '',
            pekerjaan_ayah: '',
            nama_ibu: '',
            pekerjaan_ibu: '',
            karakteristik_diri: [],
            karakteristik_diri_lain: '',
            karakteristik_pasangan: [],
            karakteristik_pasangan_lain: '',
            visi_pernikahan: '',
            misi_pernikahan: '',
            cita_pernikahan: ''
        },
        hasRegistered: {{ $hasRegistered ? 'true' : 'false' }},
        updateRiwayatPenyakit(event, penyakit) {
            if (event.target.checked) {
                if (!this.formData.riwayat_penyakit.includes(penyakit)) {
                    this.formData.riwayat_penyakit.push(penyakit);
                }
            } else {
                this.formData.riwayat_penyakit = this.formData.riwayat_penyakit.filter(item => item !== penyakit);
            }
        },
        removeRiwayatPenyakit(penyakit) {
            this.formData.riwayat_penyakit = this.formData.riwayat_penyakit.filter(item => item !== penyakit);
        },
        toggleKarakteristikDiri(karakteristik) {
            const index = this.formData.karakteristik_diri.indexOf(karakteristik);
            if (index === -1) {
                this.formData.karakteristik_diri.push(karakteristik);
            } else {
                this.formData.karakteristik_diri.splice(index, 1);
            }
        },
        toggleKarakteristikPasangan(karakteristik) {
            const index = this.formData.karakteristik_pasangan.indexOf(karakteristik);
            if (index === -1) {
                this.formData.karakteristik_pasangan.push(karakteristik);
            } else {
                this.formData.karakteristik_pasangan.splice(index, 1);
            }
        }
    }" class="flex justify-center min-h-[80vh] bg-primary">
        <div class="w-full p-12 pt-24 bg-[#D9D9D9] max-w-7xl rounded-b-xl">
            <!-- Show alert messages -->
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Judul Dinamis -->
            <template x-show="tab === 'informasi'">
                <h2 class="mb-6 text-4xl font-semibold text-start mt-14">Informasi Pendaftaran</h2>
            </template>
            <template x-show="tab === 'data_diri'">
                <h2 class="mb-6 text-4xl font-semibold text-center mt-14">Data Diri</h2>
            </template>
            <template x-show="tab === 'data_orang_tua'">
                <h2 class="mb-6 text-4xl font-semibold text-center mt-14">Data Orang Tua</h2>
            </template>
            <template x-show="tab === 'karakteristik'">
                <h2 class="mb-6 text-4xl font-semibold text-center mt-14">Karakteristik Diri dan Calon</h2>
            </template>
            <template x-show="tab === 'pandangan'">
                <h2 class="mb-6 text-4xl font-semibold text-center mt-14">Pandangan Pernikahan</h2>
            </template>
            <template x-show="tab === 'status'">
                <h2 class="mb-6 text-4xl font-semibold text-center mt-14">Status Pendaftaran</h2>
            </template>

            <div x-show="tab === 'informasi'">
                <div class="items-start space-x-4">
                    <template x-if="!hasRegistered">
                        <x-primary-button @click="tab = 'data_diri'">
                            Daftar
                        </x-primary-button>
                    </template>
                    <template x-if="hasRegistered">
                        <div class="p-4 mb-4 text-sm rounded-lg text-amber-700 bg-amber-100" role="alert">
                            Anda telah mengisi data pendaftaran
                        </div>
                    </template>
                    <x-primary-button @click="tab = 'status'">
                        Status Pendaftaran
                    </x-primary-button>
                </div>
            </div>

            <!-- Status tab content -->
            <div x-show="tab === 'status'" class="font-sans">
                <div class="w-full max-w-3xl mx-auto mt-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <!-- Header -->
                    <div class="p-5 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">Status Pendaftaran</h2>
                        <p class="text-sm text-gray-500">Proses pencarian pasangan hidup</p>
                    </div>

                    <!-- Progress Container - Horizontal -->
                    <div class="p-5">
                        <div class="flex flex-col">
                            <!-- Progress Steps - Horizontal -->
                            <div class="relative flex items-center justify-between mb-8">
                                <!-- Progress Line -->
                                <div class="absolute left-0 right-0 z-0 h-1 -translate-y-1/2 bg-gray-200 top-1/2"></div>

                                <!-- Step 1 - Pendaftaran -->
                                <div class="relative z-10 flex flex-col items-center">
                                    <div
                                        class="flex items-center justify-center w-8 h-8 mb-2 text-white rounded-full bg-emerald-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Pendaftaran</span>
                                </div>

                                <!-- Step 2 - Verifikasi -->
                                <div class="relative z-10 flex flex-col items-center">
                                    <div
                                        class="flex items-center justify-center w-8 h-8 mb-2 text-white rounded-full bg-emerald-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Verifikasi</span>
                                </div>

                                <!-- Step 3 - Penjodohan -->
                                <div class="relative z-10 flex flex-col items-center">
                                    <div
                                        class="flex items-center justify-center w-8 h-8 rounded-full
                            {{ $isMatched ? 'bg-emerald-500' : 'bg-blue-500' }} text-white mb-2">
                                        @if ($isMatched)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Penjodohan</span>
                                </div>
                            </div>

                            <!-- Status Detail -->
                            <div class="p-4 mt-6 rounded-lg bg-gray-50">
                                @if ($isMatched)
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 text-emerald-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-800">Jodoh Ditemukan!</h3>
                                                <p class="text-sm text-gray-600">Selamat! Kami telah menemukan pasangan
                                                    untuk Anda</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-sm md:mt-0">
                                            <p class="text-gray-700"><span class="font-medium">Nama:</span>
                                                {{ $matchName }}</p>
                                            <p class="text-gray-700"><span class="font-medium">Kecocokan:</span>
                                                {{ $matchPercentage }}%</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0 text-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-800">Dalam Proses</h3>
                                            <p class="text-sm text-gray-600">Tim kami sedang mencari pasangan yang
                                                cocok untuk Anda</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="flex justify-center mt-6">
                            <button @click="tab = 'informasi'"
                                class="px-5 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-100 rounded-md hover:bg-gray-200">
                                Kembali ke Beranda
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration form only shown if user hasn't registered -->
            <template x-if="!hasRegistered">
                <!-- Kontainer Utama -->
                <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col items-center gap-4">
                        <div x-show="tab === 'data_diri'">
                            <div class="grid w-3/4 grid-cols-2 gap-6 mt-8 md:grid-cols-2">
                                <input x-model="formData.nbm" name="nbm" type="number" placeholder="NBM"
                                    class="w-full p-3 border rounded-lg" required>
                                <input x-model="formData.nama_peserta" name="nama_peserta" type="text"
                                    placeholder="Nama" class="w-full p-3 border rounded-lg" required>

                                <input x-model="formData.tempat_lahir" name="tempat_lahir" type="text"
                                    placeholder="Tempat Lahir" class="w-full p-3 border rounded-lg" required>
                                <input x-model="formData.tanggal_lahir" name="tanggal_lahir" type="date"
                                    placeholder="Tanggal Lahir" class="w-full p-3 border rounded-lg" required>

                                <select x-model="formData.jenis_kelamin" name="jenis_kelamin"
                                    class="w-full p-3 border rounded-lg" required>
                                    <option disabled selected>Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>

                                <input x-model="formData.status" name="status" type="text" placeholder="Status"
                                    class="w-full p-3 border rounded-lg" required>

                                <input x-model="formData.tinggi_badan" name="tinggi_badan" type="number"
                                    placeholder="Tinggi Badan" class="w-full p-3 border rounded-lg" required>
                                <input x-model="formData.berat_badan" name="berat_badan" type="number"
                                    placeholder="Berat Badan" class="w-full p-3 border rounded-lg" required>

                                <input x-model="formData.alamat" name="alamat" type="text" placeholder="Alamat"
                                    class="w-full col-span-2 p-3 border rounded-lg" required>
                                <input x-model="formData.no_telepon" name="no_telepon" type="tel"
                                    placeholder="No. Telepon" class="w-full col-span-2 p-3 border rounded-lg"
                                    required>

                                <select x-model="formData.pendidikan" name="pendidikan"
                                    class="w-full p-3 border rounded-lg" required>
                                    <option disabled selected>Pendidikan</option>
                                    <option>SMA</option>
                                    <option>Sarjana</option>
                                    <option>Lainnya</option>
                                </select>

                                <select x-model="formData.pekerjaan" name="pekerjaan"
                                    class="w-full p-3 border rounded-lg" required>
                                    <option disabled selected>Pekerjaan</option>
                                    <option>PNS</option>
                                    <option>Wiraswasta</option>
                                    <option>Lainnya</option>
                                </select>

                                <select x-model="formData.penghasilan" name="penghasilan"
                                    class="w-full p-3 border rounded-lg" required>
                                    <option disabled selected>Penghasilan</option>
                                    <option>
                                        < 1 juta</option>
                                    <option>1–5 juta</option>
                                    <option>> 5 juta</option>
                                </select>

                                <!-- Riwayat Penyakit -->
                                <div class="col-span-2">
                                    <p class="mb-2 font-medium">Riwayat Penyakit</p>
                                    <div class="grid grid-cols-3 gap-2">
                                        <template
                                            x-for="penyakit in ['Asma', 'Hipertensi', 'Kanker', 'Gangguan Kejiwaan', 'Penyakit Jantung', 'Epilepsi', 'Diabetes']"
                                            :key="penyakit">
                                            <label>
                                                <input type="checkbox" name="riwayat_penyakit[]"
                                                    :value="penyakit" x-model="formData.riwayat_penyakit"
                                                    @change="updateRiwayatPenyakit($event, penyakit)" class="mr-1">
                                                <span x-text="penyakit"></span>
                                            </label>
                                        </template>
                                        <input x-model="formData.riwayat_penyakit_lain" type="text"
                                            name="riwayat_penyakit_lain" placeholder="Lainnya"
                                            class="col-span-3 p-2 border rounded-md">
                                    </div>
                                </div>

                                <!-- Upload KTP/SIM -->
                                <div class="col-span-2">
                                    <input type="file" name="ktp"
                                        @change="formData.ktp = $event.target.files[0]"
                                        class="w-full p-2 border rounded-md">
                                </div>

                                <!-- Riwayat organisasi -->
                                <div class="col-span-2">
                                    <input x-model="formData.riwayat_organisasi" type="text"
                                        name="riwayat_organisasi" placeholder="Riwayat Organisasi"
                                        class="w-full p-2 border rounded-md">
                                    <button type="button" class="mt-2 text-sm text-blue-600 hover:underline">+
                                        Tambahkan
                                        riwayat organisasi</button>
                                </div>
                            </div>
                        </div>

                        <!-- Kontainer Data Orang Tua -->
                        <div x-show="tab === 'data_orang_tua'">
                            <div class="w-3/4 mt-8 space-y-4">
                                <input x-model="formData.nama_ayah" name="nama_ayah" type="text"
                                    placeholder="Nama Ayah" class="w-full p-3 border rounded-lg" required>
                                <select x-model="formData.pekerjaan_ayah" name="pekerjaan_ayah"
                                    class="w-full p-3 border rounded-lg" required>
                                    <option value="">Pekerjaan Ayah</option>
                                    <option>Petani</option>
                                    <option>PNS</option>
                                    <option>Wiraswasta</option>
                                </select>
                                <input x-model="formData.nama_ibu" name="nama_ibu" type="text"
                                    placeholder="Nama Ibu" class="w-full p-3 border rounded-lg" required>
                                <select x-model="formData.pekerjaan_ibu" name="pekerjaan_ibu"
                                    class="w-full p-3 border rounded-lg" required>
                                    <option value="">Pekerjaan Ibu</option>
                                    <option>Ibu Rumah Tangga</option>
                                    <option>PNS</option>
                                    <option>Wiraswasta</option>
                                </select>

                            </div>
                        </div>


                        <!-- Kontainer Karakteristik: Muncul saat tab "karakteristik" -->
                        <div x-show="tab === 'karakteristik'">
                            <div class="flex justify-between w-full gap-8 px-10 mt-8">
                                <div>
                                    <h3 class="mb-2 text-2xl font-semibold">Karakteristik Diri Anda</h3>
                                    <div class="grid grid-cols-2 gap-2">
                                        <template
                                            x-for="item in ['Beriman', 'Seiman', 'Rajin', 'Setia', 'Sabar', 'Bertanggungjawab', 'Jujur', 'Sederhana', 'Ramah', 'Tertutup', 'Supel', 'Perhatian', 'Romantis', 'Cuek', 'Berpendidikan', 'Berpengalaman', 'Penurut', 'Ikhlas']"
                                            :key="item">
                                            <label>
                                                <input type="checkbox" name="karakteristik_diri[]"
                                                    x-model="formData.karakteristik_diri" :value="item"
                                                    class="mr-2">
                                                <span x-text="item"></span>
                                            </label>
                                        </template>
                                        <input x-model="formData.karakteristik_diri_lain" type="text"
                                            name="karakteristik_diri_lain" placeholder="Lainnya"
                                            class="w-full p-2 mt-2 border rounded-md">
                                    </div>
                                </div>
                                <div>
                                    <h3 class="mb-2 text-2xl font-semibold">Karakteristik Calon Pasangan Anda</h3>
                                    <div class="grid grid-cols-2 gap-2">
                                        <template
                                            x-for="item in ['Beriman', 'Seiman', 'Rajin', 'Setia', 'Sabar', 'Bertanggungjawab', 'Jujur', 'Sederhana', 'Ramah', 'Tertutup', 'Supel', 'Perhatian', 'Romantis', 'Cuek', 'Berpendidikan', 'Berpengalaman', 'Penurut', 'Ikhlas', 'Seumuran', 'Lebih Tua', 'Lebih Muda', 'Tidak Memandang Usia']"
                                            :key="item">
                                            <label>
                                                <input type="checkbox" name="karakteristik_pasangan[]"
                                                    x-model="formData.karakteristik_pasangan" :value="item"
                                                    class="mr-2">
                                                <span x-text="item"></span>
                                            </label>
                                        </template>
                                        <input x-model="formData.karakteristik_pasangan_lain" type="text"
                                            name="karakteristik_pasangan_lain" placeholder="Lainnya"
                                            class="w-full p-2 mt-2 border rounded-md">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div x-show="tab === 'pandangan'">
                            <div class="w-3/4 mt-8 space-y-4">
                                <input x-model="formData.visi_pernikahan" name="visi_pernikahan" type="text"
                                    placeholder="Visi Pernikahan" class="w-full p-3 border rounded-lg">
                                <input x-model="formData.misi_pernikahan" name="misi_pernikahan" type="text"
                                    placeholder="Misi Pernikahan" class="w-full p-3 border rounded-lg">
                                <input x-model="formData.cita_pernikahan" name="cita_pernikahan" type="text"
                                    placeholder="Cita-cita Pernikahan" class="w-full p-3 border rounded-lg">
                            </div>

                        </div>

                    </div>
                    <div x-show="tab === 'pandangan'">
                        <div class="flex justify-between mt-6">
                            <x-secondary-button @click="tab = 'karakteristik'">Kembali</x-secondary-button>
                            <x-primary-button type="submit">Kirim</x-primary-button>
                        </div>
                    </div>
                </form>
            </template>

            <!-- Navigation buttons -->
            <div x-show="tab === 'data_diri' && !hasRegistered">
                <div class="flex justify-between mt-6">
                    <x-secondary-button @click="tab = 'informasi'">Kembali</x-secondary-button>
                    <x-primary-button @click="tab = 'data_orang_tua'">Selanjutnya</x-primary-button>
                </div>
            </div>

            <div x-show="tab === 'data_orang_tua' && !hasRegistered">
                <div class="flex justify-between mt-6">
                    <x-secondary-button @click="tab = 'data_diri'">Kembali</x-secondary-button>
                    <x-primary-button @click="tab = 'karakteristik'">Selanjutnya</x-primary-button>
                </div>
            </div>

            <div x-show="tab === 'karakteristik' && !hasRegistered">
                <div class="flex justify-between mt-6">
                    <x-secondary-button @click="tab = 'data_orang_tua'">Kembali</x-secondary-button>
                    <x-primary-button @click="tab = 'pandangan'">Selanjutnya</x-primary-button>
                </div>
            </div>
        </div>
    </div>

    <x-footer />
</x-app-layout>
