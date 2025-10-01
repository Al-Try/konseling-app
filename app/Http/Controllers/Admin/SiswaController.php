<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index() {
        $items = Siswa::latest()->paginate(15);
        return view('admin.siswa.index', compact('items'));
    }

    public function create() {
        return view('admin.siswa.create'); // pastikan view ada
    }

    public function store(Request $request) {
        // validasi + simpan
    }

    // ... dst: show/edit/update/destroy sesuai kebutuhan
}
