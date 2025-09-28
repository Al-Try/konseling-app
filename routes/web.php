<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('siswa', SiswaController::class);
Route::resource('kelas', KelasController::class);
Route::resource('bimbingan', BimbinganController::class);
Route::middleware(['auth','role:admin'])->group(function() {
    Route::resource('siswa', SiswaController::class);
});
Route::middleware(['auth','role:guru_wali'])->group(function() {
    Route::get('/guru/dashboard', function(){
        return view('dashboard.guru'); // bisa bikin dashboard guru sederhana
    });
    Route::resource('bimbingan', BimbinganController::class)->only(['index','create','store']);
});