<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function rekapSiswa(Siswa $siswa)
    {
        $riwayat = Bimbingan::with(['jenis','guruWali.user'])
            ->where('siswa_id', $siswa->id)
            ->orderByDesc('tanggal')
            ->get();

        $pdf = Pdf::loadView('admin.laporan.rekap_siswa', [
            'siswa' => $siswa,
            'riwayat' => $riwayat,
            'total_poin' => $riwayat->sum('poin'),
        ])->setPaper('a4');

        return $pdf->download("Rekap-{$siswa->nama_siswa}.pdf");
    }

    public function rankingGuru()
    {
        $ranking = Bimbingan::select('guru_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('guru_id')
            ->with('guruWali.user')
            ->orderByDesc('jumlah')
            ->limit(20)
            ->get();

        $pdf = Pdf::loadView('admin.laporan.ranking_guru', [
            'ranking' => $ranking,
        ])->setPaper('a4', 'portrait');

        return $pdf->download("Ranking-Guru-Wali.pdf");
    }
}
