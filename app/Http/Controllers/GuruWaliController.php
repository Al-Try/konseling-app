<?php

namespace App\Http\Controllers;

use App\Models\GuruWali;
use Illuminate\Http\Request;

class GuruWaliController extends Controller
{
    public function index()
    {
        $guru = GuruWali::paginate(10);
        return view('guru_wali.index', compact('guru'));
    }

    public function create()
    {
        return view('guru_wali.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:guru_walis',
            'email' => 'required|email|unique:guru_walis',
            'password' => 'required|min:6',
        ]);

        GuruWali::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('guru-wali.index')->with('success', 'Guru wali berhasil ditambahkan');
    }

    public function edit($id)
    {
        $guru = GuruWali::findOrFail($id);
        return view('guru_wali.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = GuruWali::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:guru_walis,nip,'.$id,
            'email' => 'required|email|unique:guru_walis,email,'.$id,
        ]);

        $guru->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $guru->password,
        ]);

        return redirect()->route('guru-wali.index')->with('success', 'Guru wali berhasil diperbarui');
    }

    public function destroy($id)
    {
        $guru = GuruWali::findOrFail($id);
        $guru->delete();
        return redirect()->route('guru-wali.index')->with('success', 'Guru wali berhasil dihapus');
    }
}
