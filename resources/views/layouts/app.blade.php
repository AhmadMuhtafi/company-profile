<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $s = $settings ?? [];
        $wa = $wa ?? '';
        $company = $s['company_name'] ?? 'Nama Perusahaan';
        $pageTitle = trim($__env->yieldContent('title'));
        $metaDesc = trim($__env->yieldContent('description')) ?: ($s['tagline'] ?? '');

        $navItems = [
            ['Beranda',       'home',            'home'],
            ['Tentang kami',  'about',           'about'],
            ['Layanan',       'services',        'services'],
            ['Portofolio',    'portfolio.index', 'portfolio.*'],
            ['Kontak',        'contact',         'contact'],
        ];
        $socials = [
            'instagram' => 'bi-instagram',
            'facebook'  => 'bi-facebook',
            'linkedin'  => 'bi-linkedin',
            'youtube'   => 'bi-youtube',
        ];
    @endphp

    <title>{{ $pageTitle ? $pageTitle . ' | ' . $company : $company }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle ?: $company }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    @if (!empty($s['hero_image']))
        <meta property="og:image" content="{{ asset('storage/' . $s['hero_image']) }}">
    @endif
    <meta name="theme-color" content="#1E4FD6">
    @if (!empty($s['favicon']))
        <link rel="icon" href="{{ asset('storage/' . $s['favicon']) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,500..800&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
    @stack('head')
</head>
<body>

<a class="visually-hidden-focusable position-absolute p-2 bg-white" href="#konten">Lewati ke konten</a>

{{-- ============ NAVIGASI ============ --}}
<nav class="navbar navbar-expand-lg site-nav" aria-label="Menu utama">
    <div class="container">
        <a class="navbar-brand me-4" href="{{ route('home') }}">
            @if (!empty($s['logo']))
                <img src="{{ asset('storage/' . $s['logo']) }}" alt="{{ $company }}" height="38">
            @else
                <span class="wordmark">{{ $company }}</span>
            @endif
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Buka menu">
            <i class="bi bi-list fs-2"></i>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                @foreach ($navItems as [$label, $routeName, $pattern])
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}"
                           href="{{ route($routeName) }}"
                           @if (request()->routeIs($pattern)) aria-current="page" @endif>{{ $label }}</a>
                    </li>
                @endforeach
                <li class="nav-item ms-lg-3 my-2 my-lg-0">
                    <a class="btn btn-blue btn-sm px-3 py-2" href="{{ route('contact') }}">Ajukan penawaran</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main id="konten">
    @yield('content')
</main>

{{-- ============ FOOTER ============ --}}
<footer class="site-footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="wordmark text-white mb-3">{{ $company }}</div>
                <p class="mb-3">{{ $s['tagline'] ?? '' }}</p>
                @php $hasSocial = collect($socials)->keys()->contains(fn ($k) => !empty($s[$k])); @endphp
                @if ($hasSocial)
                    <div class="d-flex gap-3 fs-5">
                        @foreach ($socials as $key => $icon)
                            @if (!empty($s[$key]))
                                <a href="{{ $s[$key] }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($key) }}"><i class="bi {{ $icon }}"></i></a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-6 col-lg-3 offset-lg-1">
                <h4>Halaman</h4>
                <ul>
                    @foreach ($navItems as [$label, $routeName])
                        <li><a href="{{ route($routeName) }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-6 col-lg-3">
                <h4>Kontak</h4>
                <ul>
                    @if (!empty($s['address']))<li>{{ $s['address'] }}</li>@endif
                    @if (!empty($s['phone']))<li><a href="tel:{{ preg_replace('/[^\d+]/', '', $s['phone']) }}">{{ $s['phone'] }}</a></li>@endif
                    @if (!empty($s['email']))<li><a href="mailto:{{ $s['email'] }}">{{ $s['email'] }}</a></li>@endif
                </ul>
            </div>
        </div>

        <div class="footer-bottom d-flex flex-wrap justify-content-between gap-2">
            <span>&copy; {{ date('Y') }} {{ $company }}. Hak cipta dilindungi.</span>
            @if (!empty($s['profile_pdf']))
                <a href="{{ asset('storage/' . $s['profile_pdf']) }}" download><i class="bi bi-download me-1"></i>Unduh company profile (PDF)</a>
            @endif
        </div>
    </div>
</footer>

@if ($wa)
    <a class="wa-float" href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" aria-label="Chat WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/site.js') }}"></script>
@stack('scripts')
</body>
</html>
