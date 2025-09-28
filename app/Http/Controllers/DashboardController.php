<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Bimbingan;
use App\Models\GuruWali;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalBimbingan = Bimbingan::count();
        $totalGuru = GuruWali::count();
        $guruAktif = GuruWali::whereHas('bimbingans')->count();

        // Statistik bimbingan per bulan
        $bimbinganPerBulan = Bimbingan::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Ranking guru
        $rankingGuru = GuruWali::withCount('bimbingans')
            ->orderByDesc('bimbingans_count')
            ->take(5)
            ->get();

        // Ranking siswa
        $rankingSiswa = Siswa::withCount('bimbingans')
            ->orderByDesc('bimbingans_count')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalSiswa',
            'totalBimbingan',
            'totalGuru',
            'guruAktif',
            'bimbinganPerBulan',
            'rankingGuru',
            'rankingSiswa'
        ));
    }
}
