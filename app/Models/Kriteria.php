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

    /**
     * Accessor: Get the kriteria_diri as a PHP array.
     * Use $kriteria->kriteria_diri_array in your Blade.
     */
    public function getKriteriaDiriArrayAttribute(): array
    {
        // Decode JSON. If decoding fails (e.g., malformed JSON), return an empty array.
        return json_decode($this->kriteria_diri, true) ?? [];
    }

    /**
     * Accessor: Get the kriteria_pasangan as a PHP array.
     * Use $kriteria->kriteria_pasangan_array in your Blade.
     */
    public function getKriteriaPasanganArrayAttribute(): array
    {
        // Decode JSON. If decoding fails (e.g., malformed JSON), return an empty array.
        return json_decode($this->kriteria_pasangan, true) ?? [];
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
