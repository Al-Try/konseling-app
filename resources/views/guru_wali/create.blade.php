@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Guru Wali</h2>
    <form action="{{ route('guru-wali.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>NIP</label>
            <input type="text" name="nip" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('guru-wali.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
