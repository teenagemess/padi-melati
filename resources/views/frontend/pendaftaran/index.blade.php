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
            <div x-show="tab === 'status'">
                <div class="w-3/4 p-4 mx-auto mt-8 bg-white rounded-lg shadow">
                    <template x-if="hasRegistered">
                        <div>
                            <h3 class="mb-4 text-xl font-semibold">Status Pendaftaran Anda</h3>
                            <p class="mb-2 text-green-600">✓ Pendaftaran telah selesai</p>
                            <p class="mb-4">Data Anda sedang dalam proses verifikasi oleh admin.</p>
                            <!-- You can add more status details here as needed -->
                        </div>
                    </template>
                    <template x-if="!hasRegistered">
                        <div>
                            <h3 class="mb-4 text-xl font-semibold">Status Pendaftaran Anda</h3>
                            <p class="mb-2 text-red-600">✗ Anda belum melakukan pendaftaran</p>
                            <p class="mb-4">Silakan lakukan pendaftaran terlebih dahulu.</p>
                        </div>
                    </template>
                    <button @click="tab = 'informasi'"
                        class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                        Kembali
                    </button>
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
                                <input x-model="formData.nbm" name="nbm" type="text" placeholder="NBM"
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

                                <input x-model="formData.tinggi_badan" name="tinggi_badan" type="text"
                                    placeholder="Tinggi Badan" class="w-full p-3 border rounded-lg" required>
                                <input x-model="formData.berat_badan" name="berat_badan" type="text"
                                    placeholder="Berat Badan" class="w-full p-3 border rounded-lg" required>

                                <input x-model="formData.alamat" name="alamat" type="text" placeholder="Alamat"
                                    class="w-full col-span-2 p-3 border rounded-lg" required>
                                <input x-model="formData.no_telepon" name="no_telepon" type="tel"
                                    placeholder="No. Telepon" class="w-full col-span-2 p-3 border rounded-lg" required>

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
