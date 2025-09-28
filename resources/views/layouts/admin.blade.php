<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; min-height: 100vh; }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }
        .sidebar a:hover { background: #495057; padding-left: 10px; transition: 0.3s; }
        .content { flex: 1; padding: 20px; }
    </style>
</head>
<body>
    {{-- Sidebar --}}
    <div class="sidebar">
        <h3>Konseling App</h3>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('siswa.index') }}">Data Siswa</a>
        <a href="#">Data Guru Wali</a>
        <a href="#">Jenis Bimbingan</a>
        <a href="#">Laporan</a>
        <hr>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form>
    </div>

    {{-- Konten --}}
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
