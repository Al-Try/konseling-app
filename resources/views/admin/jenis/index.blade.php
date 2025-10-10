@extends('layouts.app')
@section('page_title','Jenis Bimbingan')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Jenis Bimbingan</h5>
    <a href="{{ route('admin.jenis.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-lg"></i> Tambah
    </a>
  </div>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

  <div class="card">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th>Nama</th><th>Tipe</th><th>Poin</th><th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $row)
            <tr>
              <td>{{ $row->nama_jenis }}</td>
              <td class="text-capitalize">{{ $row->tipe }}</td>
              <td>{{ $row->poin }}</td>
              <td class="text-end">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.jenis.edit',$row) }}">Edit</a>
                <form action="{{ route('admin.jenis.destroy',$row) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus data ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="4" class="text-center text-muted p-4">Belum ada data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">{{ $data->links() }}</div>
  </div>
</div>
@endsection
