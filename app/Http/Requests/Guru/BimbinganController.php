<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guru\StoreBimbinganRequest;
use App\Models\Bimbingan;
use App\Models\JenisBimbingan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BimbinganController extends Controller
{
    public function index(Request $request)
    {
        $guruId = auth()->user()->guruWali?->id;

        $items = Bimbingan::with(['siswa:id,nama_siswa','jenis:id,nama_jenis,tipe,poin'])
            ->where('guru_id', $guruId)
            ->latest('tanggal')
            ->paginate(15);

        return response()->json($items);
    }

    // metadata untuk form (opsional)
    public function create()
    {
        $jenis = JenisBimbingan::orderBy('nama_jenis')->get(['id','nama_jenis','poin','tipe']);
        return response()->json(['jenis' => $jenis]);
    }

    public function store(StoreBimbinganRequest $request)
    {
        $guruId = auth()->user()->guruWali?->id;

        $data = $request->validated();
        $data['guru_id'] = $guruId;

        // (opsional) validasi siswa memang boleh dibimbing oleh guru ini (kalau kamu ada relasi kelas-guru)
        // contoh cepat: pastikan siswa ada
        Siswa::findOrFail($data['siswa_id']);

        $jenis = JenisBimbingan::findOrFail($data['jenis_id']);
        $data['poin'] = (int) $jenis->poin;

        $bimbingan = DB::transaction(fn() => Bimbingan::create($data));

        return response()->json(['message'=>'created','data'=>$bimbingan], 201);
    }

    public function show(Bimbingan $bimbingan)
    {
        $this->authorize('view', $bimbingan);

        $bimbingan->load(['siswa:id,nama_siswa,kelas_id','jenis:id,nama_jenis,tipe,poin']);
        return response()->json($bimbingan);
    }

    // JSON autocomplete siswa
    public function siswaSearch(Request $request)
    {
        $term = $request->input('q');
        $items = Siswa::select('id','nama_siswa')
            ->when($term, fn($w)=>$w->where('nama_siswa','like',"%$term%"))
            ->orderBy('nama_siswa')->limit(20)->get();

        return response()->json($items);
    }
}
