<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\JenisBimbingan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    public function index()
    {
        $rows = Bimbingan::with(['siswa:id,nama_siswa','jenis:id,nama_jenis'])
            ->where('guru_id', Auth::user()->guruWali->id ?? 0)
            ->latest('tanggal')->paginate(10);

        return view('guru.bimbingan.index', compact('rows'));
    }

    public function create()
    {
        $jenis = JenisBimbingan::orderBy('nama_jenis')->pluck('nama_jenis','id');
        return view('guru.bimbingan.create', compact('jenis'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal'  => 'required|date',
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_id' => 'required|exists:jenis_bimbingans,id',
            'catatan'  => 'nullable|string|max:500',
        ]);

        $data['guru_id'] = Auth::user()->guruWali->id ?? null;
        abort_if(!$data['guru_id'], 403, 'Akun guru wali belum terhubung');

        Bimbingan::create($data);

        return redirect()->route('guru.bimbingan.index')->with('ok','Bimbingan tersimpan.');
    }

    public function show(Bimbingan $bimbingan)
    {
        $this->authorizeBimbingan($bimbingan);
        return view('guru.bimbingan.show', compact('bimbingan'));
    }

    // Ajax: cari siswa untuk autocomplete
    public function siswaSearch(Request $request)
    {
        $q = trim($request->get('q',''));
        $res = Siswa::where('nama_siswa','like',"%$q%")
            ->orderBy('nama_siswa')->limit(10)
            ->get(['id','nama_siswa'])
            ->map(fn($s) => ['id'=>$s->id,'text'=>$s->nama_siswa]);

        return response()->json(['results'=>$res]);
    }

    private function authorizeBimbingan(Bimbingan $b)
    {
        $mine = Auth::user()->guruWali->id ?? 0;
        abort_if($b->guru_id != $mine, 403);
    }
}
