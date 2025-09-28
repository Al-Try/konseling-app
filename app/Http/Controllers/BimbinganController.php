<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index()
    {
        return Bimbingan::with(['siswa', 'guruWali', 'jenisBimbingan'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'guru_wali_id' => 'required|exists:guru_walis,id',
            'jenis_bimbingan_id' => 'required|exists:jenis_bimbingans,id',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        return Bimbingan::create($data);
    }

    public function show(Bimbingan $bimbingan)
    {
        return $bimbingan->load(['siswa', 'guruWali', 'jenisBimbingan']);
    }

    public function update(Request $request, Bimbingan $bimbingan)
    {
        $data = $request->validate([
            'siswa_id' => 'sometimes|exists:siswas,id',
            'guru_wali_id' => 'sometimes|exists:guru_walis,id',
            'jenis_bimbingan_id' => 'sometimes|exists:jenis_bimbingans,id',
            'deskripsi' => 'sometimes|string',
            'tanggal' => 'sometimes|date',
        ]);

        $bimbingan->update($data);
        return $bimbingan;
    }

    public function destroy(Bimbingan $bimbingan)
    {
        $bimbingan->delete();
        return response()->noContent();
    }
}