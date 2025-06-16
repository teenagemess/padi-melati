<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Datadiri;
use App\Models\Kriteria;
use App\Models\Orangtua;
use App\Models\MatchResult;
use Illuminate\Http\Request;
use App\Models\PandanganNikah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // App/Http/Controllers/PendaftaranController.php

    public function index()
    {
        // Check if the current user has already completed registration
        $hasRegistered = Datadiri::where('user_id', Auth::id())->exists();

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
            'matchPercentage' => $matchPercentage
        ]);
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
        // First check if user has already registered
        if (Datadiri::where('user_id', Auth::id())->exists()) {
            return redirect()->route('pendaftaran.index')
                ->with('error', 'Anda telah mengisi data pendaftaran sebelumnya');
        }

        // Validasi data
        $request->validate([
            // 'nbm' => 'required',
            // 'nama_peserta' => 'required',
            // 'tempat_lahir' => 'required',
            // 'tanggal_lahir' => 'required|date',
            // 'jenis_kelamin' => 'required',
            // 'status' => 'required', // matches the form field name
            // 'tinggi_badan' => 'required|numeric',
            // 'berat_badan' => 'required|numeric',
            // 'alamat' => 'required',
            // 'no_telepon' => 'required',
            // 'pendidikan' => 'required',
            // 'pekerjaan' => 'required',
            // 'penghasilan' => 'required',
            // 'riwayat_penyakit' => 'nullable|array',
            // 'riwayat_organisasi' => 'nullable',
            // // 'ktp' => 'nullable|file|mimes:jpeg,png,pdf', // Uncomment if handling file upload
            // 'nama_ayah' => 'required',
            // 'pekerjaan_ayah' => 'required',
            // 'nama_ibu' => 'required',
            // 'pekerjaan_ibu' => 'required',
            // 'visi_pernikahan' => 'nullable',
            // 'misi_pernikahan' => 'nullable',
            // 'cita_pernikahan' => 'nullable',
            // 'karakteristik_diri' => 'nullable|array',
            // 'karakteristik_pasangan' => 'nullable|array',
        ]);

        // Handle riwayat_penyakit data
        $riwayat_penyakit = $request->input('riwayat_penyakit', []);
        if ($request->filled('riwayat_penyakit_lain')) {
            $riwayat_penyakit[] = $request->input('riwayat_penyakit_lain');
        }

        // Simpan Data Diri
        Datadiri::create([
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
            'status_pernikahan' => $request->input('status'), // matches the form field
        ]);

        // Simpan data Orangtua
        Orangtua::create([
            'user_id' => Auth::id(),
            'nama_ayah' => $request->input('nama_ayah'),
            'pekerjaan_ayah' => $request->input('pekerjaan_ayah'),
            'nama_ibu' => $request->input('nama_ibu'),
            'pekerjaan_ibu' => $request->input('pekerjaan_ibu'),
        ]);

        // Simpan Pandangan Nikah
        PandanganNikah::create([
            'user_id' => Auth::id(),
            'visi_pernikahan' => $request->input('visi_pernikahan'),
            'misi_pernikahan' => $request->input('misi_pernikahan'),
            'cita_pernikahan' => $request->input('cita_pernikahan'),
        ]);

        // Process karakteristik data
        $karakteristik_diri = $request->input('karakteristik_diri', []);
        if ($request->filled('karakteristik_diri_lain')) {
            $karakteristik_diri[] = $request->input('karakteristik_diri_lain');
        }

        $karakteristik_pasangan = $request->input('karakteristik_pasangan', []);
        if ($request->filled('karakteristik_pasangan_lain')) {
            $karakteristik_pasangan[] = $request->input('karakteristik_pasangan_lain');
        }

        // Simpan Kriteria
        Kriteria::create([
            'user_id' => Auth::id(),
            'kriteria_diri' => json_encode($karakteristik_diri),
            'kriteria_pasangan' => json_encode($karakteristik_pasangan),
        ]);

        return redirect()->route('pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil disimpan');
    }


    /**
     * Display the specified resource.
     */
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
