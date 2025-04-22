<x-app-layout>
    <!-- Alpine.js State -->
    <div x-data="{ tab: 'informasi' }" class="flex justify-center min-h-[80vh] bg-primary">
        <div class="w-full p-12 bg-[#D9D9D9] max-w-7xl rounded-b-xl">
            <!-- Judul Dinamis -->
            <template x-if="tab === 'informasi'">
                <h2 class="mb-6 text-4xl font-semibold text-start mt-14">Informasi Pendaftaran</h2>
            </template>
            <template x-if="tab === 'daftar'">
                <h2 class="mb-6 text-4xl font-semibold text-center mt-14">Data Orang Tua</h2>
            </template>
            <template x-if="tab === 'karakteristik'">
                <h2 class="mb-6 text-4xl font-semibold text-center mt-14">Karakteristik Diri dan Calon</h2>
            </template>
            <template x-if="tab === 'pandangan'">
                <h2 class="mb-6 text-4xl font-semibold text-center mt-14">Pandangan Pernikahan</h2>
            </template>

            <template x-if="tab === 'informasi'">
                <div class="items-start space-x-4">
                    <x-primary-button @click="tab = 'daftar'">
                        Daftar
                    </x-primary-button>
                    <x-primary-button @click="tab = 'status'">
                        Status Pendaftaran
                    </x-primary-button>
                </div>
            </template>

            <!-- Kontainer Utama -->
            <div class="flex flex-col items-center gap-4">
                <!-- Tombol Pilihan: Hanya muncul pada tab "informasi" -->
                <!-- Kontainer Daftar: Muncul saat tab "daftar" -->
                <template x-if="tab === 'daftar'">
                    <div class="w-3/4 mt-8 space-y-4">
                        <input type="text" placeholder="Nama Ayah" class="w-full p-3 border rounded-lg">
                        <select class="w-full p-3 border rounded-lg">
                            <option>Pekerjaan Ayah</option>
                            <option>Petani</option>
                            <option>PNS</option>
                            <option>Wiraswasta</option>
                        </select>
                        <input type="text" placeholder="Nama Ibu" class="w-full p-3 border rounded-lg">
                        <select class="w-full p-3 border rounded-lg">
                            <option>Pekerjaan Ibu</option>
                            <option>Ibu Rumah Tangga</option>
                            <option>PNS</option>
                            <option>Wiraswasta</option>
                        </select>
                    </div>
                </template>

                <!-- Kontainer Karakteristik: Muncul saat tab "karakteristik" -->
                <template x-if="tab === 'karakteristik'">
                    <div class="flex justify-between w-full gap-8 px-10 mt-8">
                        <div>
                            <h3 class="mb-2 text-2xl font-semibold">Karakteristik Diri Anda</h3>
                            <div class="grid grid-cols-2 gap-2">
                                <template
                                    x-for="item in ['Beriman', 'Seiman', 'Rajin', 'Setia', 'Sabar', 'Bertanggungjawab', 'Jujur', 'Sederhana', 'Ramah', 'Tertutup', 'Supel', 'Perhatian', 'Romantis', 'Cuek', 'Berpendidikan', 'Berpengalaman', 'Penurut', 'Ikhlas']"
                                    :key="item">
                                    <label>
                                        <input type="checkbox" class="mr-2">
                                        <span x-text="item"></span>
                                    </label>
                                </template>
                                <input type="text" placeholder="Lainnya" class="w-full p-2 mt-2 border rounded-md">
                            </div>
                        </div>
                        <div>
                            <h3 class="mb-2 text-2xl font-semibold">Karakteristik Calon Pasangan Anda</h3>
                            <div class="grid grid-cols-2 gap-2">
                                <template
                                    x-for="item in ['Beriman', 'Seiman', 'Rajin', 'Setia', 'Sabar', 'Bertanggungjawab', 'Jujur', 'Sederhana', 'Ramah', 'Tertutup', 'Supel', 'Perhatian', 'Romantis', 'Cuek', 'Berpendidikan', 'Berpengalaman', 'Penurut', 'Ikhlas', 'Seumuran', 'Lebih Tua', 'Lebih Muda', 'Tidak Memandang Usia']"
                                    :key="item">
                                    <label>
                                        <input type="checkbox" class="mr-2">
                                        <span x-text="item"></span>
                                    </label>
                                </template>
                                <input type="text" placeholder="Lainnya" class="w-full p-2 mt-2 border rounded-md">
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="tab === 'pandangan'">
                    <div class="w-3/4 mt-8 space-y-4">
                        <input type="text" placeholder="Visi Pernikahan" class="w-full p-3 border rounded-lg">
                        <input type="text" placeholder="Misi Pernikahan" class="w-full p-3 border rounded-lg">
                        <input type="text" placeholder="Cita-cita Pernikahan" class="w-full p-3 border rounded-lg">
                    </div>
                </template>

            </div>
            <!-- Navigasi pada tab "daftar" -->
            <template x-if="tab === 'daftar'">
                <div class="flex justify-between mt-6">
                    <x-secondary-button @click="tab = 'informasi'">Kembali</x-secondary-button>
                    <x-primary-button @click="tab = 'karakteristik'">Selanjutnya</x-primary-button>
                </div>
            </template>

            <!-- Navigasi pada tab "karakteristik" -->
            <template x-if="tab === 'karakteristik'">
                <div class="flex justify-between mt-6">
                    <x-secondary-button @click="tab = 'daftar'">Kembali</x-secondary-button>
                    <x-primary-button @click="tab = 'pandangan'">Selanjutnya</x-primary-button>
                </div>
            </template>

            <!-- Navigasi pada tab "karakteristik" -->
            <template x-if="tab === 'pandangan'">
                <div class="flex justify-between mt-6">
                    <x-secondary-button @click="tab = 'karakteristik'">Kembali</x-secondary-button>
                    <x-primary-button>Kirim</x-primary-button>
                </div>
            </template>
        </div>
    </div>

    <x-footer />
</x-app-layout>
