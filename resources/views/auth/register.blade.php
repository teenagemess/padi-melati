<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            {{-- <x-input-label for="name" :value="__('Nama Lengkap')" /> --}}
            <x-text-input placeholder="Nama Lengkap" id="name" class="block w-full mt-1" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            {{-- <x-input-label for="email" :value="__('Alamat Email')" /> --}}
            <x-text-input placeholder="Alamat Email" id="email" class="block w-full mt-1" type="email"
                name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4">
            {{-- <x-input-label for="username" :value="__('Nama Pengguna')" /> --}}
            <x-text-input placeholder="Nama Pengguna" id="username" class="block w-full mt-1" type="text"
                name="username" :value="old('username')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            {{-- <x-input-label for="password" :value="__('Kata Sandi')" /> --}}
            <x-text-input placeholder="Kata Sandi" id="password" class="block w-full mt-1" type="password"
                name="password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            {{-- <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" /> --}}
            <x-text-input placeholder="Konfirmasi Kata Sandi" id="password_confirmation" class="block w-full mt-1"
                type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="justify-center w-full mt-6">
            {{ __('Daftar') }}
        </x-primary-button>

        <div class="flex items-center justify-center mt-4">
            <p class="text-sm text-center text-black dark:text-gray-300">
                Sudah mempunyai akun?
            </p>
            <a class="ml-2 text-sm text-white rounded-md dark:text-gray-400 hover:underlined dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Masuk') }}
            </a>

        </div>
    </form>
</x-guest-layout>
