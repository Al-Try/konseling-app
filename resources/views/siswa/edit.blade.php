@extends('layouts.admin')

@section('title', 'Edit Siswa')

@section('content')
<h2>Edit Siswa</h2>

<form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Nama Siswa</label>
        <input type="text" name="nama_siswa" class="form-control" value="{{ $siswa->nama_siswa }}" required>
    </div>
    <div class="mb-3">
        <label>NIS</label>
        <input type="text" name="nis" class="form-control" value="{{ $siswa->nis }}" required>
    </div>
    <div class="mb-3">
        <label>Kelas</label>
        <select name="kelas_id" class="form-control" required>
            @foreach($kelas as $k)
                <option value="{{ $k->id }}" @if($siswa->kelas_id == $k->id) selected @endif>
                    {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
