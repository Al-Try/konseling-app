<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\GuruWali;
use App\Models\JenisBimbingan;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ======= KPI =======
        $stats = [
            'totalSiswa'     => Siswa::count(),
            'totalGuruWali'  => GuruWali::count(),
            'totalKelas'     => Kelas::count(),
            'totalKonseling' => Bimbingan::count(),
        ];

        // ======= Ranking (top 5) =======
        // Top guru (ambil nama dari user)
        $topGuru = Bimbingan::select('guru_id', DB::raw('COUNT(*) as jml'))
            ->with(['guruWali.user:id,name'])
            ->groupBy('guru_id')
            ->orderByDesc('jml')
            ->limit(5)
            ->get()
            ->map(fn($row) => [
                'label' => $row->guruWali?->user?->name ?? 'Tidak diketahui',
                'jml'   => (int) $row->jml,
            ]);

        // Top siswa
        $topSiswa = Bimbingan::select('siswa_id', DB::raw('COUNT(*) as jml'))
            ->with(['siswa:id,nama_siswa'])
            ->groupBy('siswa_id')
            ->orderByDesc('jml')
            ->limit(5)
            ->get()
            ->map(fn($row) => [
                'label' => $row->siswa?->nama_siswa ?? 'Tidak diketahui',
                'jml'   => (int) $row->jml,
            ]);

        // ======= Distribusi kategori =======
        $kategoriDistribusi = Bimbingan::select('jenis_id', DB::raw('COUNT(*) as jml'))
            ->groupBy('jenis_id')
            ->with(['jenis:id,nama_jenis'])
            ->get()
            ->map(fn($r) => [
                'label' => $r->jenis?->nama_jenis ?? 'Lainnya',
                'jml'   => (int) $r->jml,
            ]);

        // ======= Tren bulanan 12 bulan terakhir =======
        // Ambil raw dari DB
        $rawBulanan = Bimbingan::selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as ym, COUNT(*) as jml")
            ->where('tanggal', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('jml', 'ym'); // key=YM, val=count

        // Susun 12 bulan terakhir (agar bulan kosong jadi 0)
        $labels = [];
        $values = [];
        $cursor = now()->subMonths(11)->startOfMonth();
        for ($i = 0; $i < 12; $i++) {
            $ym = $cursor->format('Y-m');
            $labels[] = $cursor->isoFormat('MMM YYYY'); // contoh: Okt 2025
            $values[] = (int) ($rawBulanan[$ym] ?? 0);
            $cursor->addMonth();
        }

        // ======= Tabel kecil: siswa terbaru (opsional) =======
        $siswaTerbaru = Siswa::with('kelas')->latest()->limit(6)->get();

        return view('admin.dashboard', [
            'stats'               => $stats,
            'topGuru'             => $topGuru,
            'topSiswa'            => $topSiswa,
            'kategoriDistribusi'  => $kategoriDistribusi,
            'bulananLabels'       => $labels,
            'bulananValues'       => $values,
            'siswaTerbaru'        => $siswaTerbaru,
        ]);
    }
}
