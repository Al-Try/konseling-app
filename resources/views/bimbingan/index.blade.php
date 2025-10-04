@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Bimbingan</h2>
    <a href="{{ route('bimbingan.create') }}" class="btn btn-primary mb-3">+ Tambah Bimbingan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Siswa</th>
                <th>Guru Wali</th>
                <th>Jenis Bimbingan</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bimbingan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->siswa->nama ?? '-' }}</td>
                    <td>{{ $item->guruWali->nama_guru ?? '-' }}</td>
                    <td>{{ $item->jenisBimbingan->nama ?? '-' }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>
                        <a href="{{ route('bimbingan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('bimbingan.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus bimbingan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $bimbingan->links() }}
</div>
@endsection
