<?php

namespace App\Http\Controllers;

use App\Models\Datadiri;
use App\Models\User;
use App\Models\Kriteria;
use App\Models\Orangtua;
use Illuminate\Http\Request;
use App\Models\PandanganNikah;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.pendaftaran.index');
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
        // Validasi data
        $request->validate([
            // 'nbm' => 'required',
            // 'nama_peserta' => 'required',
            // 'tempat_lahir' => 'required',
            // 'tanggal_lahir' => 'required|date',
            // 'jenis_kelamin' => 'required',
            // 'status' => 'required',
            // 'tinggi_badan' => 'required',
            // 'berat_badan' => 'required',
            // 'alamat' => 'required',
            // 'no_telepon' => 'required',
            // 'pendidikan' => 'required',
            // 'pekerjaan' => 'required',
            // 'penghasilan' => 'required',
            // 'riwayat_penyakit' => 'nullable',
            // 'riwayat_organisasi' => 'nullable',
            // 'ktp' => 'nullable|file|mimes:jpeg,png,pdf',
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

        $riwayat_penyakit = $request->input('riwayat_penyakit', []);
        if ($request->filled('riwayat_penyakit_lain')) {
            $riwayat_penyakit[] = $request->input('riwayat_penyakit_lain');
        }

        // Simpan User
        Datadiri::create([
            'user_id' => Auth::user()->id,
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
            'status_pernikahan' => $request->input('status'),
        ]);

        // Simpan data Orangtua
        Orangtua::create([
            'user_id' => Auth::user()->id,
            'nama_ayah' => $request->input('nama_ayah'),
            'pekerjaan_ayah' => $request->input('pekerjaan_ayah'),
            'nama_ibu' => $request->input('nama_ibu'),
            'pekerjaan_ibu' => $request->input('pekerjaan_ibu'),
        ]);

        // // Simpan Pandangan Nikah
        PandanganNikah::create([
            'user_id' => Auth::user()->id,
            'visi_pernikahan' => $request->input('visi_pernikahan'),
            'misi_pernikahan' => $request->input('misi_pernikahan'),
            'cita_pernikahan' => $request->input('cita_pernikahan'),
        ]);

        // Gabungkan checkbox dan input "lainnya"


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

        // Simpan Kriteria
        Kriteria::create([
            'user_id' => Auth::user()->id,
            'kriteria_diri' => json_encode($karakteristik_diri),
            'kriteria_pasangan' => json_encode($karakteristik_pasangan),
        ]);

        return redirect()->route('pendaftaran.index'); // Sesuaikan dengan rute yang Anda inginkan

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
