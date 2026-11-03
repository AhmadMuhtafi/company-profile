@extends('layouts.app')

@section('description', $settings['tagline'] ?? '')

@section('content')
@php
    $s = $settings ?? [];
    $profilePdf = !empty($s['profile_pdf']) ? asset('storage/' . $s['profile_pdf']) : null;

    // Kotak ringkasan: tampil hanya untuk angka yang sudah diisi di tabel settings.
    $facts = collect([
        ['Tahun pengalaman', 'stat_years'],
        ['Proyek selesai',   'stat_projects'],
        ['Klien dan mitra',  'stat_clients'],
        ['Tenaga kerja',     'stat_employees'],
    ])->filter(fn ($f) => !empty($s[$f[1]]))->values();

    // Teks cadangan jika tabel services masih kosong. Ganti sesuai bidang usaha Anda.
    $serviceList = ($services ?? collect())->isNotEmpty() ? $services : collect([
        ['title' => 'Layanan utama pertama',  'description' => 'Jelaskan layanan ini dalam satu atau dua kalimat yang konkret.', 'icon' => 'bi-building'],
        ['title' => 'Layanan utama kedua',    'description' => 'Sebutkan ruang lingkup dan hasil yang diterima klien.',          'icon' => 'bi-tools'],
        ['title' => 'Layanan utama ketiga',   'description' => 'Tambahkan detail yang dibutuhkan tim pengadaan pengembang.',    'icon' => 'bi-clipboard-check'],
    ]);

    // Poin keunggulan. Ubah teks ini agar sesuai kenyataan perusahaan Anda.
    $reasons = [
        ['bi-calendar-check', 'Pekerjaan sesuai jadwal', 'Jadwal dan target mingguan disepakati sejak awal dan dilaporkan secara rutin.'],
        ['bi-award',          'Tenaga ahli bersertifikat', 'Pekerjaan dipimpin tenaga ahli dengan sertifikat keahlian yang berlaku.'],
        ['bi-clipboard-data', 'Laporan progres yang jelas', 'Foto, volume pekerjaan, dan kendala dicatat sehingga mudah diperiksa pengawas.'],
        ['bi-shield-check',   'Garansi dan layanan purna serah', 'Masa pemeliharaan tertulis dan tim yang tetap bisa dihubungi setelah serah terima.'],
    ];
@endphp

{{-- ============ HERO ============ --}}
<section class="hero grid-sheet">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="{{ !empty($s['hero_image']) ? 'col-lg-7' : 'col-lg-9' }}">
                <h1>{{ $s['tagline'] ?? 'Mitra pelaksana yang tepat waktu dan terukur untuk proyek Anda' }}</h1>
                <p class="lead">{{ $s['about_short'] ?? 'Tulis satu paragraf singkat tentang perusahaan Anda: bidang usaha, pengalaman, dan jenis proyek yang biasa dikerjakan.' }}</p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('portfolio.index') }}" class="btn btn-blue">Lihat portofolio</a>
                    @if ($profilePdf)
                        <a href="{{ $profilePdf }}" class="btn btn-line" download>Unduh company profile</a>
                    @else
                        <a href="{{ route('contact') }}" class="btn btn-line">Ajukan penawaran</a>
                    @endif
                </div>
            </div>

            @if (!empty($s['hero_image']))
                <div class="col-lg-5">
                    <img class="hero-photo" src="{{ asset('storage/' . $s['hero_image']) }}" alt="Proyek {{ $s['company_name'] ?? '' }}">
                </div>
            @endif
        </div>

        @if ($facts->isNotEmpty())
            <div class="titleblock" style="--cols: {{ $facts->count() }}">
                <div class="tb-head">
                    <span>Ringkasan perusahaan</span>
                    @if (!empty($s['founded_year']))<span>Berdiri {{ $s['founded_year'] }}</span>@endif
                </div>
                <div class="tb-grid">
                    @foreach ($facts as [$label, $key])
                        <div class="tb-cell">
                            <div class="tb-val" data-count="{{ (int) preg_replace('/\D/', '', $s[$key]) }}" data-suffix="+">
                                {{ $s[$key] }}
                            </div>
                            <div class="tb-label">{{ $label }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

{{-- ============ LAYANAN ============ --}}
<section class="sheet {{ $facts->isNotEmpty() ? 'after-titleblock' : '' }}">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="sticky-head">
                    <h2>Layanan kami</h2>
                    <p class="text-muted-2 mt-3">Ruang lingkup pekerjaan yang kami tangani untuk pengembang dan pemilik proyek.</p>
                    <a href="{{ route('services') }}" class="btn btn-line mt-2">Semua layanan</a>
                </div>
            </div>
            <div class="col-lg-8">
                <ul class="ruled">
                    @foreach ($serviceList->take(6) as $sv)
                        <li>
                            <i class="bi {{ data_get($sv, 'icon') ?: 'bi-gear' }}" aria-hidden="true"></i>
                            <div>
                                <h3>{{ data_get($sv, 'title') }}</h3>
                                <p>{{ data_get($sv, 'description') }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ============ PROYEK TERPILIH ============ --}}
@if (($featuredProjects ?? collect())->isNotEmpty())
    <section class="sheet sheet-alt">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                <h2 class="mb-0">Proyek terpilih</h2>
                <a href="{{ route('portfolio.index') }}" class="btn btn-line">Semua proyek</a>
            </div>
            <div class="row g-4">
                @foreach ($featuredProjects as $project)
                    <div class="col-md-6 col-lg-4">
                        @include('partials.project-card', ['project' => $project])
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- ============ KEUNGGULAN ============ --}}
<section class="sheet">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="sticky-head">
                    <h2>Yang bisa Anda harapkan dari kami</h2>
                    <p class="text-muted-2 mt-3">Empat hal yang biasanya paling dinilai tim pengadaan sebelum memilih mitra.</p>
                </div>
            </div>
            <div class="col-lg-8">
                <ul class="ruled">
                    @foreach ($reasons as [$icon, $title, $text])
                        <li>
                            <i class="bi {{ $icon }}" aria-hidden="true"></i>
                            <div><h3>{{ $title }}</h3><p>{{ $text }}</p></div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ============ KLIEN ============ --}}
@if (($clients ?? collect())->isNotEmpty())
    <section class="sheet sheet-alt">
        <div class="container">
            <h2 class="mb-4">Dipercaya oleh</h2>
            <div class="logos">
                @foreach ($clients as $client)
                    <div>
                        <img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client->name }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- ============ AJAKAN ============ --}}
<section class="cta">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h2>Punya proyek yang perlu dikerjakan?</h2>
                <p class="mt-3 mb-0">Kirim kebutuhan Anda. Kami balas dalam satu hari kerja dengan pertanyaan lanjutan atau jadwal diskusi.</p>
            </div>
            <div class="col-lg-4 d-flex flex-wrap gap-3 justify-content-lg-end">
                <a href="{{ route('contact') }}" class="btn btn-blue">Ajukan penawaran</a>
                @if ($profilePdf)
                    <a href="{{ $profilePdf }}" class="btn btn-line-light" download>Unduh profil</a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
