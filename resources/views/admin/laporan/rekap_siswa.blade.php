<!DOCTYPE html><html><head><meta charset="utf-8">
<style>body{font-family: DejaVu Sans, sans-serif; font-size:12px} table{width:100%;border-collapse:collapse} th,td{border:1px solid #ddd;padding:6px}</style>
</head><body>
<h3>Laporan Konseling Siswa</h3>
<p><strong>Nama:</strong> {{ $siswa->nama_siswa }} <br>
<strong>Kelas:</strong> {{ $siswa->kelas?->nama_kelas }}</p>

<table>
  <thead><tr><th>Tanggal</th><th>Jenis</th><th>Poin</th><th>Guru Wali</th><th>Catatan</th></tr></thead>
  <tbody>
  @forelse($riwayat as $r)
    <tr>
      <td>{{ $r->tanggal->format('d-m-Y') }}</td>
      <td>{{ $r->jenis?->nama_jenis }}</td>
      <td>{{ $r->jenis?->poin }}</td>
      <td>{{ $r->guruWali?->user?->nama_guru }}</td>
      <td>{{ $r->catatan }}</td>
    </tr>
  @empty
    <tr><td colspan="5">Belum ada data</td></tr>
  @endforelse
  </tbody>
</table>
</body></html>
