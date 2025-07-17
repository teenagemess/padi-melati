<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Datadiri;
use App\Models\Kriteria;
use App\Models\Orangtua;
use App\Models\MatchResult;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PandanganNikah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if the current user has already completed registration
        $hasRegistered = Datadiri::where('user_id', Auth::id())->exists();

        // Check if user data was deleted by admin - FIXED
        $dataDeletedByAdmin = session()->has("user_data_deleted_by_admin_" . Auth::id());
        $deletionData = null;

        if ($dataDeletedByAdmin) {
            // Ambil data detail penghapusan
            $deletionData = session()->get("user_data_deleted_by_admin_" . Auth::id());

            // Log bahwa user telah melihat notifikasi
            Log::info('User melihat notifikasi penghapusan data', [
                'user_id' => Auth::id(),
                'deletion_data' => $deletionData
            ]);

            // JANGAN hapus session di sini - biarkan user yang menghapus sendiri setelah melihat
        }

        // Check if user is already matched
        $isMatched = false;
        $matchName = null;
        $matchPercentage = null;

        if ($hasRegistered) {
            $matchResult = MatchResult::where(function ($query) {
                $query->where('laki_id', Auth::id())
                    ->orWhere('wanita_id', Auth::id());
            })
                ->where('status', 'confirmed')
                ->first();

            if ($matchResult) {
                $isMatched = true;

                // Get match details
                if ($matchResult->laki_id == Auth::id()) {
                    $matchUser = User::find($matchResult->wanita_id);
                    $matchName = $matchUser->datadiri->nama_peserta ?? 'Nama Tidak Tersedia';
                } else {
                    $matchUser = User::find($matchResult->laki_id);
                    $matchName = $matchUser->datadiri->nama_peserta ?? 'Nama Tidak Tersedia';
                }

                $matchPercentage = $matchResult->persentase_kecocokan;
            }
        }

        return view('frontend.pendaftaran.index', [
            'hasRegistered' => $hasRegistered,
            'isMatched' => $isMatched,
            'matchName' => $matchName,
            'matchPercentage' => $matchPercentage,
            'dataDeletedByAdmin' => $dataDeletedByAdmin,
            'deletionData' => $deletionData
        ]);
    }

    /**
     * Hapus notifikasi penghapusan data oleh admin
     */
    public function clearDeletionNotification()
    {
        $sessionKey = "user_data_deleted_by_admin_" . Auth::id();

        if (session()->has($sessionKey)) {
            session()->forget($sessionKey);

            Log::info('User menghapus notifikasi penghapusan data', [
                'user_id' => Auth::id(),
                'cleared_at' => now()
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Datadiri::where('user_id', Auth::id())->exists()) {
            return redirect()->route('pendaftaran.index')
                ->with('error', 'Anda telah mengisi data pendaftaran sebelumnya');
        }

        $sessionKey = "user_data_deleted_by_admin_" . Auth::id();
        if (session()->has($sessionKey)) {
            session()->forget($sessionKey);
        }

        $request->validate([
            'ktp' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'tanggal_lahir' => 'required|date|before:today',
            'nama_peserta' => 'required|string|max:255',
            'nbm' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tinggi_badan' => 'required|numeric|min:100|max:250',
            'berat_badan' => 'required|numeric|min:30|max:200',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|regex:/^\d{10,13}$/',
            'pendidikan' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'penghasilan' => 'required|string|max:255',
            'status' => 'required|in:Menikah,Lajang',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'visi_pernikahan' => 'required|string|max:255',
            'misi_pernikahan' => 'required|string|max:255',
            'cita_pernikahan' => 'required|string|max:255',
            'karakteristik_diri' => 'required|array|min:1',
            'karakteristik_pasangan' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $ktpPath = null;
            if ($request->hasFile('ktp') && $request->file('ktp')->isValid()) {
                $ktpPath = $request->file('ktp')->store('ktp_files', 'public');
                Log::info('KTP file uploaded successfully', [
                    'user_id' => Auth::id(),
                    'file_path' => $ktpPath,
                    'original_name' => $request->file('ktp')->getClientOriginalName()
                ]);
            }

            $riwayat_penyakit = $request->input('riwayat_penyakit', []);
            if ($request->filled('riwayat_penyakit_lain')) {
                $riwayat_penyakit[] = $request->input('riwayat_penyakit_lain');
            }

            $datadiri = Datadiri::create([
                'user_id' => Auth::id(),
                'nama_peserta' => $request->input('nama_peserta'),
                'nbm' => $request->input('nbm'),
                'jenis_kelamin' => $request->input('jenis_kelamin'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'tempat_lahir' => $request->input('tempat_lahir'),
                'tinggi_badan' => $request->input('tinggi_badan'),
                'berat_badan' => $request->input('berat_badan'),
                'alamat' => $request->input('alamat'),
                'no_telepon' => $request->input('no_telepon'),
                'pendidikan' => $request->input('pendidikan'),
                'pekerjaan' => $request->input('pekerjaan'),
                'penghasilan' => $request->input('penghasilan'),
                'riwayat_penyakit' => json_encode($riwayat_penyakit),
                'riwayat_organisasi' => $request->input('riwayat_organisasi'),
                'ktp_file' => $ktpPath,
                'status_pernikahan' => $request->input('status'),
            ]);

            Orangtua::create([
                'user_id' => Auth::id(),
                'nama_ayah' => $request->input('nama_ayah'),
                'pekerjaan_ayah' => $request->input('pekerjaan_ayah'),
                'nama_ibu' => $request->input('nama_ibu'),
                'pekerjaan_ibu' => $request->input('pekerjaan_ibu'),
            ]);

            PandanganNikah::create([
                'user_id' => Auth::id(),
                'visi_pernikahan' => $request->input('visi_pernikahan'),
                'misi_pernikahan' => $request->input('misi_pernikahan'),
                'cita_pernikahan' => $request->input('cita_pernikahan'),
            ]);

            $karakteristik_diri = $request->input('karakteristik_diri', []);
            if ($request->filled('karakteristik_diri_lain')) {
                $karakteristik_diri[] = $request->input('karakteristik_diri_lain');
            }

            $karakteristik_pasangan = $request->input('karakteristik_pasangan', []);
            if ($request->filled('karakteristik_pasangan_lain')) {
                $karakteristik_pasangan[] = $request->input('karakteristik_pasangan_lain');
            }

            Kriteria::create([
                'user_id' => Auth::id(),
                'kriteria_diri' => json_encode($karakteristik_diri),
                'kriteria_pasangan' => json_encode($karakteristik_pasangan),
            ]);

            DB::commit();

            Log::info('User registration completed successfully', [
                'user_id' => Auth::id(),
                'datadiri_id' => $datadiri->id,
                'ktp_uploaded' => !is_null($ktpPath)
            ]);

            return redirect()->route('pendaftaran.index')
                ->with('success', 'Pendaftaran berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($ktpPath && Storage::disk('public')->exists($ktpPath)) {
                Storage::disk('public')->delete($ktpPath);
            }
            Log::error('Registration failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();

        // Ambil data lengkap dengan relasinya
        $dataDiri = Datadiri::with(['orangtua', 'pandanganNikah', 'kriteria'])
            ->where('user_id', $user->id)
            ->firstOrFail(); // Gunakan firstOrFail() untuk memastikan data ada

        return view('profile.edit', compact('user', 'dataDiri'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
