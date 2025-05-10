<?php

namespace App\Http\Controllers;

use App\Models\Datadiri;
use App\Models\User;
use Illuminate\Http\Request;

class DataPendaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data pendaftar
        $pendaftarList = Datadiri::with('user')->get();

        return view('frontend.data-pendaftar.index', compact('pendaftarList'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pendaftarList = Datadiri::with('user')->get();
        $dataDiri = Datadiri::with(['user', 'orangtua', 'pandanganNikah', 'kriteria'])
            ->where('id', $id)
            ->firstOrFail();

        return view('frontend.data-pendaftar.show', compact('dataDiri'));
    }
}
