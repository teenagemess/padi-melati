<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datadiri extends Model
{
    use HasFactory;

    protected $table = 'datadiris';

    protected $fillable = [
        'user_id',
        'nama_peserta',
        'nbm',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'tinggi_badan',
        'berat_badan',
        'alamat',
        'no_telepon',
        'pendidikan',
        'pekerjaan',
        'penghasilan',
        'riwayat_penyakit',
        'riwayat_organisasi',
        'status_pernikahan',
        'foto',
        'ktp',
    ];

    /**
     * Get the user that owns the datadiri.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the orangtua record associated with the datadiri.
     */
    public function orangtua()
    {
        return $this->hasOne(Orangtua::class, 'user_id', 'user_id');
    }

    /**
     * Get the pandangan nikah record associated with the datadiri.
     */
    public function pandanganNikah()
    {
        return $this->hasOne(PandanganNikah::class, 'user_id', 'user_id');
    }

    /**
     * Get the kriteria record associated with the datadiri.
     */
    public function kriteria()
    {
        return $this->hasOne(Kriteria::class, 'user_id', 'user_id');
    }

    /**
     * Get decoded riwayat_penyakit attribute.
     */
    public function getRiwayatPenyakitArrayAttribute()
    {
        return json_decode($this->riwayat_penyakit, true) ?? [];
    }

    /**
     * Get formatted URL for the foto attribute.
     */
    // public function getFotoUrlAttribute()
    // {
    //     if (!$this->foto) {
    //         return asset('images/default-avatar.png');
    //     }
    //     return asset('storage/' . $this->foto);
    // }
}
