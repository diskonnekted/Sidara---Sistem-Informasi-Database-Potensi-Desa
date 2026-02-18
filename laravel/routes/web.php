<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PotentialController as AdminPotentialController;
use App\Http\Controllers\PotentialController;
use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PotentialController::class, 'index'])->name('home');
Route::get('/potensi/{slug}', [PotentialController::class, 'show'])->name('potentials.show');
Route::view('/peta', 'map')->name('map');
Route::get('/desa', [VillageController::class, 'index'])->name('villages.index');
Route::get('/desa/{slug}', [VillageController::class, 'show'])->name('villages.show');
Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/potensi', [AdminPotentialController::class, 'index'])->name('potentials.index');
    Route::get('/potensi/create', [AdminPotentialController::class, 'create'])->name('potentials.create');
    Route::post('/potensi', [AdminPotentialController::class, 'store'])->name('potentials.store');
    Route::get('/potensi/{potential}/edit', [AdminPotentialController::class, 'edit'])->name('potentials.edit');
    Route::put('/potensi/{potential}', [AdminPotentialController::class, 'update'])->name('potentials.update');
    Route::delete('/potensi/{potential}', [AdminPotentialController::class, 'destroy'])->name('potentials.destroy');
});
