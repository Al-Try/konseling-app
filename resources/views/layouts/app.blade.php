<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konseling App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>
<body>

    {{-- Top Navbar --}}
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/dashboard') }}">Konseling App</a>
            <span class="navbar-text text-white">
                @auth
                    {{ Auth::user()->name }} ({{ Auth::user()->role }})
                @endauth
            </span>
        </div>
    </nav>

    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="sidebar">
            <a href="{{ url('/dashboard') }}">📊 Dashboard</a>
            <a href="{{ url('/siswa') }}">👨‍🎓 Data Siswa</a>
            <a href="{{ url('/guru-wali') }}">👨‍🏫 Data Guru Wali</a>
            <a href="{{ url('/bimbingan') }}">📖 Data Bimbingan</a>
            <a href="{{ url('/jenis-bimbingan') }}">📝 Jenis Bimbingan</a>
        </div>

        {{-- Content --}}
        <div class="content w-100">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
