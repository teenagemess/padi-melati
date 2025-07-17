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
    public function index(Request $request)
    {
        // Periksa apakah user adalah admin menggunakan Gate
        if (!Gate::allows('admin')) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        // Validasi input untuk pencarian
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        // Query dasar untuk semua pengguna laki-laki non-admin
        $baseQuery = Datadiri::where('jenis_kelamin', 'Laki-laki')
            ->whereHas('user', function ($query) {
                $query->where('is_admin', false);
            });

        // Ambil ID dari semua laki-laki yang memenuhi kriteria dasar
        $allMaleUserIds = (clone $baseQuery)->pluck('user_id')->toArray();

        // Ambil ID laki-laki yang sudah dikonfirmasi jodohnya
        $matchedMaleUserIds = MatchResult::whereIn('laki_id', $allMaleUserIds)
            ->where('status', 'confirmed')
            ->pluck('laki_id')
            ->unique()
            ->toArray();

        // Hitung jumlah laki-laki yang sudah berjodoh dan belum berjodoh
        $matchedMaleCount = count($matchedMaleUserIds);
        $unmatchedMaleCount = count(array_diff($allMaleUserIds, $matchedMaleUserIds));


        // Terapkan filter pencarian nama jika ada pada query yang akan di-paginate
        $query = $baseQuery; // Gunakan baseQuery untuk paginasi
        if ($search = $request->query('search')) {
            $query->where('nama_peserta', 'like', '%' . $search . '%');
        }

        // Urutkan berdasarkan created_at terbaru (default)
        $query->orderBy('created_at', 'desc');

        // Paginate hasilnya (misalnya 6 item per halaman)
        $lakiLaki = $query->paginate(6)->withQueryString();

        // Tambahkan atribut 'is_matched' ke setiap Datadiri dalam koleksi paginated
        // untuk memudahkan pengecekan di Blade
        $lakiLaki->each(function ($laki) use ($matchedMaleUserIds) {
            $laki->is_matched = in_array($laki->user_id, $matchedMaleUserIds);
        });

        return view('frontend.data-cocok.index', [
            'lakiLaki' => $lakiLaki, // Objek Paginator
            'matchedMaleCount' => $matchedMaleCount,
            'unmatchedMaleCount' => $unmatchedMaleCount,
        ]);
    }

    /**
     * Tampilkan detail rekomendasi untuk satu laki-laki
     */
    public function showRekomendasi($userId)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $lakiLaki = Datadiri::where('user_id', $userId)
            ->where('jenis_kelamin', 'Laki-laki')
            ->first();

        if (!$lakiLaki) {
            return redirect()->route('frontend.data-cocok.index')
                ->with('error', 'Data pengguna tidak ditemukan');
        }

        $existingMatch = MatchResult::where('laki_id', $userId)
            ->where('status', 'confirmed')
            ->first();

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

        $kriteria = Kriteria::where('user_id', $userId)->first();
        if (!$kriteria) {
            return redirect()->route('frontend.data-cocok.index')
                ->with('error', 'Kriteria pengguna belum diisi');
        }

        $kriteriaYangDiinginkan = json_decode($kriteria->kriteria_pasangan, true) ?? [];
        $kriteriaDiriLaki = json_decode($kriteria->kriteria_diri, true) ?? [];

        $matchedWanitaIds = MatchResult::where('status', 'confirmed')
            ->pluck('wanita_id')
            ->toArray();

        $perempuan = Datadiri::where('jenis_kelamin', 'Perempuan')
            ->whereHas('user', function ($query) {
                $query->where('is_admin', false);
            })
            ->whereNotIn('user_id', $matchedWanitaIds)
            ->get();

        $matches = [];
        $lakiAge = $lakiLaki->age; // Get laki-laki's age

        foreach ($perempuan as $wanita) {
            $kriteriaWanita = Kriteria::where('user_id', $wanita->user_id)->first();
            if ($kriteriaWanita) {
                $kriteriaDiriWanita = json_decode($kriteriaWanita->kriteria_diri, true) ?? [];
                $kriteriaPasanganWanita = json_decode($kriteriaWanita->kriteria_pasangan, true) ?? [];

                $wanitaAge = $wanita->age; // Get wanita's age

                // Calculate scores with age
                $lakiKeWanita = $this->calculateMatchingScore(
                    $kriteriaYangDiinginkan,
                    $kriteriaDiriWanita,
                    $lakiAge,
                    $wanitaAge
                );
                $wanitaKeLaki = $this->calculateMatchingScore(
                    $kriteriaPasanganWanita,
                    $kriteriaDiriLaki,
                    $wanitaAge,
                    $lakiAge
                );

                $totalKarakteristik = count($kriteriaYangDiinginkan) + count($kriteriaPasanganWanita);
                $totalKecocokan = $lakiKeWanita + $wanitaKeLaki;
                $persentase = $totalKarakteristik > 0 ?
                    round(($totalKecocokan / $totalKarakteristik) * 100) : 0;

                $matches[] = [
                    'wanita' => $wanita,
                    'persentase' => $persentase
                ];
            }
        }

        usort($matches, function ($a, $b) {
            return $b['persentase'] <=> $a['persentase'];
        });

        $topMatches = array_slice($matches, 0, 5);

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
            'persentase' => 'required|numeric|min:0|max:100',
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
     * Metode baru: Batalkan Taaruf
     */
    public function batalkanTaaruf(Request $request, $lakiId)
    {
        // Periksa apakah user adalah admin menggunakan Gate
        if (!Gate::allows('admin')) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        // Cari hasil jodoh yang dikonfirmasi untuk laki-laki ini
        $matchResult = MatchResult::where('laki_id', $lakiId)
            ->where('status', 'confirmed')
            ->first();

        if ($matchResult) {
            $matchResult->delete(); // Hapus data jodoh
            return redirect()->route('data-cocok.index')
                ->with('success', 'Taaruf berhasil dibatalkan.');
        }

        return redirect()->route('data-cocok.index')
            ->with('error', 'Data taaruf tidak ditemukan atau belum dikonfirmasi.');
    }


    /**
     * Tampilkan detail perbandingan antara laki-laki dan wanita
     */
    public function detailPerbandingan($lakiId, $wanitaId)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $lakiLaki = Datadiri::where('user_id', $lakiId)->first();
        $wanita = Datadiri::where('user_id', $wanitaId)->first();

        if (!$lakiLaki || !$wanita) {
            return redirect()->route('data-cocok.index')
                ->with('error', 'Data pengguna tidak ditemukan');
        }

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

        // Get ages
        $lakiAge = $lakiLaki->age;
        $wanitaAge = $wanita->age;

        // Calculate matching scores with age
        $lakiKeWanita = $this->calculateMatchingScore(
            $kriteriaPasanganLaki,
            $kriteriaDiriWanita,
            $lakiAge,
            $wanitaAge
        );
        $wanitaKeLaki = $this->calculateMatchingScore(
            $kriteriaPasanganWanita,
            $kriteriaDiriLaki,
            $wanitaAge,
            $lakiAge
        );

        // Calculate percentage
        $totalKarakteristik = count($kriteriaPasanganLaki) + count($kriteriaPasanganWanita);
        $totalKecocokan = $lakiKeWanita + $wanitaKeLaki;
        $persentase = $totalKarakteristik > 0 ?
            round(($totalKecocokan / $totalKarakteristik) * 100) : 0;

        // Get marriage perspectives
        $pandanganNikahLaki = $lakiLaki->pandanganNikah ?? null;
        $pandanganNikahWanita = $wanita->pandanganNikah ?? null;

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

        /**
         * Hitung skor kecocokan antara kriteria yang diinginkan dan kriteria yang dimiliki
         */
    }

    private function calculateMatchingScore(array $desiredCriteria, array $actualCriteria, $desiredUserAge, $actualUserAge): int
    {
        $score = 0;
        $ageCriteria = ['Seumuran', 'Lebih Tua', 'Lebih Muda', 'Tidak Memandang Usia'];

        foreach ($desiredCriteria as $criteria) {
            if (in_array($criteria, $ageCriteria)) {
                if ($criteria === 'Tidak Memandang Usia') {
                    $score++;
                } elseif ($criteria === 'Seumuran') {
                    if (abs($desiredUserAge - $actualUserAge) <= 2) {
                        $score++;
                    }
                } elseif ($criteria === 'Lebih Tua') {
                    if ($actualUserAge > $desiredUserAge) {
                        $score++;
                    }
                } elseif ($criteria === 'Lebih Muda') {
                    if ($actualUserAge < $desiredUserAge) {
                        $score++;
                    }
                }
            } else {
                if (in_array($criteria, $actualCriteria)) {
                    $score++;
                }
            }
        }

        return $score;
    }

    private function calculatePercentage(int $totalScore, array $criteria1, array $criteria2): int
    {
        $totalCriteria = count($criteria1) + count($criteria2);
        return $totalCriteria > 0 ? round(($totalScore / $totalCriteria) * 100) : 0;
    }
}
