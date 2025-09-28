@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Bimbingan</h2>
    <form action="{{ route('bimbingan.update', $bimbingan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Siswa</label>
            <select name="siswa_id" class="form-control" required>
                @foreach($siswa as $s)
                    <option value="{{ $s->id }}" {{ $bimbingan->siswa_id == $s->id ? 'selected' : '' }}>
                        {{ $s->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Guru Wali</label>
            <select name="guru_wali_id" class="form-control" required>
                @foreach($guru as $g)
                    <option value="{{ $g->id }}" {{ $bimbingan->guru_wali_id == $g->id ? 'selected' : '' }}>
                        {{ $g->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Jenis Bimbingan</label>
            <select name="jenis_bimbingan_id" class="form-control" required>
                @foreach($jenis as $j)
                    <option value="{{ $j->id }}" {{ $bimbingan->jenis_bimbingan_id == $j->id ? 'selected' : '' }}>
                        {{ $j->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required>{{ $bimbingan->deskripsi }}</textarea>
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $bimbingan->tanggal }}" required>
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('bimbingan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
