{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Konseling App')</title>

  {{-- Bootstrap 5 + Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  {{-- DataTables v2 (tanpa jQuery) - CSS --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.1.7/datatables.min.css"/>

  <style>
    :root{ --sidebar-w: 260px; }
    body { background:#f6f7fb; }
    .app { min-height:100vh; display:flex; }
    .sidebar {
      width:var(--sidebar-w); background:#0f172a; color:#cbd5e1;
    }
    .sidebar .brand {
      color:#fff; text-decoration:none; display:flex; align-items:center; gap:.6rem;
      padding:1rem 1.25rem; border-bottom:1px solid rgba(255,255,255,.06);
    }
    .sidebar .nav-link { color:#cbd5e1; border-radius:.5rem; }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active { color:#fff; background:rgba(255,255,255,.08); }

    .main { flex:1; display:flex; flex-direction:column; min-width:0; }
    .topbar {
      position:sticky; top:0; z-index:100;
      background:#fff; border-bottom:1px solid #e9ecef; padding:.75rem 1rem;
      display:flex; align-items:center; justify-content:space-between;
    }
    .content { padding:1.25rem; }

    /* Mobile */
    @media (max-width: 991.98px) {
      .sidebar { position:fixed; inset:0 auto 0 0; transform:translateX(-100%); transition:.25s; z-index:1050;}
      .sidebar.show { transform:translateX(0); }
      .backdrop { display:none; position:fixed; inset:0; background:rgba(0,0,0,.35); z-index:1040; }
      .backdrop.show { display:block; }
    }
  </style>

  @stack('styles')
</head>
<body>
<div class="app">
  {{-- ===== Sidebar ===== --}}
  <aside id="sidebar" class="sidebar">
    <a href="{{ route('dashboard') }}" class="brand">
      <i class="bi bi-chat-dots-fill fs-4"></i>
      <strong>Konseling App</strong>
    </a>

    <nav class="p-3">
      <div class="small text-uppercase text-secondary mb-2">Menu</div>

      {{-- Tautan Dashboard sesuai role --}}
      <a class="nav-link d-flex align-items-center gap-2 px-3 py-2 mb-1
         {{ request()->routeIs('admin.dashboard') || request()->routeIs('guru.dashboard') ? 'active' : '' }}"
         href="{{ auth()->check() && auth()->user()->role === 'guru_wali'
                ? route('guru.dashboard')
                : route('admin.dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>

      @auth
        @if(auth()->user()->role === 'admin')
          <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Data Siswa
          </a>
          <a href="{{ route('admin.jenis.index') }}" class="nav-link {{ request()->routeIs('admin.jenis.*') ? 'active' : '' }}">
            <i class="bi bi-sliders"></i> Jenis Bimbingan
          </a>
        @endif

        @if(auth()->user()->role === 'guru_wali')
          <a href="{{ route('guru.bimbingan.index') }}" class="nav-link {{ request()->routeIs('guru.bimbingan.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Bimbingan
          </a>
        @endif
      @endauth
    </nav>
  </aside>

  {{-- ===== Main ===== --}}
  <div class="main">
    <header class="topbar">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary d-lg-none" onclick="toggleSidebar()">
          <i class="bi bi-list"></i>
        </button>
        <h1 class="fs-5 m-0">@yield('page_title','Dashboard')</h1>
      </div>

      <div class="d-flex align-items-center gap-3">
        @auth
          <span class="text-muted small">
            {{ auth()->user()->name }} ({{ auth()->user()->role }})
          </span>
          <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Keluar dari aplikasi?')">
            @csrf
            <button class="btn btn-sm btn-outline-danger">
              <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
          </form>
        @endauth
      </div>
    </header>

    <main class="content">
      {{-- Flash message --}}
      @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('status') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @yield('content')
    </main>
  </div>
</div>

{{-- overlay mobile --}}
<div id="backdrop" class="backdrop" onclick="toggleSidebar()"></div>

{{-- ===== JS Order yang BENAR ===== --}}

{{-- 1) Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- 2) Chart.js (HARUS sebelum @stack('scripts')) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

{{-- 3) DataTables v2 (tanpa jQuery) - JS --}}
<script src="https://cdn.datatables.net/v/bs5/dt-2.1.7/datatables.min.js"></script>

<script>
  const sidebar  = document.getElementById('sidebar');
  const backdrop = document.getElementById('backdrop');
  function toggleSidebar(){
    sidebar.classList.toggle('show');
    backdrop.classList.toggle('show');
  }

  // Auto init DataTables untuk tabel yang diberi class "datatable"
  document.addEventListener('DOMContentLoaded', () => {
    const tables = document.querySelectorAll('table.datatable');
    if (tables.length && typeof DataTable !== 'undefined') {
      tables.forEach(t => new DataTable(t, { pageLength: 10 }));
    }
  });
</script>

{{-- Script halaman (grafik/JS per page) --}}
@stack('scripts')
</body>
</html>
