@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Siswa</h1>

    <form action="{{ route('admin.siswa.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Siswa</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="kelas_id" class="form-label">Kelas</label>
            <select name="kelas_id" id="kelas_id" class="form-control" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach(\App\Models\Kelas::all() as $kelas)
                    <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
