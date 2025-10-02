<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

    class SiswaController extends Controller
    {
        public function index() {
            $data = Siswa::with('kelas')->latest()->paginate(20);
            return view('admin.siswa.index', compact('data'));
        }
        public function create() {
            $kelas = Kelas::orderBy('nama_kelas')->get();
            return view('admin.siswa.create', compact('kelas'));
        }
        public function store(SiswaRequest $r) {
            Siswa::create($r->validated());
            return back()->with('ok','Siswa ditambahkan');
        }
        public function edit(Siswa $siswa) {
            $kelas = Kelas::orderBy('nama_kelas')->get();
            return view('admin.siswa.edit', compact('siswa','kelas'));
        }
        public function update(SiswaRequest $r, Siswa $siswa) {
            $siswa->update($r->validated());
            return back()->with('ok','Siswa diperbarui');
        }
        public function destroy(Siswa $siswa) {
            $siswa->delete();
            return back()->with('ok','Siswa dihapus');
        }
    }
