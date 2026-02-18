<?php

use App\Http\Controllers\PotentialController;
use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PotentialController::class, 'index'])->name('home');
Route::get('/potensi/{slug}', [PotentialController::class, 'show'])->name('potentials.show');
Route::view('/peta', 'map')->name('map');
Route::get('/desa', [VillageController::class, 'index'])->name('villages.index');
Route::get('/desa/{slug}', [VillageController::class, 'show'])->name('villages.show');
