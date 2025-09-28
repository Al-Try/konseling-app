<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\GuruWali;
use App\Models\Bimbingan;
use App\Models\JenisBimbingan;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
     public function statistics()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = GuruWali::count();
        $totalBimbingan = Bimbingan::count();

        // Bimbingan per jenis
        $bimbinganPerJenis = Bimbingan::select('jenis_bimbingan_id', DB::raw('count(*) as total'))
            ->groupBy('jenis_bimbingan_id')
            ->with('jenisBimbingan')
            ->get();

        return response()->json([
            'total_siswa' => $totalSiswa,
            'total_guru' => $totalGuru,
            'total_bimbingan' => $totalBimbingan,
            'bimbingan_per_jenis' => $bimbinganPerJenis
        ]);
    }

    // Ranking Siswa berdasarkan jumlah bimbingan
    public function rankingSiswa()
    {
        $ranking = Bimbingan::select('siswa_id', DB::raw('count(*) as total'))
            ->groupBy('siswa_id')
            ->with('siswa')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        return response()->json($ranking);
    }

    // Ranking Guru berdasarkan jumlah bimbingan siswa
    public function rankingGuru()
    {
        $ranking = Bimbingan::select('guru_wali_id', DB::raw('count(*) as total'))
            ->groupBy('guru_wali_id')
            ->with('guruWali')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        return response()->json($ranking);
    }
}
