<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Siswa;
use App\Models\GuruWali;
use App\Models\JenisBimbingan;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index()
    {
        $bimbingan = Bimbingan::with(['siswa','guruWali','jenisBimbingan'])->paginate(10);
        return view('bimbingan.index', compact('bimbingan'));
    }

    public function create()
    {
        $siswa = Siswa::all();
        $guru = GuruWali::all();
        $jenis = JenisBimbingan::all();
        return view('bimbingan.create', compact('siswa','guru','jenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'guru_wali_id' => 'required',
            'jenis_bimbingan_id' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
        ]);

        Bimbingan::create($request->all());
        return redirect()->route('bimbingan.index')->with('success', 'Bimbingan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $bimbingan = Bimbingan::findOrFail($id);
        $siswa = Siswa::all();
        $guru = GuruWali::all();
        $jenis = JenisBimbingan::all();
        return view('bimbingan.edit', compact('bimbingan','siswa','guru','jenis'));
    }

    public function update(Request $request, $id)
    {
        $bimbingan = Bimbingan::findOrFail($id);

        $request->validate([
            'siswa_id' => 'required',
            'guru_wali_id' => 'required',
            'jenis_bimbingan_id' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
        ]);

        $bimbingan->update($request->all());
        return redirect()->route('bimbingan.index')->with('success', 'Bimbingan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $bimbingan = Bimbingan::findOrFail($id);
        $bimbingan->delete();
        return redirect()->route('bimbingan.index')->with('success', 'Bimbingan berhasil dihapus');
    }
}
