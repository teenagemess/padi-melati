<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Orangtua extends Model
{
    protected $fillable = [
        "user_id",
        "nama_ayah",
        "nama_ibu",
        "pekerjaan_ayah",
        "pekerjaan_ibu"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
