@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">

  {{-- Kartu aksi seperti mockup-mu --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 mb-8">
    <a class="block p-4 rounded-2xl shadow bg-white hover:shadow-lg" href="{{ route('admin.siswa.create') }}">
      <div class="text-2xl">👤</div><div class="font-semibold mt-2">Input Data Siswa</div>
      <div class="text-sm text-gray-500">Tambah data siswa baru</div>
    </a>
    <a class="block p-4 rounded-2xl shadow bg-white hover:shadow-lg" href="{{ route('admin.siswa.index') }}">
      <div class="text-2xl">👥</div><div class="font-semibold mt-2">Daftar Siswa Bimbingan</div>
      <div class="text-sm text-gray-500">Lihat daftar siswa</div>
    </a>
    <a class="block p-4 rounded-2xl shadow bg-white hover:shadow-lg" href="{{ route('admin.konseling.index') }}">
      <div class="text-2xl">➕</div><div class="font-semibold mt-2">Mulai Bimbingan</div>
      <div class="text-sm text-gray-500">Buat catatan bimbingan</div>
    </a>
    <a class="block p-4 rounded-2xl shadow bg-white hover:shadow-lg" href="{{ route('admin.konseling.index') }}">
      <div class="text-2xl">🗂️</div><div class="font-semibold mt-2">Data Bimbingan</div>
      <div class="text-sm text-gray-500">Riwayat bimbingan</div>
    </a>
    <a class="block p-4 rounded-2xl shadow bg-white hover:shadow-lg" href="#analitik">
      <div class="text-2xl">📊</div><div class="font-semibold mt-2">Analisis Data</div>
      <div class="text-sm text-gray-500">Grafik perkembangan</div>
    </a>
    <a class="block p-4 rounded-2xl shadow bg-white hover:shadow-lg" href="#ranking">
      <div class="text-2xl">🏅</div><div class="font-semibold mt-2">Ranking Guru</div>
      <div class="text-sm text-gray-500">Guru paling aktif</div>
    </a>
  </div>

  {{-- KPI --}}
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="p-5 rounded-2xl bg-white shadow"><div class="text-sm text-gray-500">Total Siswa</div><div class="text-3xl font-bold">{{ $stats['totalSiswa'] }}</div></div>
    <div class="p-5 rounded-2xl bg-white shadow"><div class="text-sm text-gray-500">Total Guru Wali</div><div class="text-3xl font-bold">{{ $stats['totalGuruWali'] }}</div></div>
    <div class="p-5 rounded-2xl bg-white shadow"><div class="text-sm text-gray-500">Total Kelas</div><div class="text-3xl font-bold">{{ $stats['totalKelas'] }}</div></div>
    <div class="p-5 rounded-2xl bg-white shadow"><div class="text-sm text-gray-500">Total Konseling</div><div class="text-3xl font-bold">{{ $stats['totalKonseling'] }}</div></div>
  </div>

  {{-- Grafik --}}
  <div id="analitik" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="p-5 bg-white rounded-2xl shadow">
      <div class="font-semibold mb-3">Tren Konseling / Bulan</div>
      <canvas id="chartBulanan"></canvas>
    </div>
    <div class="p-5 bg-white rounded-2xl shadow">
      <div class="font-semibold mb-3">Distribusi Kategori</div>
      <canvas id="chartKategori"></canvas>
    </div>
  </div>

  {{-- Ranking --}}
  <div id="ranking" class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <div class="p-5 bg-white rounded-2xl shadow">
      <div class="font-semibold mb-3">Guru Wali Paling Aktif</div>
      <ol class="list-decimal ml-6">
        @forelse($topGuru as $r)
          <li class="mb-1">{{ $r->guruWali?->user?->name ?? '-' }} — <strong>{{ $r->jml }}</strong> konseling</li>
        @empty <li>Belum ada data</li> @endforelse
      </ol>
    </div>
    <div class="p-5 bg-white rounded-2xl shadow">
      <div class="font-semibold mb-3">Siswa Paling Sering Dikonseling</div>
      <ol class="list-decimal ml-6">
        @forelse($topSiswa as $r)
          <li class="mb-1">{{ $r->siswa?->nama_siswa ?? '-' }} — <strong>{{ $r->jml }}</strong> kali</li>
        @empty <li>Belum ada data</li> @endforelse
      </ol>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Bulanan
  new Chart(document.getElementById('chartBulanan'), {
    type: 'line',
    data: {
      labels: @json($bulanan->pluck('ym')),
      datasets: [{label: 'Konseling', data: @json($bulanan->pluck('jml'))}]
    }
  });

  // Pie kategori
  new Chart(document.getElementById('chartKategori'), {
    type: 'doughnut',
    data: {
      labels: @json(collect($kategoriDistribusi)->pluck('label')),
      datasets: [{ data: @json(collect($kategoriDistribusi)->pluck('jml')) }]
    }
  });
</script>
@endpush
