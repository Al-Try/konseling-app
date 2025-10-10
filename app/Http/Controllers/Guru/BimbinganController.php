<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guru\StoreBimbinganRequest;
use App\Models\Bimbingan;
use App\Models\GuruWali;
use App\Models\JenisBimbingan;
use App\Models\Siswa;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guruWali; // relasi user->guruWali
        $list = Bimbingan::with(['siswa','jenis'])
            ->where('guru_id', $guru->id ?? 0)
            ->latest('tanggal')
            ->paginate(12);

        return view('guru.bimbingan.index', compact('list'));
    }

    public function create()
    {
        $jenis = JenisBimbingan::orderBy('nama_jenis')->get();
        return view('guru.bimbingan.create', compact('jenis'));
    }

    public function store(StoreBimbinganRequest $request)
    {
        $guru = auth()->user()->guruWali;
        Bimbingan::create([
            'tanggal'  => $request->tanggal,
            'siswa_id' => $request->siswa_id,
            'guru_id'  => $guru->id,
            'jenis_id' => $request->jenis_id,
            'catatan'  => $request->catatan,
            'poin'     => optional(JenisBimbingan::find($request->jenis_id))->poin ?? 0,
        ]);

        return redirect()->route('guru.bimbingan.index')->with('ok','Bimbingan tersimpan.');
    }

    // Autocomplete siswa (by nama)
    public function siswaSearch(Request $request)
    {
        $q = (string)$request->get('q', '');
        $items = Siswa::query()
            ->with('kelas:id,nama_kelas')
            ->when($q, fn($r) => $r->where('nama_siswa','like',"%$q%"))
            ->limit(10)->get(['id','nama_siswa','kelas_id']);

        return response()->json(
            $items->map(fn($s) => [
                'id'   => $s->id,
                'text' => $s->nama_siswa.' — '.$s->kelas?->nama_kelas,
            ])
        );
    }
}
