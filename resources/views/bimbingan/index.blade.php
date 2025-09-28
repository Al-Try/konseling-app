@extends('layouts.guru')

@section('title', 'Riwayat Bimbingan')

@section('content')
<h2>Riwayat Bimbingan</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Siswa</th>
            <th>Jenis</th>
            <th>Tanggal</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bimbingans as $b)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $b->siswa->nama_siswa }}</td>
            <td>{{ $b->jenis->nama_jenis }}</td>
            <td>{{ $b->tanggal }}</td>
            <td>{{ $b->catatan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
