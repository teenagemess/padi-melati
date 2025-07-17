<x-app-layout>
    <div class="min-h-screen py-12 bg-primary">
        <div class="container px-4 mx-auto">
            <h1 class="mb-10 text-4xl font-bold text-center text-white">Formulir Pendaftaran</h1>
            <form x-data="{
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
                    ktp: '',
                    riwayat_organisasi: '',
                    nama_ayah: '',
                    pekerjaan_ayah: '',
                    nama_ibu: '',
                    pekerjaan_ibu: '',
                    karakteristik_diri: [],
                    karakteristik_diri_lain: '',
                    karakteristik_pasangan: [],
                    karakteristik_pasangan_lain: '',
                    preferred_age: '',
                    visi_pernikahan: '',
                    misi_pernikahan: '',
                    cita_pernikahan: ''
                },
                errors: {},
                hasRegistered: {{ $hasRegistered ? 'true' : 'false' }},
                validateForm() {
                    this.errors = {};
                    let hasError = false;
            
                    if (this.tab === 'data_diri') {
                        if (!this.formData.nbm) {
                            this.errors.nbm = 'NBM wajib diisi';
                            hasError = true;
                        }
                        if (!this.formData.nama_peserta) {
                            this.errors.nama_peserta = 'Nama wajib diisi';
                            hasError = true;
                        }
                        if (!this.formData.tempat_lahir) {
                            this.errors.tempat_lahir = 'Tempat lahir wajib diisi';
                            hasError = true;
                        }
                        if (!this.formData.tanggal_lahir) {
                            this.errors.tanggal_lahir = 'Tanggal lahir wajib diisi';
                            hasError = true;
                        } else if (new Date(this.formData.tanggal_lahir) > new Date()) {
                            this.errors.tanggal_lahir = 'Tanggal lahir tidak boleh di masa depan';
                            hasError = true;
                        } else {
                            const age = this.calculateAge();
                            if (age < 18 || age > 100) {
                                this.errors.tanggal_lahir = 'Usia harus antara 18 dan 100 tahun';
                                hasError = true;
                            }
                        }
                        if (!this.formData.jenis_kelamin) {
                            this.errors.jenis_kelamin = 'Jenis kelamin wajib dipilih';
                            hasError = true;
                        }
                        if (!this.formData.status) {
                            this.errors.status = 'Status wajib dipilih';
                            hasError = true;
                        }
                        if (!this.formData.tinggi_badan) {
                            this.errors.tinggi_badan = 'Tinggi badan wajib diisi';
                            hasError = true;
                        } else if (this.formData.tinggi_badan < 100 || this.formData.tinggi_badan > 250) {
                            this.errors.tinggi_badan = 'Tinggi badan harus antara 100-250 cm';
                            hasError = true;
                        }
                        if (!this.formData.berat_badan) {
                            this.errors.berat_badan = 'Berat badan wajib diisi';
                            hasError = true;
                        } else if (this.formData.berat_badan < 30 || this.formData.berat_badan > 200) {
                            this.errors.berat_badan = 'Berat badan harus antara 30-200 kg';
                            hasError = true;
                        }
                        if (!this.formData.alamat) {
                            this.errors.alamat = 'Alamat wajib diisi';
                            hasError = true;
                        }
                        if (!this.formData.no_telepon) {
                            this.errors.no_telepon = 'No. telepon wajib diisi';
                            hasError = true;
                        } else if (!/^\d{10,13}$/.test(this.formData.no_telepon)) {
                            this.errors.no_telepon = 'No. telepon harus 10-13 digit angka';
                            hasError = true;
                        }
                        if (!this.formData.pendidikan) {
                            this.errors.pendidikan = 'Pendidikan wajib dipilih';
                            hasError = true;
                        }
                        if (!this.formData.pekerjaan) {
                            this.errors.pekerjaan = 'Pekerjaan wajib dipilih';
                            hasError = true;
                        }
                        if (!this.formData.penghasilan) {
                            this.errors.penghasilan = 'Penghasilan wajib dipilih';
                            hasError = true;
                        }
                        if (!document.getElementById('ktp').files[0]) {
                            this.errors.ktp = 'File KTP wajib diunggah';
                            hasError = true;
                        }
                    } else if (this.tab === 'data_orang_tua') {
                        if (!this.formData.nama_ayah) {
                            this.errors.nama_ayah = 'Nama ayah wajib diisi';
                            hasError = true;
                        }
                        if (!this.formData.pekerjaan_ayah) {
                            this.errors.pekerjaan_ayah = 'Pekerjaan ayah wajib dipilih';
                            hasError = true;
                        }
                        if (!this.formData.nama_ibu) {
                            this.errors.nama_ibu = 'Nama ibu wajib diisi';
                            hasError = true;
                        }
                        if (!this.formData.pekerjaan_ibu) {
                            this.errors.pekerjaan_ibu = 'Pekerjaan ibu wajib dipilih';
                            hasError = true;
                        }
                    } else if (this.tab === 'karakteristik') {
                        if (this.formData.karakteristik_diri.length === 0 && !this.formData.karakteristik_diri_lain) {
                            this.errors.karakteristik_diri = 'Pilih setidaknya satu karakteristik diri atau isi kolom lainnya';
                            hasError = true;
                        }
                        if (this.formData.karakteristik_pasangan.length === 0 && !this.formData.karakteristik_pasangan_lain && !this.formData.preferred_age) {
                            this.errors.karakteristik_pasangan = 'Pilih setidaknya satu karakteristik pasangan, isi kolom lainnya, atau pilih kriteria usia';
                            hasError = true;
                        }
                        if (!this.formData.preferred_age) {
                            this.errors.preferred_age = 'Kriteria usia wajib dipilih';
                            hasError = true;
                        }
                    } else if (this.tab === 'pandangan') {
                        if (!this.formData.visi_pernikahan) {
                            this.errors.visi_pernikahan = 'Visi pernikahan wajib diisi';
                            hasError = true;
                        }
                        if (!this.formData.misi_pernikahan) {
                            this.errors.misi_pernikahan = 'Misi pernikahan wajib diisi';
                            hasError = true;
                        }
                        if (!this.formData.cita_pernikahan) {
                            this.errors.cita_pernikahan = 'Cita-cita pernikahan wajib diisi';
                            hasError = true;
                        }
                    }
            
                    if (hasError) {
                        return false;
                    }
                    return true;
                },
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
                },
                calculateAge() {
                    if (this.formData.tanggal_lahir) {
                        const birthDate = new Date(this.formData.tanggal_lahir);
                        const today = new Date();
                        let age = today.getFullYear() - birthDate.getFullYear();
                        const monthDiff = today.getMonth() - birthDate.getMonth();
                        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                            age--;
                        }
                        return age;
                    }
                    return '';
                }
            }" action="{{ route('pendaftaran.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div x-show="tab === 'informasi'">
                    <!-- Informasi tab content -->
                </div>
                <div x-show="tab === 'data_diri'">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <!-- Other fields (nbm, nama_peserta, etc.) -->
                        <div class="relative">
                            <label for="tanggal_lahir" class="block mb-1 text-sm font-medium text-gray-700">Tanggal
                                Lahir <span class="text-red-500">*</span></label>
                            <input x-model="formData.tanggal_lahir" name="tanggal_lahir" type="date"
                                id="tanggal_lahir"
                                class="w-full p-3 border rounded-lg @error('tanggal_lahir') border-red-500 @enderror"
                                required @change="errors.tanggal_lahir = ''">
                            <div x-show="formData.tanggal_lahir" x-text="'Usia: ' + calculateAge() + ' tahun'"
                                class="mt-1 text-sm text-gray-500"></div>
                            <div x-show="errors.tanggal_lahir" x-text="errors.tanggal_lahir"
                                class="mt-1 text-sm text-red-500"></div>
                            @error('tanggal_lahir')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Other fields (jenis_kelamin, status, etc.) -->
                    </div>
                </div>
                <div x-show="tab === 'data_orang_tua'">
                    <!-- Data Orang Tua tab content -->
                </div>
                <div x-show="tab === 'karakteristik'">
                    <div class="flex justify-between w-full gap-8 px-10 mt-8">
                        <div>
                            <h3 class="mb-2 text-2xl font-semibold">Karakteristik Diri Anda <span
                                    class="text-red-500">*</span></h3>
                            <div class="grid grid-cols-2 gap-2">
                                <template
                                    x-for="item in ['Beriman', 'Seiman', 'Rajin', 'Setia', 'Sabar', 'Bertanggungjawab', 'Jujur', 'Sederhana', 'Ramah', 'Tertutup', 'Supel', 'Perhatian', 'Romantis', 'Cuek', 'Berpendidikan', 'Berpengalaman', 'Penurut', 'Ikhlas']"
                                    :key="item">
                                    <label>
                                        <input type="checkbox" name="karakteristik_diri[]"
                                            x-model="formData.karakteristik_diri" :value="item" class="mr-2"
                                            @change="toggleKarakteristikDiri(item)">
                                        <span x-text="item"></span>
                                    </label>
                                </template>
                                <input x-model="formData.karakteristik_diri_lain" type="text"
                                    name="karakteristik_diri_lain" placeholder="Lainnya"
                                    class="w-full p-2 mt-2 border rounded-md @error('karakteristik_diri_lain') border-red-500 @enderror">
                                <div x-show="errors.karakteristik_diri" x-text="errors.karakteristik_diri"
                                    class="mt-1 text-sm text-red-500"></div>
                                @error('karakteristik_diri')
                                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                                @error('karakteristik_diri_lain')
                                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <h3 class="mb-2 text-2xl font-semibold">Karakteristik Calon Pasangan Anda <span
                                    class="text-red-500">*</span></h3>
                            <div class="grid grid-cols-2 gap-2">
                                <template
                                    x-for="item in ['Beriman', 'Seiman', 'Rajin', 'Setia', 'Sabar', 'Bertanggungjawab', 'Jujur', 'Sederhana', 'Ramah', 'Tertutup', 'Supel', 'Perhatian', 'Romantis', 'Cuek', 'Berpendidikan', 'Berpengalaman', 'Penurut', 'Ikhlas']"
                                    :key="item">
                                    <label>
                                        <input type="checkbox" name="karakteristik_pasangan[]"
                                            x-model="formData.karakteristik_pasangan" :value="item"
                                            class="mr-2" @change="toggleKarakteristikPasangan(item)">
                                        <span x-text="item"></span>
                                    </label>
                                </template>
                                <input x-model="formData.karakteristik_pasangan_lain" type="text"
                                    name="karakteristik_pasangan_lain" placeholder="Lainnya"
                                    class="w-full p-2 mt-2 border rounded-md @error('karakteristik_pasangan_lain') border-red-500 @enderror">
                                <div x-show="errors.karakteristik_pasangan" x-text="errors.karakteristik_pasangan"
                                    class="mt-1 text-sm text-red-500"></div>
                                @error('karakteristik_pasangan')
                                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                                @error('karakteristik_pasangan_lain')
                                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <label for="preferred_age" class="block mb-1 text-sm font-medium text-gray-700">Kriteria
                                    Usia <span class="text-red-500">*</span></label>
                                <select x-model="formData.preferred_age" name="preferred_age" id="preferred_age"
                                    class="w-full p-3 border rounded-lg @error('preferred_age') border-red-500 @enderror"
                                    required>
                                    <option value="" disabled selected>Pilih kriteria usia</option>
                                    <option value="Seumuran">Seumuran</option>
                                    <option value="Lebih Tua">Lebih Tua</option>
                                    <option value="Lebih Muda">Lebih Muda</option>
                                </select>
                                <div x-show="errors.preferred_age" x-text="errors.preferred_age"
                                    class="mt-1 text-sm text-red-500"></div>
                                @error('preferred_age')
                                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div x-show="tab === 'pandangan'">
                    <!-- Pandangan tab content -->
                </div>
                <div x-show="tab === 'status'">
                    <!-- Status tab content -->
                </div>
                <!-- Navigation buttons -->
            </form>
        </div>
    </div>
</x-app-layout>
