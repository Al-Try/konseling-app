@extends('layouts.app')
@section('page_title','Tambah Jenis Bimbingan')

@section('content')
<div class="container-fluid" style="max-width:720px">
  <h5 class="mb-3">Tambah Jenis Bimbingan</h5>
  <form method="POST" action="{{ route('admin.jenis.store') }}" class="card card-body">
    @csrf
    <div class="mb-3">
      <label class="form-label">Nama Jenis</label>
      <input name="nama_jenis" value="{{ old('nama_jenis') }}" class="form-control" required>
      @error('nama_jenis') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Tipe</label>
      <select name="tipe" class="form-select" required>
        <option value="">-- pilih --</option>
        <option value="positif" @selected(old('tipe')==='positif')>Positif</option>
        <option value="negatif" @selected(old('tipe')==='negatif')>Negatif</option>
      </select>
      @error('tipe') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Poin</label>
      <input type="number" name="poin" value="{{ old('poin',0) }}" class="form-control" required>
      @error('poin') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-primary">Simpan</button>
      <a href="{{ route('admin.jenis.index') }}" class="btn btn-light">Batal</a>
    </div>
  </form>
</div>
@endsection
