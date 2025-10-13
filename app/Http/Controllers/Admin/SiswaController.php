<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSiswaRequest;
use App\Http\Requests\Admin\UpdateSiswaRequest;
use App\Imports\SiswasImport;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $q        = trim((string)$request->get('q'));
        $kelas_id = $request->get('kelas_id');

        $siswas = Siswa::with('kelas:id,nama_kelas')
            ->when($q !== '', function ($w) use ($q) {
                $w->where(function ($s) use ($q) {
                    $s->where('nama_siswa', 'like', "%{$q}%")
                      ->orWhere('nis', 'like', "%{$q}%");
                });
            })
            ->when($kelas_id, fn($w) => $w->where('kelas_id', $kelas_id))
            ->orderBy('nama_siswa')
            ->paginate(20)
            ->appends($request->query());

        $kelas = Kelas::orderBy('nama_kelas')->get(['id','nama_kelas']);

        return view('admin.siswa.index', compact('siswas','q','kelas','kelas_id'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get(['id','nama_kelas']);
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(StoreSiswaRequest $request)
    {
        Siswa::create($request->validated());
        return redirect()->route('admin.siswa.index')->with('status','Siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get(['id','nama_kelas']);
        return view('admin.siswa.edit', compact('siswa','kelas'));
    }

    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
        $siswa->update($request->validated());
        return redirect()->route('admin.siswa.index')->with('status','Siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return back()->with('status','Siswa berhasil dihapus.');
    }

    // ===== IMPORT =====
    public function importForm()
    {
        return view('admin.siswa.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,txt|max:20480',
        ]);

        Excel::import(new SiswasImport, $request->file('file'));

        return redirect()->route('admin.siswa.index')->with('status','Import selesai.');
    }

    public function downloadTemplate(): StreamedResponse
    {
        $csv = implode("\n", [
            'nis,nama,kelas,jk,tanggal_lahir',
            '20010001,Budi Santoso,X IPA 1,L,2007-01-02',
            '20010002,Siti Aminah,X IPS 1,P,2007-05-21',
        ]);

        return response()->streamDownload(
            fn() => print($csv),
            'template_siswa.csv',
            ['Content-Type' => 'text/csv; charset=UTF-8']
        );
    }
}
