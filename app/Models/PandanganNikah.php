<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PandanganNikah extends Model
{
    protected $fillable = [
        "user_id",
        "visi_pernikahan",
        "misi_pernikahan",
        "cita_pernikahan"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
