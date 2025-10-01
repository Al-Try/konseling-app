@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Detail Konseling #{{ $konseling->id }}</h1>
  <ul>
    <li>Tanggal: {{ $konseling->created_at?->format('d-m-Y H:i') }}</li>
    <li>Siswa: {{ $konseling->siswa->nama ?? '-' }}</li>
    <li>Guru Wali: {{ $konseling->guruWali->user->name ?? '-' }}</li>
    <li>Jenis: {{ $konseling->jenis->nama ?? '-' }}</li>
    <li>Poin/Catatan: {{ $konseling->poin ?? '-' }} — {{ $konseling->catatan ?? '-' }}</li>
  </ul>
  <a href="{{ route('admin.konseling.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
