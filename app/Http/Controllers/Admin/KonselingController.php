<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;

class KonselingController extends Controller
{
    public function index()
    {
        $items = Bimbingan::with(['siswa','guruWali','jenis'])->latest()->paginate(15);
        return view('admin.konseling.index', compact('items'));
    }

    public function show(Bimbingan $konseling)
    {
        $konseling->load(['siswa','guruWali','jenis']);
        return view('admin.konseling.show', compact('konseling'));
    }
}
