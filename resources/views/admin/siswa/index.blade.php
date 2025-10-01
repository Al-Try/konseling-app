@extends('layouts.app')
@section('title','Data Siswa')
@section('page_title','Data Siswa')

@section('content')
<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Daftar Siswa</span>
    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm">
      <i class="bi bi-plus"></i> Tambah
    </a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="tbl" class="table table-striped table-bordered align-middle">
        <thead>
          <tr>
            <th>#</th><th>NIS</th><th>Nama</th><th>Kelas</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        @foreach($siswa as $i => $row)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $row->nis ?? '-' }}</td>
            <td>{{ $row->nama_siswa ?? $row->nama ?? '-' }}</td>
            <td>{{ $row->kelas->nama ?? '-' }}</td>
            <td class="text-nowrap">
              <a href="{{ route('admin.siswa.edit',$row) }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('admin.siswa.destroy',$row) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Hapus data ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
{{-- aktifkan bila pakai DataTables CDN di layout --}}
{{-- 
<script>
  new DataTable('#tbl', { paging: true, searching: true, pageLength: 10 });
</script>
--}}
@endpush
