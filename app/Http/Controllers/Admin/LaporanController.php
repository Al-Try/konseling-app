<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // Ranking guru berdasar jumlah bimbingan
    public function rankingGuru()
    {
        $data = Bimbingan::select('guru_id', DB::raw('COUNT(*) as jml'))
            ->with(['guruWali.user:id,name'])
            ->groupBy('guru_id')
            ->orderByDesc('jml')
            ->get();

        $pdf = Pdf::loadView('admin.laporan.ranking_guru', compact('data'));
        return $pdf->download('ranking-guru.pdf');
    }

    // Rekap bimbingan per siswa
    public function rekapSiswa(Siswa $siswa)
    {
        $list = Bimbingan::with(['jenis:id,nama_jenis,poin', 'guruWali.user:id,name'])
            ->where('siswa_id', $siswa->id)
            ->orderBy('tanggal')
            ->get();

        $pdf = Pdf::loadView('admin.laporan.rekap_siswa', compact('siswa', 'list'));
        return $pdf->download('rekap-siswa-'.$siswa->id.'.pdf');
    }
}
