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
        $start = Carbon::now()->startOfMonth()->subMonths(11);
        $end   = Carbon::now()->endOfMonth();

        // Ambil hitung per YYYY-MM dari DB
        $raw = Bimbingan::selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as ym, COUNT(*) as jml")
            ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('jml','ym'); // -> ['2025-01' => 3, ...]

        // Build label 12 bulan berurutan + isi nol jika kosong
        $cursor = $start->copy();
        $bulananLabels = [];
        $bulananValues = [];
        for ($i = 0; $i < 12; $i++) {
            $key = $cursor->format('Y-m');
            $bulananLabels[] = $cursor->isoFormat('MMM YY'); // ex: Jan 25
            $bulananValues[] = (int) ($raw[$key] ?? 0);
            $cursor->addMonth();
        }

        // ===== Distribusi kategori (bar/ pie) =====
        $kategoriDistribusi = Bimbingan::select('jenis_id', DB::raw('COUNT(*) as jml'))
            ->groupBy('jenis_id')
            ->with(['jenis:id,nama_jenis'])
            ->get()
            ->map(fn($r) => [
                'label' => $r->jenis?->nama_jenis ?? 'Lainnya',
                'jml'   => (int) $r->jml,
            ]);

        // ===== Top 5 guru wali paling aktif =====
        $topGuru = Bimbingan::select('guru_id', DB::raw('COUNT(*) as jml'))
            ->groupBy('guru_id')
            ->orderByDesc('jml')
            ->with(['guruWali.user:id,name'])
            ->limit(5)
            ->get()
            ->map(fn($r) => [
                'label' => $r->guruWali?->user?->name ?? '—',
                'jml'   => (int) $r->jml,
            ]);

        // ===== Top 5 siswa paling sering dikonseling =====
        $topSiswa = Bimbingan::select('siswa_id', DB::raw('COUNT(*) as jml'))
            ->groupBy('siswa_id')
            ->orderByDesc('jml')
            ->with(['siswa:id,nama_siswa'])
            ->limit(5)
            ->get()
            ->map(fn($r) => [
                'label' => $r->siswa?->nama_siswa ?? '—',
                'jml'   => (int) $r->jml,
            ]);

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
