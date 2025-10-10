<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Ranking Guru Wali</title>
  <style>
    body{ font-family: DejaVu Sans, sans-serif; font-size:12px }
    table{ width:100%; border-collapse: collapse; }
    th,td{ border:1px solid #333; padding:6px }
    th{ background:#efefef }
  </style>
</head>
<body>
  <h3>Ranking Guru Wali Paling Aktif</h3>
  <table>
    <thead>
      <tr><th>#</th><th>Guru Wali</th><th>Jumlah Bimbingan</th></tr>
    </thead>
    <tbody>
      @foreach($ranking as $i => $r)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $r->guruWali?->user?->name ?? '-' }}</td>
        <td>{{ $r->jumlah }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
