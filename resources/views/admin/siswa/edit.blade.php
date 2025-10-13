@extends('layouts.app')
@section('page_title','Edit Siswa')

@section('content')
<div class="card shadow-sm border-0" style="max-width:720px">
  <div class="card-header bg-white fw-semibold">Edit Siswa</div>
  <form class="card-body" method="POST" action="{{ route('admin.siswa.update',$siswa->id) }}">
    @csrf @method('PUT')

    <div class="mb-3">
      <label class="form-label">NIS</label>
      <input name="nis" value="{{ old('nis',$siswa->nis) }}" class="form-control" required>
      @error('nis') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input name="nama_siswa" value="{{ old('nama_siswa',$siswa->nama_siswa) }}" class="form-control" required>
      @error('nama_siswa') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Kelas</label>
      <select name="kelas_id" class="form-select">
        <option value="">— pilih —</option>
        @foreach($kelas as $k)
          <option value="{{ $k->id }}" @selected(old('kelas_id',$siswa->kelas_id)==$k->id)>{{ $k->nama_kelas }}</option>
        @endforeach
      </select>
      @error('kelas_id') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">JK</label>
        <select name="jk" class="form-select">
          <option value="">—</option>
          <option value="L" @selected(old('jk',$siswa->jk)=='L')>L</option>
          <option value="P" @selected(old('jk',$siswa->jk)=='P')>P</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir',$siswa->tanggal_lahir?->format('Y-m-d')) }}" class="form-control">
      </div>
    </div>

    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-primary">Simpan</button>
      <a href="{{ route('admin.siswa.index') }}" class="btn btn-light">Batal</a>
    </div>
  </form>
</div>
@endsection
