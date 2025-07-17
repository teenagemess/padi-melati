<x-app-layout>

    <!-- *** Main ***-->

    <div class="flex items-center h-[50vh] px-10 bg-primary">
    </div>

    <div class="max-w-3xl mx-auto mt-[-200px]" x-data="{ tab: 'personal' }">
        <div class="relative p-6 text-center bg-white rounded-lg shadow-lg">
            <!-- Profile Image with Hover Effect -->
            <div class="relative mx-auto -mt-16 w-52 h-52 group">
                <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'images/fotodummy.jpg' }}"
                    class="object-cover w-full h-full border-4 border-white rounded-full" alt="Profile">

                <!-- Hover Overlay -->
                <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 bg-black bg-opacity-50 rounded-full opacity-0 cursor-pointer group-hover:opacity-100"
                    x-data="" x-on:click.prevent="$dispatch('open-modal', 'image-edit')">
                    <div class="text-center text-white">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <p class="text-sm font-medium">Ubah Foto</p>
                    </div>
                </div>
            </div>

            @auth
                <h2 class="mt-4 text-xl font-bold">{{ Auth::user()->name }}</h2>
            @endauth
            <p class="text-gray-500">Pengguna</p>

            <div class="flex justify-center mt-4 border-b">
                <button @click="tab = 'personal'" class="w-1/2 px-4 py-2 border-b-2"
                    :class="{ 'border-black font-bold': tab === 'personal' }">Personal</button>
                <button @click="tab = 'akun'" class="w-1/2 px-4 py-2 border-b-2"
                    :class="{ 'border-black font-bold': tab === 'akun' }">Akun</button>
            </div>

            <form class="mt-6" method="POST" action="{{ route('logout') }}">
                @csrf
                <x-danger-button :href="route('logout')"
                    onclick="event.preventDefault();
                this.closest('form').submit();">
                    {{ __('Keluar') }}
                </x-danger-button>
            </form>

        </div>

        <div x-show="tab === 'personal'" class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <form method="post" action="{{ route('profile.update-data-diri') }}">
                @csrf
                @method('patch')

                <!-- Data Diri Section -->
                <div class="space-y-6">
                    <!-- NBM -->
                    <div class="flex flex-col gap-2">
                        <x-input-label for="nbm" :value="__('NBM')" />
                        <x-text-input id="nbm" name="nbm" type="text"
                            value="{{ old('nbm', $dataDiri->nbm ?? '') }}" autocomplete="nbm" required />
                        <x-input-error :messages="$errors->get('nbm')" class="mt-2" />
                    </div>

                    <!-- Nama Peserta -->
                    <div class="flex flex-col gap-2">
                        <x-input-label for="nama_peserta" :value="__('Nama Lengkap')" />
                        <x-text-input id="nama_peserta" name="nama_peserta" type="text"
                            value="{{ old('nama_peserta', $dataDiri->nama_peserta ?? '') }}" autocomplete="nama_peserta"
                            required />
                        <x-input-error :messages="$errors->get('nama_peserta')" class="mt-2" />
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="flex flex-col gap-2">
                        <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                        <select id="jenis_kelamin" name="jenis_kelamin" required
                            class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            autocomplete="jenis_kelamin">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki"
                                {{ old('jenis_kelamin', $dataDiri->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan"
                                {{ old('jenis_kelamin', $dataDiri->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="flex flex-col gap-2">
                        <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                        <x-text-input id="tempat_lahir" name="tempat_lahir" type="text"
                            value="{{ old('tempat_lahir', $dataDiri->tempat_lahir ?? '') }}"
                            autocomplete="address-level2" required />
                        <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                    </div>

                    <!-- Tanggal Lahir -->
                    {{-- <div class="flex flex-col gap-2">
                        <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                        <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date"
                            value="{{ old('tanggal_lahir', isset($dataDiri->tanggal_lahir) ? $dataDiri->tanggal_lahir->format('Y-m-d') : '') }}"
                            autocomplete="bday" required />
                        <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                    </div> --}}

                    <!-- Alamat -->
                    <div class="flex flex-col gap-2">
                        <x-input-label for="alamat" :value="__('Alamat')" />
                        <textarea id="alamat" name="alamat" rows="3" required
                            class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            autocomplete="street-address">{{ old('alamat', $dataDiri->alamat ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <!-- No Telepon -->
                    <div class="flex flex-col gap-2">
                        <x-input-label for="no_telepon" :value="__('No. Telepon')" />
                        <x-text-input id="no_telepon" name="no_telepon" type="tel"
                            value="{{ old('no_telepon', $dataDiri->no_telepon ?? '') }}" autocomplete="tel" required />
                        <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                    </div>

                    <!-- Tinggi Badan -->
                    <div class="flex flex-col gap-2">
                        <x-input-label for="tinggi_badan" :value="__('Tinggi Badan (cm)')" />
                        <x-text-input id="tinggi_badan" name="tinggi_badan" type="number"
                            value="{{ old('tinggi_badan', $dataDiri->tinggi_badan ?? '') }}" autocomplete="off"
                            required />
                        <x-input-error :messages="$errors->get('tinggi_badan')" class="mt-2" />
                    </div>

                    <!-- Berat Badan -->
                    <div class="flex flex-col gap-2">
                        <x-input-label for="berat_badan" :value="__('Berat Badan (kg)')" />
                        <x-text-input id="berat_badan" name="berat_badan" type="number"
                            value="{{ old('berat_badan', $dataDiri->berat_badan ?? '') }}" autocomplete="off"
                            required />
                        <x-input-error :messages="$errors->get('berat_badan')" class="mt-2" />
                    </div>

                    <!-- Pendidikan -->
                    <div class="flex flex-col gap-2">
                        <x-input-label for="pendidikan" :value="__('Pendidikan Terakhir')" />
                        <x-text-input id="pendidikan" name="pendidikan" type="text"
                            value="{{ old('pendidikan', $dataDiri->pendidikan ?? '') }}"
                            autocomplete="education-level" required />
                        <x-input-error :messages="$errors->get('pendidikan')" class="mt-2" />
                    </div>

                    <!-- Pekerjaan -->
                    <div class="flex flex-col gap-2">
                        <x-input-label for="pekerjaan" :value="__('Pekerjaan')" />
                        <x-text-input id="pekerjaan" name="pekerjaan" type="text"
                            value="{{ old('pekerjaan', $dataDiri->pekerjaan ?? '') }}"
                            autocomplete="organization-title" required />
                        <x-input-error :messages="$errors->get('pekerjaan')" class="mt-2" />
                    </div>

                    <!-- Penghasilan -->
                    <div class="flex flex-col gap-2">
                        <x-input-label for="penghasilan" :value="__('Penghasilan per Bulan')" />
                        <x-text-input id="penghasilan" name="penghasilan" type="text"
                            value="{{ old('penghasilan', $dataDiri->penghasilan ?? '') }}"
                            autocomplete="transaction-amount" required />
                        <x-input-error :messages="$errors->get('penghasilan')" class="mt-2" />
                    </div>
                </div>

                <!-- Button Submit -->
                <div class="flex justify-end pt-6 mt-6 border-t">
                    <x-primary-button type="submit" class="px-6 py-3">
                        {{ __('Simpan Perubahan') }}
                    </x-primary-button>
                </div>

            </form>
        </div>

        <div x-show="tab === 'akun'" class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <div class="space-y-4">
                <x-input-label for="email" :value="__('Email')" />
                <div class="flex items-center">
                    <x-text-input id="email" name="email" type="email" readonly class="block w-full"
                        :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    <span class="ml-2 cursor-pointer" x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'email-edit')">✏️</span>
                </div>

                <x-input-label for="name" :value="__('Nama')" />
                <div class="flex items-center">
                    <x-text-input readonly id="name" name="name" type="text" class="block w-full"
                        :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    <span class="ml-2 cursor-pointer" x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'nama-edit')">✏️</span>
                </div>

                <x-input-label for="password" :value="__('Kata sandi')" />
                <div class="flex items-center">
                    <x-text-input readonly value="***********" id="update_password_current_password"
                        name="current_password" type="password" class="block w-full"
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    <span class="ml-2 cursor-pointer" x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'password-edit')">
                        ✏️</span>
                </div>
            </div>
        </div>



        <!-- *** Modals ***-->

        <!--Modal Image Upload-->
        <x-modal name="image-edit">
            <form method="post" action="{{ route('profile.image.update') }}" class="p-6"
                enctype="multipart/form-data">
                @csrf
                @method('patch')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Ubah Foto Profil') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Pilih foto baru untuk profil Anda. Format yang didukung: JPEG, PNG, JPG, GIF. Ukuran maksimal 2MB.
                </p>

                <!-- Current Image Preview -->
                <div class="mt-4 mb-4">
                    <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'images/fotodummy.jpg' }}"
                        class="object-cover w-24 h-24 mx-auto border-2 border-gray-300 rounded-full"
                        alt="Current Profile">
                    <p class="mt-2 text-xs text-center text-gray-500">Foto saat ini</p>
                </div>

                <div>
                    <x-input-label for="image" :value="__('Pilih Foto Baru')" />
                    <input id="image" name="image" type="file"
                        class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        accept="image/*" required />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-4 mt-6">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-secondary-button>
                    <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                </div>

                @if (session('status') === 'image-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="mt-2 text-sm text-green-600 dark:text-green-400">
                        {{ __('Foto profil berhasil diperbarui!') }}</p>
                @endif

                @if (session('error'))
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                        class="mt-2 text-sm text-red-600 dark:text-red-400">{{ session('error') }}</p>
                @endif
            </form>
        </x-modal>

        <!--Modal Email-->
        <x-modal name="email-edit">
            <form method="post" action="{{ route('profile.update.email') }}" class="p-6">
                @csrf
                @method('patch')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Ubah Alamat Email') }}
                </h2>

                @auth
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-400">
                        Email Anda saat ini adalah <span class="text-blue-700 underline">{{ Auth::user()->email }}</span>
                        Ingin menggantinya dengan email lain?
                    </p>
                @endauth

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email Baru')" />
                    <x-text-input placeholder="Alamat Email" id="email" class="block w-full mt-1" type="email"
                        name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-4 mt-6">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-secondary-button>
                    <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                </div>

                @if (session('status') === 'email-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="mt-2 text-sm text-green-600 dark:text-green-400">
                        {{ __('Email berhasil diperbarui!') }}
                    </p>
                @endif
            </form>
        </x-modal>

        <!--Modal Nama-->
        <x-modal name="nama-edit">
            <form method="post" action="{{ route('profile.update.name') }}" class="p-6">
                @csrf
                @method('patch')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Ubah Nama') }}
                </h2>

                <div class="mt-4">
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input placeholder="Nama" id="name" name="name" type="text"
                        class="block w-full mt-1" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="flex items-center justify-end gap-4 mt-6">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-secondary-button>
                    <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                </div>

                @if (session('status') === 'name-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="mt-2 text-sm text-green-600 dark:text-green-400">
                        {{ __('Nama berhasil diperbarui!') }}
                    </p>
                @endif
            </form>
        </x-modal>

        <!--Modals Password-->
        <x-modal name="password-edit">
            <form method="post" action="{{ route('password.update') }}" class="p-6">
                @csrf
                @method('put')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Ubah Kata Sandi') }}
                </h2>

                <div>
                    <x-text-input placeholder="Kata sandi saat ini" id="update_password_current_password"
                        name="current_password" type="password" class="block w-full mt-1 mb-3"
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <x-text-input placeholder="Kata sandi baru" id="update_password_password" name="password"
                        type="password" class="block w-full mt-1 mb-3" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-text-input placeholder="Konfirmasi kata sandi" id="update_password_password_confirmation"
                        name="password_confirmation" type="password" class="block w-full mt-1 mb-3"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-end justify-end gap-4">
                    <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </x-modal>
    </div>

</x-app-layout>
