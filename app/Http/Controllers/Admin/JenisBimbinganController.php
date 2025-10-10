<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JenisBimbinganRequest;
use App\Models\JenisBimbingan;

class JenisBimbinganController extends Controller
{
    public function index()
    {
        $data = JenisBimbingan::latest()->paginate(10);
        return view('admin.jenis.index', compact('data'));
    }

    public function create()
    {
        return view('admin.jenis.create');
    }

    public function store(JenisBimbinganRequest $request)
    {
        JenisBimbingan::create($request->validated());
        return back()->with('success','Jenis bimbingan dibuat.');
    }

    public function update(JenisBimbinganRequest $request, JenisBimbingan $jenis)
    {
        $jenis->update($request->validated());
        return back()->with('success','Jenis bimbingan diubah.');
    }

    public function edit(JenisBimbingan $jeni) // binding: parameter dari resource => singular default 'jeni'
    {
        return view('admin.jenis.edit', ['jenis' => $jeni]);
    }

    public function destroy(JenisBimbingan $jeni)
    {
        $jeni->delete();
        return back()->with('ok', 'Jenis bimbingan dihapus.');
    }
}
