<?php

namespace App\Http\Controllers;

use App\Models\Datadiri;
use App\Models\Kriteria;
use App\Models\User;
use App\Models\MatchResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PandanganNikah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PenjodohanController extends Controller
{
    /**
     * Tampilkan halaman admin untuk penjodohan
     */
    public function index()
    {
        // Periksa apakah user adalah admin menggunakan Gate
        if (!Gate::allows('admin')) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        // Ambil semua pengguna laki-laki yang sudah mengisi data
        // Kecuali admin (is_admin = true)
        $lakiLaki = Datadiri::where('jenis_kelamin', 'Laki-laki')
            ->whereHas('user', function ($query) {
                $query->where('is_admin', false);
            })
            ->get();

        return view('frontend.data-cocok.index', [
            'lakiLaki' => $lakiLaki
        ]);
    }

    /**
     * Tampilkan detail rekomendasi untuk satu laki-laki
     */
    public function showRekomendasi($userId)
    {
        // Periksa apakah user adalah admin menggunakan Gate
        if (!Gate::allows('admin')) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        // Ambil data diri laki-laki
        $lakiLaki = Datadiri::where('user_id', $userId)
            ->where('jenis_kelamin', 'Laki-laki')
            ->first();

        if (!$lakiLaki) {
            return redirect()->route('frontend.data-cocok.index')
                ->with('error', 'Data pengguna tidak ditemukan');
        }

        // Cek apakah laki-laki sudah dijodohkan
        $existingMatch = MatchResult::where('laki_id', $userId)
            ->where('status', 'confirmed')
            ->first();

        // Jika sudah dijodohkan, tampilkan hanya pasangan yang sudah dikonfirmasi
        if ($existingMatch) {
            $wanita = Datadiri::where('user_id', $existingMatch->wanita_id)->first();

            if ($wanita) {
                $matches = [
                    [
                        'wanita' => $wanita,
                        'persentase' => $existingMatch->persentase_kecocokan
                    ]
                ];

                return view('frontend.data-cocok.rekomendasi', [
                    'lakiLaki' => $lakiLaki,
                    'matches' => $matches,
                    'isMatched' => true
                ]);
            }
        }

        // Jika belum dijodohkan, lanjutkan dengan logika pencarian rekomendasi
        // Ambil kriteria yang diinginkan laki-laki
        $kriteria = Kriteria::where('user_id', $userId)->first();
        if (!$kriteria) {
            return redirect()->route('frontend.data-cocok.index')
                ->with('error', 'Kriteria pengguna belum diisi');
        }

        // Decode kriteria pasangan yang diinginkan
        $kriteriaYangDiinginkan = json_decode($kriteria->kriteria_pasangan, true) ?? [];
        $kriteriaDiriLaki = json_decode($kriteria->kriteria_diri, true) ?? [];

        // Ambil semua perempuan (kecuali admin) yang belum dijodohkan
        $matchedWanitaIds = MatchResult::where('status', 'confirmed')
            ->pluck('wanita_id')
            ->toArray();

        $perempuan = Datadiri::where('jenis_kelamin', 'Perempuan')
            ->whereHas('user', function ($query) {
                $query->where('is_admin', false);
            })
            ->whereNotIn('user_id', $matchedWanitaIds)
            ->get();

        // Hitung skor kecocokan untuk setiap perempuan
        $matches = [];

        foreach ($perempuan as $wanita) {
            // Ambil kriteria wanita
            $kriteriaWanita = Kriteria::where('user_id', $wanita->user_id)->first();

            if ($kriteriaWanita) {
                // Decode kriteria diri wanita
                $kriteriaDiriWanita = json_decode($kriteriaWanita->kriteria_diri, true) ?? [];

                // Decode kriteria pasangan yang diinginkan wanita
                $kriteriaPasanganWanita = json_decode($kriteriaWanita->kriteria_pasangan, true) ?? [];

                // Hitung skor kecocokan laki ke wanita
                $lakiKeWanita = $this->calculateMatchingScore($kriteriaYangDiinginkan, $kriteriaDiriWanita);

                // Hitung skor kecocokan wanita ke laki
                $wanitaKeLaki = $this->calculateMatchingScore($kriteriaPasanganWanita, $kriteriaDiriLaki);

                // Hitung total skor dan persentase kecocokan
                $totalKarakteristik = count($kriteriaYangDiinginkan) + count($kriteriaPasanganWanita);
                $totalKecocokan = $lakiKeWanita + $wanitaKeLaki;

                // Hindari pembagian dengan nol
                $persentase = $totalKarakteristik > 0 ?
                    round(($totalKecocokan / $totalKarakteristik) * 100) : 0;

                // Tambahkan ke array matches
                $matches[] = [
                    'wanita' => $wanita,
                    'persentase' => $persentase
                ];
            }
        }

        // Urutkan berdasarkan persentase tertinggi
        usort($matches, function ($a, $b) {
            return $b['persentase'] <=> $a['persentase'];
        });

        // Ambil 3 rekomendasi teratas
        $topMatches = array_slice($matches, 0, 3);

        return view('frontend.data-cocok.rekomendasi', [
            'lakiLaki' => $lakiLaki,
            'matches' => $topMatches,
            'isMatched' => false
        ]);
    }

    /**
     * Konfirmasi pasangan yang telah dipilih admin
     */
    public function konfirmasiPasangan(Request $request)
    {
        // Periksa apakah user adalah admin menggunakan Gate
        if (!Gate::allows('admin')) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        // Validasi data
        $request->validate([
            'laki_id' => 'required|exists:datadiris,user_id',
            'wanita_id' => 'required|exists:datadiris,user_id',
        ]);

        // Simpan hasil konfirmasi ke database
        MatchResult::updateOrCreate(
            ['laki_id' => $request->laki_id],
            [
                'wanita_id' => $request->wanita_id,
                'status' => 'confirmed',
                'confirmed_by' => Auth::id(),
                'persentase_kecocokan' => $request->persentase
            ]
        );

        return redirect()->route('data-cocok.index')
            ->with('success', 'Pasangan berhasil dikonfirmasi');
    }

    /**
     * Tampilkan detail perbandingan antara laki-laki dan wanita
     */
    public function detailPerbandingan($lakiId, $wanitaId)
    {
        // Periksa apakah user adalah admin menggunakan Gate
        if (!Gate::allows('admin')) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        // Ambil data diri laki-laki dan wanita
        $lakiLaki = Datadiri::where('user_id', $lakiId)->first();
        $wanita = Datadiri::where('user_id', $wanitaId)->first();

        if (!$lakiLaki || !$wanita) {
            return redirect()->route('data-cocok.index')
                ->with('error', 'Data pengguna tidak ditemukan');
        }

        // Ambil kriteria laki-laki dan wanita
        $kriteriaLaki = Kriteria::where('user_id', $lakiId)->first();
        $kriteriaWanita = Kriteria::where('user_id', $wanitaId)->first();

        if (!$kriteriaLaki || !$kriteriaWanita) {
            return redirect()->route('data-cocok.index')
                ->with('error', 'Data kriteria tidak ditemukan');
        }

        // Decode kriteria
        $kriteriaDiriLaki = json_decode($kriteriaLaki->kriteria_diri, true) ?? [];
        $kriteriaPasanganLaki = json_decode($kriteriaLaki->kriteria_pasangan, true) ?? [];
        $kriteriaDiriWanita = json_decode($kriteriaWanita->kriteria_diri, true) ?? [];
        $kriteriaPasanganWanita = json_decode($kriteriaWanita->kriteria_pasangan, true) ?? [];

        // Hitung kecocokan
        $lakiKeWanita = $this->calculateMatchingScore($kriteriaPasanganLaki, $kriteriaDiriWanita);
        $wanitaKeLaki = $this->calculateMatchingScore($kriteriaPasanganWanita, $kriteriaDiriLaki);


        // Ambil data pandangan nikah
        $pandanganNikahLaki = $lakiLaki->pandanganNikah ?? null;
        $pandanganNikahWanita = $wanita->pandanganNikah ?? null;

        // Hitung persentase kecocokan
        $totalKarakteristik = count($kriteriaPasanganLaki) + count($kriteriaPasanganWanita);
        $totalKecocokan = $lakiKeWanita + $wanitaKeLaki;
        $persentase = $totalKarakteristik > 0 ?
            round(($totalKecocokan / $totalKarakteristik) * 100) : 0;

        return view('frontend.data-cocok.detail', [
            'lakiLaki' => $lakiLaki,
            'wanita' => $wanita,
            'kriteriaDiriLaki' => $kriteriaDiriLaki,
            'kriteriaPasanganLaki' => $kriteriaPasanganLaki,
            'kriteriaDiriWanita' => $kriteriaDiriWanita,
            'kriteriaPasanganWanita' => $kriteriaPasanganWanita,
            'lakiKeWanita' => $lakiKeWanita,
            'wanitaKeLaki' => $wanitaKeLaki,
            'persentase' => $persentase,
            'pandanganNikahLaki' => $pandanganNikahLaki,
            'pandanganNikahWanita' => $pandanganNikahWanita
        ]);
    }

    /**
     * Hitung skor kecocokan antara kriteria yang diinginkan dan kriteria yang dimiliki
     */
    private function calculateMatchingScore(array $desiredCriteria, array $actualCriteria): int
    {
        $score = 0;

        // Untuk setiap kriteria yang diinginkan, periksa apakah ada dalam kriteria yang dimiliki
        foreach ($desiredCriteria as $criteria) {
            if (in_array($criteria, $actualCriteria)) {
                $score++;
            }
        }

        return $score;
    }

    /**
     * Hitung persentase kecocokan
     */
    private function calculatePercentage(int $totalScore, array $criteria1, array $criteria2): int
    {
        $totalCriteria = count($criteria1) + count($criteria2);

        if ($totalCriteria === 0) {
            return 0;
        }

        return round(($totalScore / $totalCriteria) * 100);
    }
}
