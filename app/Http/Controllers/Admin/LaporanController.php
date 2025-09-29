<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Siswa,Bimbingan};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // Rekap per siswa
    public function siswa($siswaId)
    {
        $siswa = Siswa::with('kelas')->findOrFail($siswaId);
        $riwayat = Bimbingan::with(['jenis','guruWali.user'])
            ->where('siswa_id', $siswaId)
            ->orderByDesc('tanggal')->get();

        $pdf = Pdf::loadView('admin.laporan.siswa', compact('siswa','riwayat'));
        return $pdf->stream("laporan_siswa_{$siswa->id}.pdf");
    }

    // Ranking guru wali paling aktif dalam rentang waktu (opsional filter)
    public function ranking()
    {
        $rows = Bimbingan::select('guru_id', DB::raw('COUNT(*) as jml'))
            ->with('guruWali.user:id,name')
            ->groupBy('guru_id')
            ->orderByDesc('jml')
            ->get();

        $pdf = Pdf::loadView('admin.laporan.ranking_guru', compact('rows'));
        return $pdf->stream("ranking_guru.pdf");
    }
}
