<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Rekap Bimbingan Siswa</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    h3,h4 { margin: 0 0 8px 0; }
    .muted { color:#666; }
    table { width:100%; border-collapse: collapse; margin-top:10px; }
    th, td { border:1px solid #333; padding:6px; }
    th { background:#f0f0f0; }
  </style>
</head>
<body>
  <h3>Rekap Bimbingan Siswa</h3>
  <table style="border:none">
    <tr style="border:none">
      <td style="border:none"><strong>Nama</strong></td>
      <td style="border:none">: {{ $siswa->nama_siswa }}</td>
    </tr>
    <tr style="border:none">
      <td style="border:none"><strong>Kelas</strong></td>
      <td style="border:none">: {{ $siswa->kelas?->nama_kelas ?? '-' }}</td>
    </tr>
  </table>

  <table>
    <thead>
      <tr>
        <th style="width:90px">Tanggal</th>
        <th>Guru Wali</th>
        <th>Jenis</th>
        <th style="width:55px">Poin</th>
        <th>Catatan</th>
      </tr>
    </thead>
    <tbody>
      @forelse($list as $b)
        <tr>
          <td>{{ \Illuminate\Support\Carbon::parse($b->tanggal)->format('d/m/Y') }}</td>
          <td>{{ $b->guruWali?->user?->name ?? '-' }}</td>
          <td>{{ $b->jenis?->nama_jenis ?? '-' }}</td>
          <td style="text-align:center">{{ $b->jenis?->poin }}</td>
          <td>{{ $b->catatan }}</td>
        </tr>
      @empty
        <tr><td colspan="5" style="text-align:center">Belum ada data</td></tr>
      @endforelse
    </tbody>
  </table>

  <p class="muted">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>
