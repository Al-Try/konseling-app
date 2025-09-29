@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto p-6">
  <div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold">Jenis Bimbingan</h1>
    <a href="{{ route('admin.jenis.create') }}" class="btn">Tambah</a>
  </div>
  <table class="w-full bg-white shadow rounded">
    <thead><tr><th>Nama</th><th>Tipe</th><th>Poin</th><th></th></tr></thead>
    <tbody>
      @foreach($data as $r)
      <tr class="border-t">
        <td>{{ $r->nama_jenis }}</td>
        <td>{{ $r->tipe ?? '-' }}</td>
        <td>{{ $r->poin }}</td>
        <td class="text-right">
          <a href="{{ route('admin.jenis.edit',$r) }}" class="text-blue-600">Edit</a>
          <form action="{{ route('admin.jenis.destroy',$r) }}" method="POST" class="inline">
            @csrf @method('DELETE')
            <button class="text-red-600" onclick="return confirm('Hapus?')">Hapus</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $data->links() }}</div>
</div>
@endsection
