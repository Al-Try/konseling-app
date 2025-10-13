@extends('layouts.app')
@section('page_title','Dashboard')
@push('styles')
<style>
  .card-body canvas { min-height: 220px; }
</style>
@endpush
@section('content')
<div class="d-flex justify-content-end gap-2 mb-3">
  @if (Route::has('admin.laporan.rankingGuru'))
    <a class="btn btn-outline-secondary" href="{{ route('admin.laporan.rankingGuru') }}">
      <i class="bi bi-filetype-pdf"></i> Unduh Ranking Guru (PDF)
    </a>
  @endif

  @php $s = $siswaTerbaru->first(); @endphp
  @if ($s && Route::has('admin.laporan.rekapSiswa'))
    <a class="btn btn-outline-secondary"
       href="{{ route('admin.laporan.rekapSiswa', $s->id) }}">
      <i class="bi bi-filetype-pdf"></i> Rekap Siswa (PDF)
    </a>
  @endif
</div>



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
    // ====== Data dari Controller (pastikan array plain) ======
    const bulananLabels = @json($bulananLabels);
    const bulananValues = @json($bulananValues);

    const kategoriLabels = @json(collect($kategoriDistribusi)->pluck('label')->values());
    const kategoriValues = @json(collect($kategoriDistribusi)->pluck('jml')->values());

    const topGuruLabels = @json(collect($topGuru)->pluck('label')->values());
    const topGuruValues = @json(collect($topGuru)->pluck('jml')->values());

    const topSiswaLabels = @json(collect($topSiswa)->pluck('label')->values());
    const topSiswaValues = @json(collect($topSiswa)->pluck('jml')->values());

    // Debug cepat (lihat di Console jika kosong)
    console.log({bulananLabels, bulananValues, kategoriLabels, kategoriValues, topGuruLabels, topGuruValues, topSiswaLabels, topSiswaValues});

    // ====== Opsi Chart agar jelas terlihat ======
    const commonOpts = {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 } },
        x: { ticks: { autoSkip: true, maxRotation: 0, minRotation: 0 } }
      }
    };

    // Helper: jika semua nol atau tidak ada data
    function isAllZero(arr) { return !arr || !arr.length || arr.every(v => parseInt(v) === 0); }
    function showNoData(canvasId, msg='Tidak ada data') {
      const el = document.getElementById(canvasId);
      if (!el) return;
      const ctx = el.getContext('2d');
      ctx.clearRect(0,0,el.width, el.height);
      ctx.font = '14px system-ui, -apple-system, Segoe UI, Roboto';
      ctx.fillStyle = '#6c757d';
      ctx.textAlign = 'center';
      ctx.fillText(msg, el.width/2, (el.height/2));
    }

    // Line: Bulanan
    if (isAllZero(bulananValues)) {
      showNoData('chartBulanan');
    } else {
      new Chart(document.getElementById('chartBulanan'), {
        type: 'line',
        data: { labels: bulananLabels, datasets: [{ label: 'Konseling', data: bulananValues, tension: .35, borderWidth: 2, fill: false }] },
        options: commonOpts
      });
    }

    // Doughnut: Kategori
    if (isAllZero(kategoriValues)) {
      showNoData('chartKategori');
    } else {
      new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: { labels: kategoriLabels, datasets: [{ data: kategoriValues }] },
        options: { responsive:true, maintainAspectRatio:false, plugins: { legend: { position: 'bottom' } } }
      });
    }

    // Bar: Top Guru
    if (isAllZero(topGuruValues)) {
      showNoData('chartTopGuru');
    } else {
      new Chart(document.getElementById('chartTopGuru'), {
        type: 'bar',
        data: { labels: topGuruLabels, datasets: [{ label:'Konseling', data: topGuruValues }] },
        options: commonOpts
      });
    }

    // Bar: Top Siswa
    if (isAllZero(topSiswaValues)) {
      showNoData('chartTopSiswa');
    } else {
      new Chart(document.getElementById('chartTopSiswa'), {
        type: 'bar',
        data: { labels: topSiswaLabels, datasets: [{ label:'Konseling', data: topSiswaValues }] },
        options: commonOpts
      });
    }
  </script>
@endpush
