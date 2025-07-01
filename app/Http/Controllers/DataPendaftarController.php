<?php

namespace App\Http\Controllers;

use App\Models\Datadiri;
use App\Models\MatchResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate; // Tetap dipertahankan jika Anda ingin menambahkan otorisasi admin di sini

class DataPendaftarController extends Controller
{
    /**
     * Menampilkan daftar pendaftar.
     */
    public function index(Request $request)
    {
        // Validasi input
        $request->validate([
            'search' => 'nullable|string|max:255',
            'gender' => 'nullable|in:L,P' // Masih validasi 'L' dan 'P' dari form
        ]);

        // Ambil ID pengguna yang sudah dijodohkan
        $matchedUserIds = MatchResult::where('status', 'confirmed')
            ->pluck('laki_id')
            ->merge(MatchResult::where('status', 'confirmed')->pluck('wanita_id'))
            ->unique()
            ->toArray();

        // Buat query untuk pendaftar
        $query = Datadiri::with('user')
            ->whereNotIn('user_id', $matchedUserIds);

        // Terapkan filter pencarian nama jika ada
        if ($search = $request->query('search')) {
            $query->where('nama_peserta', 'like', '%' . $search . '%');
        }

        // Terapkan filter gender jika ada
        if ($gender = $request->query('gender')) {
            // *** PERUBAHAN DI SINI: Mapping 'L'/'P' ke 'Laki-laki'/'Perempuan' ***
            $fullGenderName = ($gender == 'L') ? 'Laki-laki' : 'Perempuan';
            $query->where('jenis_kelamin', $fullGenderName);
        }

        // Urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');

        // Paginate hasil (6 per halaman) dengan preservasi query string
        $pendaftarList = $query->paginate(6)->withQueryString();

        return view('frontend.data-pendaftar.index', compact('pendaftarList'));
    }

    /**
     * Menampilkan detail pendaftar.
     */
    public function show($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id) || $id <= 0) {
                return redirect()->route('data-pendaftar.index')
                    ->with('error', 'ID pendaftar tidak valid.');
            }

            $dataDiri = Datadiri::with(['user', 'orangtua', 'pandanganNikah', 'kriteria'])
                ->where('id', $id)
                ->firstOrFail();

            if (!$dataDiri->user_id) {
                return redirect()->route('data-pendaftar.index')
                    ->with('error', 'Data pendaftar tidak valid.');
            }

            $isMatched = MatchResult::where(function ($query) use ($dataDiri) {
                $query->where('laki_id', $dataDiri->user_id)
                    ->orWhere('wanita_id', $dataDiri->user_id);
            })
                ->where('status', 'confirmed')
                ->exists();

            if ($isMatched) {
                return redirect()->route('data-pendaftar.index')
                    ->with('info', 'Data pendaftar ini sudah dijodohkan.');
            }

            return view('frontend.data-pendaftar.show', compact('dataDiri'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('data-pendaftar.index')
                ->with('error', 'Data pendaftar tidak ditemukan.');
        }
    }

    /**
     * Method untuk debugging - bisa dihapus setelah testing
     */
    public function debug(Request $request)
    {
        // Untuk debugging, tampilkan data apa saja yang ada
        $allData = Datadiri::select('id', 'nama_peserta', 'jenis_kelamin', 'user_id')->get();

        $matchedUserIds = MatchResult::where('status', 'confirmed')
            ->pluck('laki_id')
            ->merge(MatchResult::where('status', 'confirmed')->pluck('wanita_id'))
            ->unique()
            ->toArray();

        $availableData = Datadiri::whereNotIn('user_id', $matchedUserIds)
            ->select('id', 'nama_peserta', 'jenis_kelamin', 'user_id')
            ->get();

        return response()->json([
            'all_data' => $allData,
            'matched_user_ids' => $matchedUserIds,
            'available_data' => $availableData,
            'gender_counts' => [
                'L' => $availableData->where('jenis_kelamin', 'Laki-laki')->count(), // *** PERUBAHAN DI SINI ***
                'P' => $availableData->where('jenis_kelamin', 'Perempuan')->count() // *** PERUBAHAN DI SINI ***
            ]
        ]);
    }
}
