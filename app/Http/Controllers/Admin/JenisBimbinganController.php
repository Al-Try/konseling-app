<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JenisBimbinganController extends Controller
{
    public function index() {
        $data = JenisBimbingan::orderBy('nama_jenis')->get();
        return view('admin.jenis.index', compact('data'));
    }
    public function store(Request $r) {
        $val = $r->validate([
            'kode'=>['required','alpha_dash','unique:jenis_bimbingans,kode'],
            'nama_jenis'=>['required','string','max:100'],
            'poin'=>['required','integer'],
        ]);
        JenisBimbingan::create($val);
        return back()->with('ok','Jenis dibuat');
    }
    public function update(Request $r, JenisBimbingan $jenis) {
        $val = $r->validate([
            'kode'=>['required','alpha_dash', Rule::unique('jenis_bimbingans','kode')->ignore($jenis->id)],
            'nama_jenis'=>['required','string','max:100'],
            'poin'=>['required','integer'],
        ]);
        $jenis->update($val);
        return back()->with('ok','Jenis diperbarui');
    }
    public function destroy(JenisBimbingan $jenis) {
        $jenis->delete();
        return back()->with('ok','Jenis dihapus');
    }
}
