<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'laki_id',
        'wanita_id',
        'status',
        'confirmed_by',
        'persentase_kecocokan',
        'catatan'
    ];

    /**
     * Get the laki-laki data for this match.
     */
    public function lakiLaki()
    {
        return $this->belongsTo(User::class, 'laki_id');
    }

    /**
     * Get the wanita data for this match.
     */
    public function wanita()
    {
        return $this->belongsTo(User::class, 'wanita_id');
    }

    /**
     * Get the admin who confirmed this match.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    /**
     * Get the data diri for laki-laki.
     */
    public function dataLaki()
    {
        return $this->hasOne(Datadiri::class, 'user_id', 'laki_id');
    }

    /**
     * Get the data diri for wanita.
     */
    public function dataWanita()
    {
        return $this->hasOne(Datadiri::class, 'user_id', 'wanita_id');
    }
}
