@extends('layouts.guru')

@section('title', 'Tambah Bimbingan')

@section('content')
<h2>Tambah Bimbingan</h2>

<form action="{{ route('bimbingan.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Siswa</label>
        <select name="siswa_id" class="form-control" required>
            <option value="">-- Pilih Siswa --</option>
            @foreach($siswas as $siswa)
                <option value="{{ $siswa->id }}">{{ $siswa->nama_siswa }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Jenis Bimbingan</label>
        <select name="jenis_id" class="form-control" required>
            <option value="">-- Pilih Jenis --</option>
            @foreach($jenis as $j)
                <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Catatan</label>
        <textarea name="catatan" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('bimbingan.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
