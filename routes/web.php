<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataPendaftarController;
use App\Http\Controllers\PendaftaranController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::resource('pendaftaran', PendaftaranController::class);



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.image.update');
    Route::patch('/profile/update-data-diri', [ProfileController::class, 'updateDataDiri'])
        ->name('profile.update-data-diri');
    Route::get('/status', [PendaftaranController::class, 'showStatus']);

    // Tambahkan ini di atas route resource jika perlu


    // // Atau jika ingin menggunakan route resource, pastikan form mengirimkan ID
    // Route::resource('pendaftaran', PendaftaranController::class);
});

Route::middleware('admin')->group(function () {
    Route::get('/data-pendaftar', [DataPendaftarController::class, 'index'])->name('data-pendaftar.index');
    Route::get('/data-pendaftar/{id}', [DataPendaftarController::class, 'show'])->name('data-pendaftar.show');
    // Halaman utama data kecocokan
    Route::get('/data-cocok', [App\Http\Controllers\PenjodohanController::class, 'index'])
        ->name('data-cocok.index');

    // Lihat rekomendasi untuk satu laki-laki
    Route::get('/data-cocok/rekomendasi/{userId}', [App\Http\Controllers\PenjodohanController::class, 'showRekomendasi'])
        ->name('data-cocok.rekomendasi');

    // Simpan konfirmasi pasangan
    Route::post('/data-cocok/konfirmasi', [App\Http\Controllers\PenjodohanController::class, 'konfirmasiPasangan'])
        ->name('data-cocok.konfirmasi');

    // Detail perbandingan laki-laki dan wanita
    Route::get('/data-cocok/detail/{laki_id}/{wanita_id}', [App\Http\Controllers\PenjodohanController::class, 'detailPerbandingan'])
        ->name('data-cocok.detail');

    Route::get('/datapersonal', function () {
        return view('frontend.data-pendaftar.show');
    });
});

require __DIR__ . '/auth.php';
