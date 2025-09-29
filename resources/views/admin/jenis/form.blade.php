@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto p-6 bg-white shadow rounded">
  <form method="POST"
        action="{{ $model->exists ? route('admin.jenis.update',$model) : route('admin.jenis.store') }}">
    @csrf @if($model->exists) @method('PUT') @endif

    <label class="block mb-2">Nama Jenis</label>
    <input name="nama_jenis" value="{{ old('nama_jenis',$model->nama_jenis) }}" class="input w-full" required>

    <label class="block mt-4 mb-2">Tipe</label>
    <select name="tipe" class="input w-full">
      <option value="">-</option>
      <option value="positif" @selected(old('tipe',$model->tipe)=='positif')>Positif</option>
      <option value="negatif" @selected(old('tipe',$model->tipe)=='negatif')>Negatif</option>
    </select>

    <label class="block mt-4 mb-2">Poin Default</label>
    <input type="number" name="poin" value="{{ old('poin',$model->poin) }}" class="input w-full" required>

    <div class="mt-6 flex gap-2">
      <button class="btn-primary">Simpan</button>
      <a href="{{ route('admin.jenis.index') }}" class="btn">Batal</a>
    </div>
  </form>
</div>
@endsection
