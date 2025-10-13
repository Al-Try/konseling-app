<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Ranking Guru</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    table { width:100%; border-collapse: collapse; }
    th, td { border:1px solid #333; padding:6px; }
  </style>
</head>
<body>
  <h3>Ranking Guru Berdasar Jumlah Bimbingan</h3>
  <table>
    <thead><tr><th>#</th><th>Guru</th><th>Jumlah</th></tr></thead>
    <tbody>
    @foreach($data as $i => $row)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $row->guruWali?->user?->name ?? '-' }}</td>
        <td>{{ $row->jml }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
</body>
</html>
