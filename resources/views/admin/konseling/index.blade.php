@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Data Konseling</h1>

  @if($items->count())
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th><th>Tanggal</th><th>Siswa</th><th>Guru Wali</th><th>Jenis</th><th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $row)
          <tr>
            <td>{{ $row->id }}</td>
            <td>{{ $row->created_at?->format('d-m-Y') }}</td>
            <td>{{ $row->siswa->nama ?? '-' }}</td>
            <td>{{ $row->guruWali->user->nama_guru ?? '-' }}</td>
            <td>{{ $row->jenis->nama ?? '-' }}</td>
            <td><a href="{{ route('admin.konseling.show',$row) }}" class="btn btn-sm btn-primary">Detail</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
    {{ $items->links() }}
  @else
    <p>Belum ada data.</p>
  @endif
</div>
@endsection
