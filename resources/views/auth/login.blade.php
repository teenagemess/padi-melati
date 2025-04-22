<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h1 class="mb-1 text-5xl font-bold text-white dark:text-white">
            Selamat Datang!
        </h1>
        <p class="mb-20 text-center text-white dark:text-gray-300">
            Masukkan kredensial Anda untuk mengakses akun Anda
        </p>

        <!-- Email Address -->
        <div>
            {{-- <x-input-label for="email" :value="__('Email')" /> --}}
            <x-text-input placeholder="Alamat Email" id="email" class="block w-full mt-1" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            {{-- <x-input-label for="password" :value="__('Password')" /> --}}
            <x-text-input placeholder="Kata Sandi" id="password" class="block w-full mt-1" type="password"
                name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="text-indigo-600 border-gray-300 rounded shadow-sm dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="text-sm text-black ms-2 dark:text-gray-400">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <x-primary-button class="justify-center w-full mt-4">
            {{ __('Masuk') }}
        </x-primary-button>

        <div class="flex items-center justify-center mt-4 ">
            @if (Route::has('password.request'))
                <a class="text-sm rounded-md text-black0 dark:text-gray-400 hover:underline hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Lupa Kata Sandi?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-center mt-2">
            <p class="text-sm text-center text-black dark:text-gray-300">
                Tidak mempunyai akun?
            </p>
            <a href="{{ route('register') }}" class="ml-2 text-sm text-white hover:underline dark:text-gray-300">
                Daftar
            </a>
        </div>
    </form>
</x-guest-layout>
