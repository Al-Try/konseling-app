<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JenisBimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = \App\Models\JenisBimbingan::orderBy('nama_jenis')->paginate(20);
        return view('admin.jenis.index', compact('data'));
    }
    public function create()
    {
        return view('admin.jenis.form', ['model' => new \App\Models\JenisBimbingan()]);
    }
    public function store(\App\Http\Requests\JenisBimbinganStoreRequest $req)
    {
        \App\Models\JenisBimbingan::create($req->validated());
        return redirect()->route('admin.jenis.index')->with('ok','Tersimpan');
    }
    public function edit(\App\Models\JenisBimbingan $jenis)
    {
        return view('admin.jenis.form', ['model'=>$jenis]);
    }
    public function update(\App\Http\Requests\JenisBimbinganUpdateRequest $req, \App\Models\JenisBimbingan $jenis)
    {
        $jenis->update($req->validated());
        return redirect()->route('admin.jenis.index')->with('ok','Tersimpan');
    }
    public function destroy(\App\Models\JenisBimbingan $jenis)
    {
        $jenis->delete();
        return back()->with('ok','Terhapus');
    }
}
