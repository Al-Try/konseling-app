<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\Request;

class KonselingController extends Controller
{
    public function index(Request $request)
    {
        $qTanggal = $request->input('tanggal'); // yyyy-mm / yyyy-mm-dd
        $qJenis   = $request->input('jenis_id'); // filter jenis

        $items = Bimbingan::with([
                'siswa:id,nama_siswa',
                'guruWali:id,nama_guru',
                'jenis:id,nama_jenis,tipe,poin'
            ])
            ->when($qTanggal, function($w) use ($qTanggal) {
                if (strlen($qTanggal) === 7) { // yyyy-mm
                    $w->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$qTanggal]);
                } else {
                    $w->whereDate('tanggal', $qTanggal);
                }
            })
            ->when($qJenis, fn($w)=>$w->where('jenis_id',$qJenis))
            ->latest('tanggal')
            ->paginate(20);

        return response()->json($items);
    }

    public function show(Bimbingan $konseling)
    {
        $konseling->load(['siswa:id,nama_siswa,kelas_id','guruWali:id,nama_guru','jenis:id,nama_jenis,tipe,poin']);
        return response()->json($konseling);
    }
}
