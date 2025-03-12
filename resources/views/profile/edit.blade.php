<x-app-layout>
    <x-slot name="header">
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
    </div>

    <!-- Versi Padi Melati !-->

    {{-- <div class="flex items-center h-[50vh] px-10 bg-primary">
    </div>

    <div class="max-w-3xl mx-auto mt-[-200px]" x-data="{ tab: 'personal' }">
        <div class="relative p-6 text-center bg-white rounded-lg shadow-lg">
            <img src="https://s3-alpha-sig.figma.com/img/57df/b50c/1455a252e4ccd3a53724479f36aed26b?Expires=1742774400&Key-Pair-Id=APKAQ4GOSFWCW27IBOMQ&Signature=QiNaVuJ8sXl6PzI~M7Za5qtzOGmVlw6NMQe8XrCCXLkDwLee8OSaIfbeTEma42RWufye6UqAP2uWhzqbFo~a1Vg4RdkBLVXepXyFbrdzLazPiaVjPVA5cnrSyJfTJrhiuPjguhd~1xIS~h1VF0VfHOkCXBTiyQs9U5x8Mp9I0sK35r8e1W7Mtbz5HqmCvpxY0l8-14D-9MkXuzBLTtPhhvZavPHO2XSdtzePTK~pkd3c9IXHVV-N8FgDNSi4753skhxUFd-HBeMaQ~K~oXqL9QtgZbjp18ePp2md3oSzkoFSftCCOiS-7xLGcqJFUfciDiYpZB0cL7EErFeeZhMsug__"
                class="mx-auto -mt-16 border-4 border-white rounded-full w-52 h-52" alt="Profile">
            <h2 class="mt-4 text-xl font-bold">Fahrudin Arianto</h2>
            <p class="text-gray-500">Pengguna</p>

            <div class="flex justify-center mt-4 border-b">
                <button @click="tab = 'personal'" class="w-1/2 px-4 py-2 border-b-2"
                    :class="{ 'border-black font-bold': tab === 'personal' }">Personal</button>
                <button @click="tab = 'akun'" class="w-1/2 px-4 py-2 border-b-2"
                    :class="{ 'border-black font-bold': tab === 'akun' }">Akun</button>
            </div>

            <div class="mt-4">
                <p x-show="tab === 'personal'">Ini personal</p>
                <p x-show="tab === 'akun'">Ini akun</p>
            </div>

            <button class="px-4 py-2 mt-6 text-white bg-red-500 rounded-lg">Keluar</button>
        </div>

        <div x-show="tab === 'akun'" class="p-6 mt-6 bg-white rounded-lg shadow-lg">
            <div class="space-y-4">
                <div class="flex items-center p-2 border rounded-lg">
                    <input type="text" class="w-full outline-none" value="fahrudinar@mail.com" readonly>
                    <span class="ml-2">✏️</span>
                </div>
                <div class="flex items-center p-2 border rounded-lg">
                    <input type="text" class="w-full outline-none" value="Fahrudinar" readonly>
                    <span class="ml-2">✏️</span>
                </div>
                <div class="flex items-center p-2 border rounded-lg">
                    <input type="password" class="w-full outline-none" value="********" readonly>
                    <span class="ml-2">✏️</span>
                </div>
            </div>
        </div>
    </div> --}}

</x-app-layout>
