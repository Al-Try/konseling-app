<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\JenisBimbinganController;
use App\Http\Controllers\AnalysisController;

Route::get('analysis/statistics', [AnalysisController::class, 'statistics']);
Route::get('analysis/ranking-siswa', [AnalysisController::class, 'rankingSiswa']);
Route::get('analysis/ranking-guru', [AnalysisController::class, 'rankingGuru']);

Route::apiResource('jenis-bimbingan', JenisBimbinganController::class);
