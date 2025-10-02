<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\KonselingStoreRequest;
use App\Models\{Bimbingan,JenisBimbingan,Siswa};
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    public function __construct() { $this->authorizeResource(Bimbingan::class, 'bimbingan'); }

    public function index() {
        $user = auth()->user();
        $guru = GuruWali::where('user_id',$user->id)->firstOrFail();
        $data = Bimbingan::with(['siswa.kelas','jenis'])
            ->where('guru_id',$guru->id)
            ->latest('tanggal')->paginate(20);
        return view('guru.bimbingan.index', compact('data'));
    }

    public function create() {
        $jenis = JenisBimbingan::orderBy('nama_jenis')->get();
        // siswa dari kelas yang dibimbing? (opsional filter)
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        return view('guru.bimbingan.create', compact('jenis','siswa'));
    }

    public function store(BimbinganRequest $r) {
        $guru = GuruWali::where('user_id', auth()->id())->firstOrFail();
        $j    = JenisBimbingan::findOrFail($r->jenis_id);

        Bimbingan::create([
            ...$r->validated(),
            'guru_id' => $guru->id,
            'poin'    => $j->poin, // cache poin
        ]);

        return redirect()->route('guru.bimbingan.index')->with('ok','Bimbingan tersimpan');
    }
}
