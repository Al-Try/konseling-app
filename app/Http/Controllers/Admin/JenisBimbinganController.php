<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JenisBimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    


    public function index()  { $data = JenisBimbingan::orderBy('nama_jenis')->paginate(20); return view('admin.jenis.index',compact('data')); }
   
    public function create() { return view('admin.jenis.form',['model'=>new JenisBimbingan()]); }
    
    public function store(JenisBimbinganStoreRequest $r) { JenisBimbingan::create($r->validated()); return to_route('admin.jenis.index')->with('ok','Tersimpan'); }
   
    public function edit(JenisBimbingan $jenis)  { return view('admin.jenis.form',['model'=>$jenis]); }
    
    public function update(JenisBimbinganUpdateRequest $r, JenisBimbingan $jenis) { $jenis->update($r->validated()); return to_route('admin.jenis.index')->with('ok','Tersimpan'); }
    
    public function destroy(JenisBimbingan $jenis) { $jenis->delete(); return back()->with('ok','Terhapus'); }

}
