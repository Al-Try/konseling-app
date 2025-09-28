@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Dashboard Konseling</h1>

    {{-- Statistik --}}
    <div class="row text-white mb-4">
        <div class="col-md-3">
            <div class="card bg-primary p-3">
                <h4>Total Siswa</h4>
                <p>{{ $totalSiswa }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success p-3">
                <h4>Total Bimbingan</h4>
                <p>{{ $totalBimbingan }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info p-3">
                <h4>Total Guru Wali</h4>
                <p>{{ $totalGuru }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning p-3">
                <h4>Guru Aktif</h4>
                <p>{{ $guruAktif }}</p>
            </div>
        </div>
    </div>

    {{-- Grafik Bimbingan per Bulan --}}
    <div class="card mb-4">
        <div class="card-header">Grafik Bimbingan per Bulan</div>
        <div class="card-body">
            <canvas id="bimbinganChart"></canvas>
        </div>
    </div>

    {{-- Ranking Guru --}}
    <div class="card mb-4">
        <div class="card-header">Ranking Guru Wali</div>
        <ul class="list-group list-group-flush">
            @foreach($rankingGuru as $guru)
                <li class="list-group-item">
                    {{ $guru->nama_guru }} - {{ $guru->bimbingan_count }} bimbingan
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Ranking Siswa --}}
    <div class="card">
        <div class="card-header">Ranking Siswa</div>
        <ul class="list-group list-group-flush">
            @foreach($rankingSiswa as $siswa)
                <li class="list-group-item">
                    {{ $siswa->nama_siswa }} - {{ $siswa->bimbingan_count }} bimbingan
                </li>
            @endforeach
        </ul>
    </div>

</div>

{{-- Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('bimbinganChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($bimbinganPerBulan)) !!},
            datasets: [{
                label: 'Jumlah Bimbingan',
                data: {!! json_encode(array_values($bimbinganPerBulan)) !!},
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false
            }]
        }
    });
</script>
@endsection
