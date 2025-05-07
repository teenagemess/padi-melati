<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pandangan_nikahs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('visi_pernikahan')->nullable();
            $table->string('misi_pernikahan')->nullable();
            $table->string('cita_pernikahan')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pandangan_nikahs');
    }
};
