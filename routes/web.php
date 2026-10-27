<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AdminController;

// Halaman Publik
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/tim-pengembang', [FrontController::class, 'team'])->name('team');

// Halaman Admin CMS (Semua elemen & data pengujian bisa diubah)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'loginSubmit'])->name('login.submit');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::post('/sync-seeder', [AdminController::class, 'syncSeeder'])->name('sync_seeder');

    // Route Data Pengujian
    Route::post('/tests', [AdminController::class, 'storeTest'])->name('tests.store');
    Route::put('/tests/{id}', [AdminController::class, 'updateTest'])->name('tests.update');
    Route::delete('/tests/{id}', [AdminController::class, 'deleteTest'])->name('tests.delete');

    // Route Video Pengujian
    Route::post('/videos', [AdminController::class, 'storeVideo'])->name('videos.store');
    Route::put('/videos/{id}', [AdminController::class, 'updateVideo'])->name('videos.update');
    Route::delete('/videos/{id}', [AdminController::class, 'deleteVideo'])->name('videos.delete');

    // Route Komponen Produk & Galeri Implementasi
    Route::post('/components', [AdminController::class, 'storeComponent'])->name('components.store');
    Route::match(['put', 'post'], '/components/{id}', [AdminController::class, 'updateComponent'])->name('components.update');
    Route::delete('/components/{id}', [AdminController::class, 'deleteComponent'])->name('components.delete');

    // Route Tim Pengembang
    Route::post('/team', [AdminController::class, 'storeTeam'])->name('team.store');
    Route::put('/team/{id}', [AdminController::class, 'updateTeam'])->name('team.update');
    Route::delete('/team/{id}', [AdminController::class, 'deleteTeam'])->name('team.delete');
});
