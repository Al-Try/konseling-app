@extends('layouts.app')
@section('page_title','Import Siswa')

@section('content')
<div class="card shadow-sm border-0" style="max-width:640px">
  <div class="card-header bg-white fw-semibold d-flex justify-content-between">
    <span>Import Siswa</span>
    <a href="{{ route('admin.siswa.template') }}" class="btn btn-sm btn-outline-secondary">
      <i class="bi bi-download"></i> Template
    </a>
  </div>

  <form class="card-body" method="POST" action="{{ route('admin.siswa.import.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label class="form-label">File (.xlsx / .csv)</label>
      <input type="file" name="file" accept=".xlsx,.csv,.txt" class="form-control" required>
      <div class="form-text">Header: <code>nis,nama,kelas,jk,tanggal_lahir</code></div>
      @error('file') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-primary">Upload & Import</button>
      <a href="{{ route('admin.siswa.index') }}" class="btn btn-light">Batal</a>
    </div>
  </form>
</div>
@endsection
