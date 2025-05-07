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
});

Route::middleware('admin')->group(function () {
    Route::get('/data-pendaftar', [DataPendaftarController::class, 'index'])->name('data-pendaftar');
    Route::get('/data-cocok', function () {
        return view('frontend.data-cocok.index');
    })->name('data-cocok');
    Route::get('/datapersonal', function () {
        return view('frontend.data-pendaftar.show');
    });
});

require __DIR__ . '/auth.php';
