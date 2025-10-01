<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\KonselingStoreRequest;
use App\Models\{Bimbingan,JenisBimbingan,Siswa};
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    public function index() {
        $gwId = Auth::user()->guruWali?->id;
        $data = Bimbingan::with(['siswa','jenis'])
            ->where('guru_id',$gwId)
            ->latest('tanggal')->paginate(20);
        return view('guru.bimbingan.index', compact('data'));
    }

    public function create() {
        $jenis = JenisBimbingan::orderBy('nama_jenis')->get();
        return view('guru.bimbingan.form', compact('jenis'));
    }

    public function store(KonselingStoreRequest $r) {
        $gwId  = Auth::user()->guruWali?->id;
        $jenis = JenisBimbingan::findOrFail($r->jenis_id);

        Bimbingan::create([
            'guru_id'  => $gwId,
            'siswa_id' => $r->siswa_id,
            'jenis_id' => $r->jenis_id,
            'tanggal'  => $r->tanggal,
            'jam'      => $r->jam ?? now()->format('H:i:s'),
            'catatan'  => $r->catatan,
            'poin'     => $jenis->poin, // simpan poin default
        ]);

        return to_route('guru.bimbingan.index')->with('ok','Tersimpan');
    }

    // autocomplete siswa milik kelas yang diampu guru wali
    public function siswaSearch() {
        $kelasIds = Auth::user()->guruWali?->kelas()->pluck('id') ?? [];
        $q = request('q','');

        $siswa = Siswa::whereIn('kelas_id', $kelasIds)
            ->when($q, fn($qq)=>$qq->where('nama_siswa','like',"%$q%"))
            ->limit(20)->get(['id','nama_siswa']);

        return $siswa->map(fn($s)=>['id'=>$s->id,'text'=>$s->nama_siswa]);
    }
}