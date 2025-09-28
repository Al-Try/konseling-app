<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        return Kelas::with('guruWali')->get();
    }

    public function store(Request $request)
    {
        return Kelas::create($request->all());
    }

    public function show($id)
    {
        return Kelas::with('guruWali')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());
        return $kelas;
    }

    public function destroy($id)
    {
        return Kelas::destroy($id);
    }
}