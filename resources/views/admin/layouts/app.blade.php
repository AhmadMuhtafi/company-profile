{{-- resources/views/admin/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Company Profile Admin</title>

    <script>
        document.documentElement.setAttribute('data-bs-theme', localStorage.getItem('theme') || 'light');
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root { --sidebar-w: 260px; }
        body { background: var(--bs-tertiary-bg); }

        /* ---------- Sidebar (default: mobile offcanvas) ---------- */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--bs-body-bg);
            border-right: 1px solid var(--bs-border-color);
        }

        /* ---------- Sidebar (desktop: fixed + flex column + scrollable nav) ---------- */
        @media (min-width: 992px) {
            .sidebar {
                position: fixed;
                inset: 0 auto 0 0;
                z-index: 1030;
                display: flex;
                flex-direction: column;
                height: 100vh;              /* pastikan setinggi viewport */
                overflow: hidden;           /* sidebar itu sendiri tidak scroll */
            }
            .sidebar .offcanvas-body {
                flex-grow: 1;               /* isi sisa tinggi sidebar */
                min-height: 0;              /* WAJIB: izinkan child menyusut & scroll */
                overflow: hidden;           /* cegah body ikut scroll */
            }
            .sidebar .offcanvas-body > nav {
                min-height: 0;              /* WAJIB: nav boleh menyusut */
            }
            .main { margin-left: var(--sidebar-w); }
        }

        /* ---------- Brand ---------- */
        .brand-mark {
            width: 36px; height: 36px; border-radius: 10px;
            display: grid; place-items: center;
            background: var(--bs-primary); color: #fff; font-size: 1.1rem;
        }

        /* ---------- Sidebar nav ---------- */
        .nav-section {
            font-size: .72rem; letter-spacing: .06em; text-transform: uppercase;
            color: var(--bs-secondary-color);
            padding: 1rem 1.25rem .35rem;
        }
        .side-link {
            display: flex; align-items: center; gap: .75rem;
            padding: .6rem 1rem; margin: .1rem .75rem;
            border-radius: .6rem;
            color: var(--bs-body-color);
            text-decoration: none;
            font-size: .95rem;
        }
        .side-link i { font-size: 1.05rem; color: var(--bs-secondary-color); }
        .side-link:hover { background: var(--bs-tertiary-bg); }
        .side-link.active {
            background: var(--bs-primary-bg-subtle);
            color: var(--bs-primary-text-emphasis);
            font-weight: 600;
        }
        .side-link.active i { color: var(--bs-primary); }

        /* ---------- Topbar ---------- */
        .topbar {
            background: var(--bs-body-bg);
            border-bottom: 1px solid var(--bs-border-color);
            position: sticky; top: 0; z-index: 1020;
        }

        /* ---------- Statistik card ---------- */
        .stat-card { transition: transform .15s ease, box-shadow .15s ease; }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1.25rem rgba(0,0,0,.08) !important;
        }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: grid; place-items: center; font-size: 1.4rem;
        }

        /* ---------- Quick action ---------- */
        .quick-action {
            display: flex; align-items: center; gap: .75rem;
            padding: .85rem 1rem; border-radius: .75rem;
            border: 1px dashed var(--bs-border-color);
            text-decoration: none; color: var(--bs-body-color);
            transition: border-color .15s, background .15s;
        }
        .quick-action:hover {
            border-color: var(--bs-primary);
            background: var(--bs-primary-bg-subtle);
            color: var(--bs-body-color);
        }
        .quick-action i { font-size: 1.25rem; color: var(--bs-primary); }

        /* ---------- Avatar & misc ---------- */
        .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            display: grid; place-items: center;
            background: var(--bs-primary-bg-subtle);
            color: var(--bs-primary-text-emphasis);
            font-weight: 600; font-size: .85rem;
        }
        .msg-item {
            padding: .85rem 1.25rem;
            border-bottom: 1px solid var(--bs-border-color);
        }
        .msg-item:last-child { border-bottom: 0; }
        .empty-state {
            padding: 2.5rem 1rem;
            text-align: center;
            color: var(--bs-secondary-color);
        }
        .empty-state i {
            font-size: 2rem; display: block;
            margin-bottom: .5rem; opacity: .6;
        }

        /* ---------- Scrollbar halus (opsional, biar lebih rapi) ---------- */
        .sidebar nav::-webkit-scrollbar { width: 6px; }
        .sidebar nav::-webkit-scrollbar-thumb {
            background: var(--bs-border-color);
            border-radius: 999px;
        }
        .sidebar nav::-webkit-scrollbar-thumb:hover {
            background: var(--bs-secondary-color);
        }
        .sidebar nav { scrollbar-width: thin; }
    </style>
</head>
<body>

@php
    // ---- Shared data (bisa dipakai di semua halaman yang meng-extend layout ini) ----
    $adminUser = auth('admin')->user();
    $adminName = $adminUser->name
        ?? $adminUser->email
        ?? 'Admin';
    $unread    = $stats['unread_messages'] ?? 0;

    // Helper link aman: kalau route tidak ada, fallback ke "#"
    $link = fn (string $name) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';

    $menuGroups = [
        'Utama' => [
            ['Dashboard', 'bi-grid-1x2-fill', 'admin.dashboard', 'admin.dashboard'],
        ],
        'Konten' => [
            ['Proyek',   'bi-building',         'admin.projects.index',   'admin.projects.*'],
            ['Kategori', 'bi-tags',             'admin.categories.index', 'admin.categories.*'],
            ['Klien',    'bi-people',           'admin.clients.index',    'admin.clients.*'],
            ['Layanan',  'bi-tools',            'admin.services.index',   'admin.services.*'],
            ['Dokumen',  'bi-file-earmark-pdf', 'admin.documents.index',  'admin.documents.*'],
        ],
        'Komunikasi' => [
            ['Pesan masuk', 'bi-envelope', 'admin.messages.index', 'admin.messages.*'],
        ],
        'Sistem' => [
            ['Pengaturan situs', 'bi-gear', 'admin.settings.index', 'admin.settings.*'],
        ],
    ];
@endphp

{{-- ============ SIDEBAR ============ --}}
<aside class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar" aria-label="Menu utama">
    <div class="offcanvas-header border-bottom d-lg-none">
        <span class="fw-semibold">Menu</span>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebar" aria-label="Tutup"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-0">
        {{-- Brand (di desktop) --}}
        <div class="d-none d-lg-flex align-items-center gap-2 px-3 py-3 border-bottom flex-shrink-0">
            <div class="brand-mark"><i class="bi bi-buildings"></i></div>
            <div class="lh-sm">
                <div class="fw-semibold">Company Profile</div>
                <small class="text-secondary">Panel admin</small>
            </div>
        </div>

        {{-- Menu (area yang bisa di-scroll) --}}
        <nav class="flex-grow-1 overflow-auto pb-3">
            @foreach ($menuGroups as $group => $items)
                <div class="nav-section">{{ $group }}</div>
                @foreach ($items as [$label, $icon, $routeName, $pattern])
                    <a href="{{ $link($routeName) }}" class="side-link {{ request()->routeIs($pattern) ? 'active' : '' }}">
                        <i class="bi {{ $icon }}"></i>
                        <span>{{ $label }}</span>
                        @if ($label === 'Pesan masuk' && $unread > 0)
                            <span class="badge rounded-pill text-bg-danger ms-auto">{{ $unread }}</span>
                        @endif
                    </a>
                @endforeach
            @endforeach
        </nav>

        {{-- Footer sidebar --}}
        <div class="p-3 border-top flex-shrink-0">
            <a href="{{ url('/') }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm w-100">
                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat website
            </a>
        </div>
    </div>
</aside>

{{-- ============ MAIN ============ --}}
<div class="main">

    <header class="topbar px-3 px-lg-4 py-2 d-flex align-items-center gap-3">
        <button class="btn btn-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-label="Buka menu">
            <i class="bi bi-list fs-5"></i>
        </button>

        <div class="lh-sm">
            <div class="fw-semibold">@yield('page-title', 'Dashboard')</div>
            <small class="text-secondary d-none d-sm-block">{{ now()->translatedFormat('l, d F Y') }}</small>
        </div>

        <div class="ms-auto d-flex align-items-center gap-2">
            <button class="btn btn-light" id="themeToggle" type="button" aria-label="Ganti tema">
                <i class="bi bi-moon-stars" id="themeIcon"></i>
            </button>

            <div class="dropdown">
                <button class="btn btn-light d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="avatar">{{ strtoupper(mb_substr($adminName, 0, 1)) }}</span>
                    <span class="d-none d-md-inline">{{ $adminName }}</span>
                    <i class="bi bi-chevron-down small"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li><a class="dropdown-item" href="{{ $link('admin.settings.index') }}"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="p-3 p-lg-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @yield('content')

        <footer class="text-center text-secondary small mt-5">
            &copy; {{ date('Y') }} Company Profile Admin
        </footer>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        var root = document.documentElement;
        var icon = document.getElementById('themeIcon');
        function sync() {
            icon.className = 'bi ' + (root.getAttribute('data-bs-theme') === 'dark' ? 'bi-sun' : 'bi-moon-stars');
        }
        document.getElementById('themeToggle').addEventListener('click', function () {
            var next = root.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
            sync();
        });
        sync();
    })();
</script>
</body>
</html>