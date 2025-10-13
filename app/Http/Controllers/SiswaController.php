<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        // Ambil data dengan relasi kelas, gunakan paginate agar ringan
        $siswas = Siswa::with('kelas:id,nama_kelas')
            ->orderBy('nama_siswa')
            ->paginate(20);

        // kirim variabel plural: $siswas
        return view('admin.siswa.index', compact('siswas'));
    }
}
