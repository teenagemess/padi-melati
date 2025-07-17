<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataPendaftarController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PenjodohanController; // Pastikan ini diimpor


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ... (route dashboard jika Anda mengaktifkannya) ...

Route::middleware('auth')->group(function () {
    Route::resource('pendaftaran', PendaftaranController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/name', [ProfileController::class, 'updateName'])->name('profile.update.name');
    Route::patch('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.update.email');
    Route::patch('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.image.update');
    Route::patch('/profile/update-data-diri', [ProfileController::class, 'updateDataDiri'])
        ->name('profile.update-data-diri');
    Route::get('/status', [PendaftaranController::class, 'showStatus']);
    Route::post('/pendaftaran/upload-ktp', [PendaftaranController::class, 'storeKtp'])
        ->name('pendaftaran.upload-ktp');
    Route::delete('/data-pendaftar/{id}', [DataPendaftarController::class, 'destroy'])->name('data-pendaftar.destroy');
    Route::post('/pendaftaran/clear-deletion-notification', [PendaftaranController::class, 'clearDeletionNotification'])
        ->name('pendaftaran.clear-deletion-notification');
});

Route::middleware('admin')->group(function () {
    Route::get('/data-pendaftar', [DataPendaftarController::class, 'index'])->name('data-pendaftar.index');
    Route::get('/data-pendaftar/{id}', [DataPendaftarController::class, 'show'])->name('data-pendaftar.show');

    // Halaman utama data kecocokan
    Route::get('/data-cocok', [PenjodohanController::class, 'index'])
        ->name('data-cocok.index');

    // Lihat rekomendasi untuk satu laki-laki
    Route::get('/data-cocok/rekomendasi/{userId}', [PenjodohanController::class, 'showRekomendasi'])
        ->name('data-cocok.rekomendasi');

    // Simpan konfirmasi pasangan
    Route::post('/data-cocok/konfirmasi', [PenjodohanController::class, 'konfirmasiPasangan'])
        ->name('data-cocok.konfirmasi');

    // Detail perbandingan laki-laki dan wanita
    Route::get('/data-cocok/detail/{laki_id}/{wanita_id}', [PenjodohanController::class, 'detailPerbandingan'])
        ->name('data-cocok.detail');

    // ROUTE BARU: Batalkan Taaruf
    Route::delete('/data-cocok/batalkan/{laki_id}', [PenjodohanController::class, 'batalkanTaaruf'])
        ->name('data-cocok.batalkan');

    Route::get('/datapersonal', function () {
        return view('frontend.data-pendaftar.show');
    });
});

require __DIR__ . '/auth.php';
