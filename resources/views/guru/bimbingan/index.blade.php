@extends('layouts.app')
@section('page_title','Bimbingan Saya')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Bimbingan Saya</h5>
    <a class="btn btn-primary" href="{{ route('guru.bimbingan.create') }}">
      <i class="bi bi-journal-plus"></i> Tambah
    </a>
  </div>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

  <div class="card">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th>Tanggal</th><th>Siswa</th><th>Jenis</th><th>Poin</th><th>Catatan</th>
          </tr>
        </thead>
        <tbody>
          @forelse($list as $r)
            <tr>
              <td>{{ $r->tanggal->format('d/m/Y') }}</td>
              <td>{{ $r->siswa?->nama_siswa }}</td>
              <td>{{ $r->jenis?->nama_jenis }}</td>
              <td>{{ $r->poin }}</td>
              <td class="text-muted">{{ Str::limit($r->catatan, 60) }}</td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted p-4">Belum ada data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">{{ $list->links() }}</div>
  </div>
</div>
@endsection
