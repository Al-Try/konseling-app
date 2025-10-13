@extends('layouts.app')
@section('page_title','Data Bimbingan')
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Data Bimbingan</h5>
  </div>

  <div class="card shadow-sm border-0">
    <div class="card-body p-0">
      <table class="table mb-0 align-middle">
        <thead class="table-light">
          <tr>
            <th>Tanggal</th><th>Siswa</th><th>Jenis</th><th>Guru</th>
          </tr>
        </thead>
        <tbody>
        @forelse($rows as $r)
          <tr>
            <td>{{ $r->tanggal?->format('d/m/Y') }}</td>
            <td>{{ $r->siswa?->nama_siswa }}</td>
            <td>{{ $r->jenis?->nama_jenis }}</td>
            <td>{{ $r->guruWali?->user?->name }}</td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer bg-white">{{ $rows->links() }}</div>
  </div>
</div>
@endsection
