<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Datadiri extends Model
{
    protected $fillable = [
        "user_id",
        'nbm',
        'nama_peserta',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'status',
        'tinggi_badan',
        'berat_badan',
        'alamat',
        'no_telepon',
        'pendidikan',
        'pekerjaan',
        'penghasilan',
        'riwayat_penyakit',
        'riwayat_organisasi',
        'ktp'
    ];

    protected function casts(): array
    {
        return [
            'riwayat_penyakit' => 'array',
            'riwayat_organisasi' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
