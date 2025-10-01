@extends('layouts.app')
@section('page_title','Dashboard')

@section('content')
<div class="container-fluid">

  {{-- KPI --}}
  <div class="row g-3 mb-4">
    @php
      $kpi = [
        ['title'=>'Total Siswa','value'=>$stats['totalSiswa'],'icon'=>'bi-people','color'=>'primary'],
        ['title'=>'Total Guru Wali','value'=>$stats['totalGuruWali'],'icon'=>'bi-person-badge','color'=>'success'],
        ['title'=>'Total Kelas','value'=>$stats['totalKelas'],'icon'=>'bi-building','color'=>'info'],
        ['title'=>'Total Konseling','value'=>$stats['totalKonseling'],'icon'=>'bi-journal-text','color'=>'warning'],
      ];
    @endphp
    @foreach($kpi as $card)
      <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="rounded-circle bg-{{ $card['color'] }} bg-opacity-10 p-3">
              <i class="bi {{ $card['icon'] }} text-{{ $card['color'] }} fs-4"></i>
            </div>
            <div>
              <div class="text-secondary small">{{ $card['title'] }}</div>
              <div class="fs-2 fw-bold">{{ $card['value'] }}</div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- Charts Row 1 --}}
  <div class="row g-3 mb-4">
    <div class="col-lg-7">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white fw-semibold">Tren Konseling / Bulan</div>
        <div class="card-body"><canvas id="chartBulanan" height="110"></canvas></div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white fw-semibold">Distribusi Kategori</div>
        <div class="card-body"><canvas id="chartKategori" height="110"></canvas></div>
      </div>
    </div>
  </div>

  {{-- Charts Row 2: Top5 --}}
  <div class="row g-3 mb-4">
    <div class="col-lg-6">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white fw-semibold">Top 5 Guru Wali Paling Aktif</div>
        <div class="card-body"><canvas id="chartTopGuru" height="110"></canvas></div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white fw-semibold">Top 5 Siswa Paling Sering Dikonseling</div>
        <div class="card-body"><canvas id="chartTopSiswa" height="110"></canvas></div>
      </div>
    </div>
  </div>

  {{-- Tabel kecil (opsional) --}}
  <div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-semibold">Siswa Terbaru</div>
    <div class="card-body p-0">
      <table class="table mb-0 align-middle">
        <thead class="table-light">
          <tr>
            <th>Nama</th>
            <th>Kelas</th>
          </tr>
        </thead>
        <tbody>
          @forelse($siswaTerbaru as $s)
            <tr>
              <td>{{ $s->nama_siswa }}</td>
              <td>{{ $s->kelas?->nama_kelas ?? '-' }}</td>
            </tr>
          @empty
            <tr><td colspan="2" class="text-center text-muted py-4">Belum ada data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  // ====== Data dari Controller ======
  const bulananLabels = @json($bulananLabels);
  const bulananValues = @json($bulananValues);

  const kategoriLabels = @json(collect($kategoriDistribusi)->pluck('label'));
  const kategoriValues = @json(collect($kategoriDistribusi)->pluck('jml'));

  const topGuruLabels = @json(collect($topGuru)->pluck('label'));
  const topGuruValues = @json(collect($topGuru)->pluck('jml'));

  const topSiswaLabels = @json(collect($topSiswa)->pluck('label'));
  const topSiswaValues = @json(collect($topSiswa)->pluck('jml'));

  // ====== Chart Default Options (ringan) ======
  const commonOpts = { plugins: { legend: { display:false } }, maintainAspectRatio:false };

  // Line: Bulanan
  new Chart(document.getElementById('chartBulanan'), {
    type: 'line',
    data: {
      labels: bulananLabels,
      datasets: [{
        label: 'Konseling',
        data: bulananValues,
        tension: .35,
        borderWidth: 2,
        fill: false
      }]
    },
    options: commonOpts
  });

  // Doughnut: Kategori
  new Chart(document.getElementById('chartKategori'), {
    type: 'doughnut',
    data: { labels: kategoriLabels, datasets: [{ data: kategoriValues }] },
    options: { ...commonOpts, plugins: { legend: { position: 'bottom' } } }
  });

  // Bar: Top Guru
  new Chart(document.getElementById('chartTopGuru'), {
    type: 'bar',
    data: { labels: topGuruLabels, datasets: [{ label:'Konseling', data: topGuruValues }] },
    options: commonOpts
  });

  // Bar: Top Siswa
  new Chart(document.getElementById('chartTopSiswa'), {
    type: 'bar',
    data: { labels: topSiswaLabels, datasets: [{ label:'Konseling', data: topSiswaValues }] },
    options: commonOpts
  });
</script>
@endpush
