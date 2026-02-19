<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PotentialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\PotentialController as AdminPotentialController;

Route::get('/', [PotentialController::class, 'index'])->name('home');
Route::get('/potensi/{slug}', [PotentialController::class, 'show'])->name('potentials.show');
Route::get('/peta', [PotentialController::class, 'map'])->name('map');
Route::get('/desa', [VillageController::class, 'index'])->name('villages.index');
Route::get('/desa/{slug}', [VillageController::class, 'show'])->name('villages.show');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{id}', [ProductController::class, 'show'])->name('products.show');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute admin lainnya bisa ditambahkan di sini
    Route::resource('users', UserController::class);
    Route::resource('potentials', AdminPotentialController::class)->except(['show']);
    Route::delete('/potensi/{potential}/image/{imageIndex}', [AdminPotentialController::class, 'deleteImage'])->name('potentials.deleteImage');
});
