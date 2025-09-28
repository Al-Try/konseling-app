    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Guru Wali')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; min-height: 100vh; }
        .sidebar {
            width: 220px;
            background: #0d6efd;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }
        .sidebar a:hover { background: #0b5ed7; padding-left: 10px; transition: 0.3s; }
        .content { flex: 1; padding: 20px; }
    </style>
</head>
<body>
    {{-- Sidebar --}}
    <div class="sidebar">
        <h4>Guru Wali</h4>
        <a href="{{ url('/guru/dashboard') }}">Dashboard</a>
        <a href="{{ route('bimbingan.index') }}">Riwayat Bimbingan</a>
        <a href="{{ route('bimbingan.create') }}">Tambah Bimbingan</a>
        <a href="#">Daftar Siswa</a>
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
