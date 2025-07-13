<?php

namespace App\Http\Controllers;

use App\Models\Datadiri;
use App\Models\Kriteria;
use App\Models\Orangtua;
use App\Models\MatchResult;
use Illuminate\Http\Request;
use App\Models\PandanganNikah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
     * Menghapus data pendaftar beserta semua data terkait.
     */

    public function destroy($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id) || $id <= 0) {
                return redirect()->route('data-pendaftar.index')
                    ->with('error', 'ID pendaftar tidak valid.');
            }

            // Cari data pendaftar
            $dataDiri = Datadiri::where('id', $id)->firstOrFail();

            if (!$dataDiri->user_id) {
                return redirect()->route('data-pendaftar.index')
                    ->with('error', 'Data pendaftar tidak valid.');
            }

            // Cek apakah pendaftar sudah dijodohkan
            $isMatched = MatchResult::where(function ($query) use ($dataDiri) {
                $query->where('laki_id', $dataDiri->user_id)
                    ->orWhere('wanita_id', $dataDiri->user_id);
            })
                ->where('status', 'confirmed')
                ->exists();

            if ($isMatched) {
                return redirect()->route('data-pendaftar.index')
                    ->with('error', 'Tidak dapat menghapus data pendaftar yang sudah dijodohkan.');
            }

            // Simpan user_id untuk notifikasi
            $userId = $dataDiri->user_id;
            $namaPeserta = $dataDiri->nama_peserta;

            // Mulai transaction
            DB::beginTransaction();

            try {
                // Hapus file KTP jika ada
                if ($dataDiri->ktp_file && Storage::disk('public')->exists($dataDiri->ktp_file)) {
                    Storage::disk('public')->delete($dataDiri->ktp_file);
                }

                // Hapus semua data terkait
                Kriteria::where('user_id', $dataDiri->user_id)->delete();
                PandanganNikah::where('user_id', $dataDiri->user_id)->delete();
                Orangtua::where('user_id', $dataDiri->user_id)->delete();

                // Hapus data diri
                $dataDiri->delete();

                // Commit transaction
                DB::commit();

                // Set session untuk user yang datanya dihapus
                // Menggunakan session dengan key unik untuk user tersebut
                session()->put("user_data_deleted_by_admin_{$userId}", [
                    'deleted_at' => now(),
                    'deleted_by' => auth()->name ?? 'Admin', // Nama admin yang menghapus
                    'reason' => 'Data pendaftar dihapus oleh admin' // Bisa disesuaikan
                ]);

                // Log aktivitas penghapusan
                Log::info('Data pendaftar dihapus oleh admin', [
                    'admin_id' => auth() ?? null,
                    'admin_name' => auth()->name ?? 'Unknown',
                    'deleted_user_id' => $userId,
                    'deleted_user_name' => $namaPeserta,
                    'deleted_at' => now(),
                    'datadiri_id' => $id
                ]);

                return redirect()->route('data-pendaftar.index')
                    ->with('success', "Data pendaftar {$namaPeserta} berhasil dihapus. User dapat melakukan pendaftaran ulang.");
            } catch (\Exception $e) {
                // Rollback transaction jika terjadi error
                DB::rollBack();

                // Log error
                Log::error('Gagal menghapus data pendaftar', [
                    'admin_id' => auth() ?? null,
                    'datadiri_id' => $id,
                    'user_id' => $userId,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                throw $e;
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('data-pendaftar.index')
                ->with('error', 'Data pendaftar tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('data-pendaftar.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
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
