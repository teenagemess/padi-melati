{{-- resources/views/data-cocok/index.blade.php --}}
<x-app-layout>
    <div class="min-h-screen px-4 py-56 bg-primary">
        <div class="max-w-4xl mx-auto space-y-6">
            @forelse($lakiLaki as $index => $laki)
                {{-- Card 1 --}}
                <div class="flex items-center p-4 space-x-4 bg-gray-200 rounded-lg shadow-md">
                    <img src="https://randomuser.me/api/portraits/men/1.jpg" class="object-cover w-16 h-16 rounded-full"
                        alt="Foto">
                    <div>
                        <p class="text-lg font-bold">{{ $laki->nama_peserta }}</p>
                        <p class="text-sm">Laki-laki</p>
                    </div>

                    <a href="{{ route('data-cocok.rekomendasi', $laki->user_id) }}" class="btn btn-success">
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
