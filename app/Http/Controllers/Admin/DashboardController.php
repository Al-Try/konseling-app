<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\GuruWali;
use App\Models\JenisBimbingan;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== KPI =====
        $stats = [
            'totalSiswa'     => Siswa::count(),
            'totalGuruWali'  => GuruWali::count(),
            'totalKelas'     => Kelas::count(),
            'totalKonseling' => Bimbingan::count(),
        ];

        // ===== Siswa terbaru (5 entri) =====
        $siswaTerbaru = Siswa::with('kelas:id,nama_kelas')
            ->latest('id')
            ->take(5)
            ->get(['id','nama_siswa','kelas_id']);

      // ===== Tren bulanan 12 bulan terakhir =====
        $start = now()->startOfMonth()->subMonths(11);
        $end   = now()->endOfMonth();

        $raw = Bimbingan::selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as ym, COUNT(*) as jml")
            ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('jml','ym')
            ->toArray();

        $cursor = $start->copy();
        $bulananLabels = [];
        $bulananValues = [];
        for ($i = 0; $i < 12; $i++) {
            $key = $cursor->format('Y-m');
            // Label "Okt 25" dll (pakai locale ID kalau diinginkan)
            $bulananLabels[] = $cursor->locale('id')->translatedFormat('MMM yy');
            $bulananValues[] = (int)($raw[$key] ?? 0);
            $cursor->addMonth();
        }


       $kategoriDistribusi = Bimbingan::select('jenis_id', DB::raw('COUNT(*) as jml'))
            ->groupBy('jenis_id')
            ->with(['jenis:id,nama_jenis'])
            ->get()
            ->map(fn($r) => ['label' => $r->jenis?->nama_jenis ?? 'Lainnya', 'jml' => (int) $r->jml])
            ->toArray();

        $topGuru = Bimbingan::select('guru_id', DB::raw('COUNT(*) as jml'))
            ->groupBy('guru_id')
            ->orderByDesc('jml')
            ->with(['guruWali.user:id,name'])
            ->limit(5)->get()
            ->map(fn($r) => ['label' => $r->guruWali?->user?->name ?? '—', 'jml' => (int) $r->jml])
            ->toArray();

        $topSiswa = Bimbingan::select('siswa_id', DB::raw('COUNT(*) as jml'))
            ->groupBy('siswa_id')
            ->orderByDesc('jml')
            ->with(['siswa:id,nama_siswa'])
            ->limit(5)->get()
            ->map(fn($r) => ['label' => $r->siswa?->nama_siswa ?? '—', 'jml' => (int) $r->jml])
            ->toArray();


        return view('admin.dashboard', compact(
            'stats',
            'siswaTerbaru',
            'bulananLabels',
            'bulananValues',
            'kategoriDistribusi',
            'topGuru',
            'topSiswa'
        ));
    }
}
