<!DOCTYPE html><html><head><meta charset="utf-8">
<style>body{font-family: DejaVu Sans, sans-serif; font-size:12px} table{width:100%;border-collapse:collapse} th,td{border:1px solid #ddd;padding:6px}</style>
</head><body>
<h3>Ranking Guru Wali Paling Aktif</h3>
<table>
  <thead><tr><th>#</th><th>Guru Wali</th><th>Jumlah Konseling</th></tr></thead>
  <tbody>
  @foreach($rows as $i=>$r)
    <tr>
      <td>{{ $i+1 }}</td>
      <td>{{ $r->guruWali?->user?->nama_guru }}</td>
      <td>{{ $r->jml }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
</body></html>
