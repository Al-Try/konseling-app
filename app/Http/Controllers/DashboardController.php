<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\GuruWali;
use App\Models\Kelas;
use App\Models\Bimbingan;
use App\Models\JenisBimbingan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalSiswa'     => Siswa::count(),
            'totalGuruWali'  => GuruWali::count(),
            'totalKelas'     => Kelas::count(),
            'totalKonseling' => Bimbingan::count(),
        ];

        // Top 5 guru wali paling aktif (pakai bimbingans.guru_id)
        $topGuru = Bimbingan::select('guru_id', DB::raw('COUNT(*) as jml'))
            ->with(['guruWali.user:id,name'])
            ->groupBy('guru_id')
            ->orderByDesc('jml')
            ->limit(5)->get();

        // Top 5 siswa paling sering dikonseling
        $topSiswa = Bimbingan::select('siswa_id', DB::raw('COUNT(*) as jml'))
            ->with(['siswa:id,nama_siswa'])
            ->groupBy('siswa_id')
            ->orderByDesc('jml')
            ->limit(5)->get();

        // Distribusi kategori (join jenis_bimbingans)
        $kategoriDistribusi = Bimbingan::select('jenis_id', DB::raw('COUNT(*) as jml'))
            ->groupBy('jenis_id')
            ->with(['jenis:id,nama_jenis'])
            ->get()
            ->map(fn($r) => ['label' => $r->jenis?->nama_jenis ?? 'Lainnya', 'jml' => $r->jml]);

        // Tren bulanan 12 bulan terakhir (pakai kolom tanggal)
        $bulanan = Bimbingan::selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as ym, COUNT(*) as jml")
            ->where('tanggal', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('ym')->orderBy('ym')->get();

        return view('admin.dashboard', compact('stats','topGuru','topSiswa','kategoriDistribusi','bulanan'));
    }
}
