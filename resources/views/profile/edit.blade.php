<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Versi Padi Melati !-->


    <!-- *** Main ***-->

    <div class="flex items-center h-[50vh] px-10 bg-primary">
    </div>

    <div class="max-w-3xl mx-auto mt-[-200px]" x-data="{ tab: 'personal' }">
        <div class="relative p-6 text-center bg-white rounded-lg shadow-lg">
            <img src="images/fotodummy.jpg" class="mx-auto -mt-16 border-4 border-white rounded-full w-52 h-52"
                alt="Profile">
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
                        name="current_password" type="password" class="block w-full" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    <span class="ml-2 cursor-pointer" x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'password-edit')">
                        ✏️</span>
                </div>
            </div>
        </div>



        <!-- *** Modals ***-->


        <!--Modals Email-->
        <x-modal name="email-edit">
            <form method="post" action="{{ route('profile.update') }}" class="p-6">
                @csrf
                @method('patch')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Ubah Alamat Email') }}
                </h2>

                @auth
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-400">

                        Email Anda saat ini adalah <span class="text-blue-700 underline">{{ Auth::user()->email }} </span>
                        Ingin menggantinya dengan email
                        lain?
                    </p>
                @endauth

                <div>
                    <x-text-input placeholder="Alamat Email" id="email" class="block w-full mt-1" type="email"
                        name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-4 mt-3">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </x-modal>

        <!--Modals Nama-->
        <x-modal name="nama-edit">
            <form method="post" action="{{ route('profile.update') }}" class="p-6">
                @csrf
                @method('patch')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Ubah Nama') }}
                </h2>

                {{-- <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p> --}}

                <div>
                    <x-text-input placeholder="Nama" id="name" name="name" type="text"
                        class="block w-full mt-1" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="flex items-center justify-end gap-4 mt-3">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                    @endif
                </div>
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
