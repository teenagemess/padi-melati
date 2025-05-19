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
        Schema::create('match_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laki_id');
            $table->unsignedBigInteger('wanita_id');
            $table->string('status')->default('pending'); // pending, confirmed, rejected
            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->integer('persentase_kecocokan')->default(0);
            $table->timestamps();

            $table->foreign('laki_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('wanita_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('confirmed_by')->references('id')->on('users')->onDelete('set null');

            // Setiap laki-laki hanya bisa memiliki satu konfirmasi jodoh
            $table->unique('laki_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_results');
    }
};
