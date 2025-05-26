<?php

namespace App\Http\Controllers;

use App\Models\Datadiri;
use App\Models\User;
use App\Models\MatchResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DataPendaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // // Periksa apakah user adalah admin menggunakan Gate
        // if (Gate::exists('admin') && !Gate::allows('admin')) {
        //     return redirect()->route('dashboard')
        //         ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        // }

        // Ambil daftar user_id yang sudah dipasangkan (baik sebagai laki maupun wanita)
        $matchedUserIds = MatchResult::where('status', 'confirmed')
            ->select('laki_id', 'wanita_id')
            ->get()
            ->flatMap(function ($item) {
                return [$item->laki_id, $item->wanita_id];
            })
            ->toArray();

        // Ambil semua pendaftar yang belum dijodohkan
        $pendaftarList = Datadiri::with('user')
            ->whereNotIn('user_id', $matchedUserIds)
            ->get();

        return view('frontend.data-pendaftar.index', compact('pendaftarList'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Periksa apakah data pendaftar sudah dijodohkan
        $dataDiri = Datadiri::with(['user', 'orangtua', 'pandanganNikah', 'kriteria'])
            ->where('id', $id)
            ->firstOrFail();

        // Cek apakah user ini sudah dijodohkan
        $isMatched = MatchResult::where(function ($query) use ($dataDiri) {
            $query->where('laki_id', $dataDiri->user_id)
                ->orWhere('wanita_id', $dataDiri->user_id);
        })
            ->where('status', 'confirmed')
            ->exists();

        if ($isMatched) {
            return redirect()->route('frontend.data-pendaftar.index')
                ->with('info', 'Data pendaftar ini sudah dijodohkan.');
        }

        return view('frontend.data-pendaftar.show', compact('dataDiri'));
    }
}
