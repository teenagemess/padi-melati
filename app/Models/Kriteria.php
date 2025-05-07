<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kriteria extends Model
{
    protected $fillable = [
        "user_id",
        "kriteria_diri",
        "kriteria_pasangan",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
