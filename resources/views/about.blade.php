@extends('layouts.app')

@section('title', 'Tentang kami')
@section('description', $settings['about_short'] ?? '')

@section('content')
@php
    $s = $settings ?? [];
    $legal = collect([
        ['Akta pendirian',       'akta_no'],
        ['NIB',                  'nib'],
        ['NPWP',                 'npwp'],
        ['SBU / sertifikasi',    'sbu'],
        ['Kualifikasi usaha',    'qualification'],
    ])->filter(fn ($x) => !empty($s[$x[1]]));

    $missionLines = !empty($s['mission'])
        ? array_values(array_filter(preg_split('/\r\n|\r|\n/', $s['mission'])))
        : [];
@endphp

<header class="page-head grid-sheet">
    <div class="container">
        <div class="crumb"><a href="{{ route('home') }}">Beranda</a><span>/</span>Tentang kami</div>
        <h1>Tentang kami</h1>
    </div>
</header>

{{-- ============ PROFIL ============ --}}
<section class="sheet">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="sticky-head">
                    <h2>Profil perusahaan</h2>
                    @if (!empty($s['founded_year']))
                        <p class="text-muted-2 mt-3">Berdiri sejak {{ $s['founded_year'] }}.</p>
                    @endif
                </div>
            </div>
            <div class="col-lg-8">
                @if (!empty($s['about_image']))
                    <img class="hero-photo mb-4" src="{{ asset('storage/' . $s['about_image']) }}" alt="Tentang {{ $s['company_name'] ?? '' }}">
                @endif
                @php $about = $s['about_long'] ?? ($s['about_short'] ?? 'Isi profil perusahaan Anda di sini: sejarah singkat, bidang usaha, dan nilai yang dipegang.'); @endphp
                {!! nl2br(e($about)) !!}
            </div>
        </div>
    </div>
</section>

{{-- ============ VISI DAN MISI ============ --}}
<section class="sheet sheet-alt">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4"><h2>Visi dan misi</h2></div>
            <div class="col-lg-8">
                <div class="row g-5">
                    <div class="col-md-6">
                        <h3 class="mb-3">Visi</h3>
                        <p>{{ $s['vision'] ?? 'Tuliskan visi perusahaan dalam satu kalimat.' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h3 class="mb-3">Misi</h3>
                        @if ($missionLines)
                            <ul class="ps-3 mb-0">
                                @foreach ($missionLines as $line)<li class="mb-2">{{ $line }}</li>@endforeach
                            </ul>
                        @else
                            <p>Tuliskan misi perusahaan, satu poin per baris.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ LEGALITAS ============ --}}
<section class="sheet">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="sticky-head">
                    <h2>Legalitas</h2>
                    <p class="text-muted-2 mt-3">Dokumen lengkap tersedia untuk diunduh dan siap dilampirkan pada dokumen penawaran.</p>
                </div>
            </div>
            <div class="col-lg-8">
                @if ($legal->isNotEmpty())
                    <dl class="spec mb-5">
                        @foreach ($legal as [$label, $key])
                            <div><dt>{{ $label }}</dt><dd>{{ $s[$key] }}</dd></div>
                        @endforeach
                    </dl>
                @endif

                @if (($documents ?? collect())->isNotEmpty())
                    <h3 class="mb-2">Dokumen untuk diunduh</h3>
                    <div style="border-top:1.5px solid var(--ink)">
                        @foreach ($documents as $doc)
                            <a class="docrow" href="{{ asset('storage/' . $doc->file_path) }}" download>
                                <span>{{ $doc->title }}</span>
                                <i class="bi bi-download" aria-hidden="true"></i>
                            </a>
                        @endforeach
                    </div>
                @elseif ($legal->isEmpty())
                    <div class="empty-note">Data legalitas dan dokumen akan tampil di sini setelah diisi lewat panel admin.</div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ============ TIM INTI (statis, ubah langsung di file ini) ============ --}}
<section class="sheet sheet-alt">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4"><h2>Tim inti</h2></div>
            <div class="col-lg-8">
                <div style="border-top:1.5px solid var(--ink)">
                    @foreach ([
                        ['Nama lengkap', 'Direktur utama'],
                        ['Nama lengkap', 'Manajer proyek'],
                        ['Nama lengkap', 'Ahli teknik / kepala pelaksana'],
                    ] as [$name, $role])
                        <div class="person">
                            <div class="ph">{{ mb_substr($name, 0, 1) }}</div>
                            <div><strong>{{ $name }}</strong><small>{{ $role }}</small></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
        <h2 class="mb-0">Ingin melihat hasil kerja kami?</h2>
        <a href="{{ route('portfolio.index') }}" class="btn btn-blue">Lihat portofolio</a>
    </div>
</section>
@endsection
