<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\KonselingStoreRequest;
use App\Models\{Bimbingan,JenisBimbingan,Siswa};
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    public function index()
    {
        $gwId = Auth::user()->guruWali?->id;
        $data = Bimbingan::with(['siswa','jenis'])
            ->where('guru_id', $gwId)
            ->latest('tanggal')->paginate(20);
        return view('guru.bimbingan.index', compact('data'));
    }

    public function create()
    {
        $jenis = JenisBimbingan::orderBy('nama_jenis')->get();
        return view('guru.bimbingan.form', compact('jenis'));
    }

    public function store(KonselingStoreRequest $req)
    {
        $gwId  = Auth::user()->guruWali?->id;
        $jenis = JenisBimbingan::findOrFail($req->jenis_id);

        Bimbingan::create([
            'guru_id'   => $gwId,
            'siswa_id'  => $req->siswa_id,
            'jenis_id'  => $req->jenis_id,
            'tanggal'   => $req->tanggal,
            'jam'       => $req->jam ?? now()->format('H:i:s'),
            'catatan'   => $req->catatan,
            'poin'      => $jenis->poin, // opsional kalau kolom ini ada
        ]);

        return redirect()->route('guru.bimbingan.index')->with('ok','Tersimpan');
    }

    // --- API untuk autocomplete siswa di kelas guru wali ---
    public function siswaSearch()
    {
        $kelasIds = Auth::user()->guruWali?->kelas()->pluck('id'); // jika relasi wali->kelas() sudah ada
        $q = request('q','');
        $siswa = Siswa::whereIn('kelas_id', $kelasIds ?: [])
            ->when($q, fn($qq)=>$qq->where('nama_siswa','like',"%$q%"))
            ->limit(20)->get(['id','nama_siswa']);

        return $siswa->map(fn($s)=>['id'=>$s->id,'text'=>$s->nama_siswa]);
    }
}
