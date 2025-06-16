{{-- resources/views/data-cocok/index.blade.php --}}
<x-app-layout>
    <div class="min-h-screen px-4 py-56 bg-primary">
        <div class="max-w-4xl mx-auto space-y-6">
            @forelse($lakiLaki as $index => $laki)
                {{-- Card 1 --}}
                <div class="flex items-center justify-between p-4 space-x-4 bg-gray-200 rounded-lg shadow-md">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $laki->user->image ? asset('storage/' . $laki->user->image) : asset('images/default-profile.jpg') }}"
                            class="object-cover w-16 h-16 rounded-full" alt="Foto">
                        <div>
                            <p class="text-lg font-bold">{{ $laki->nama_peserta }}</p>
                            <p class="text-sm">Laki-laki</p>
                        </div>
                    </div>


                    <a href="{{ route('data-cocok.rekomendasi', $laki->user_id) }}"
                        class="px-4 py-1 bg-yellow-400 rounded-md hover:bg-yellow-500">
                        Lihat Rekomendasi
                    </a>
                </div>

            @empty
                <h1>
                    <td colspan="7" class="text-center">Tidak ada data peserta laki-laki</td>
                </h1>
            @endforelse
        </div>
    </div>

    {{-- Footer --}}
    <x-footer />
</x-app-layout>
