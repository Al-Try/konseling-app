<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Siswa,Bimbingan};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function rekapSiswa($siswaId) {
        $siswa = Siswa::with('kelas')->findOrFail($siswaId);
        $riwayat = Bimbingan::with(['jenis','guruWali.user'])
            ->where('siswa_id',$siswaId)->orderByDesc('tanggal')->get();

        return Pdf::loadView('laporan.rekap_siswa', compact('siswa','riwayat'))
                  ->stream("laporan_siswa_{$siswa->id}.pdf");
    }

    public function rankingGuru() {
        $rows = Bimbingan::select('guru_id', DB::raw('COUNT(*) as jml'))
            ->with('guruWali.user:id,name')->groupBy('guru_id')
            ->orderByDesc('jml')->get();

        return Pdf::loadView('laporan.ranking_guru', compact('rows'))
                  ->stream("ranking_guru.pdf");
    }
}
