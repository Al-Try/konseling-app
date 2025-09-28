@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Guru Wali</h2>
    <form action="{{ route('guru-wali.update', $guru->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $guru->nama }}" required>
        </div>
        <div class="mb-3">
            <label>NIP</label>
            <input type="text" name="nip" class="form-control" value="{{ $guru->nip }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $guru->email }}" required>
        </div>
        <div class="mb-3">
            <label>Password (isi kalau mau ganti)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('guru-wali.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
