@extends('layouts.app')
@section('page_title','Data Siswa')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-header bg-white fw-semibold d-flex align-items-center justify-content-between">
    <span>Data Siswa</span>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.siswa.template') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-download"></i> Template
      </a>
      <a href="{{ route('admin.siswa.import.form') }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-upload"></i> Import
      </a>
      <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Tambah
      </a>
    </div>
  </div>

  <div class="card-body border-bottom">
    <form class="row g-2" method="get" action="{{ route('admin.siswa.index') }}">
      <div class="col-md-6">
        <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Cari nama atau NIS...">
      </div>
      <div class="col-md-4">
        <select name="kelas_id" class="form-select">
          <option value="">— Semua Kelas —</option>
          @foreach($kelas as $k)
            <option value="{{ $k->id }}" @selected(($kelas_id ?? null) == $k->id)>{{ $k->nama_kelas }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2 d-grid">
        <button class="btn btn-secondary"><i class="bi bi-search"></i> Filter</button>
      </div>
    </form>
  </div>

  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead class="table-light">
        <tr>
          <th style="width:60px">#</th>
          <th>NIS</th>
          <th>Nama</th>
          <th>Kelas</th>
          <th style="width:140px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($siswas as $s)
          <tr>
            <td>
              {{ method_exists($siswas,'currentPage')
                  ? ($loop->iteration + ($siswas->currentPage()-1)*$siswas->perPage())
                  : $loop->iteration }}
            </td>
            <td>{{ $s->nis }}</td>
            <td>{{ $s->nama_siswa }}</td>
            <td>{{ $s->kelas?->nama_kelas ?? '-' }}</td>
            <td class="text-nowrap">
              <a href="{{ route('admin.siswa.edit',$s->id) }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('admin.siswa.destroy',$s->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Hapus siswa ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@if(method_exists($siswas,'links'))
  <div class="mt-3">{{ $siswas->links() }}</div>
@endif
@endsection
