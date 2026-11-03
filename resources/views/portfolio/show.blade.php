@extends('layouts.app')

@section('title', $project->title)
@section('description', \Illuminate\Support\Str::limit(strip_tags($project->description ?? ''), 150))

@section('content')
@php
    // Galeri: foto sampul lebih dulu, lalu foto tambahan tanpa duplikat.
    $gallery = collect([$project->cover_image])
        ->merge($project->images->pluck('image_path'))
        ->filter()->unique()->values();

    $waText = 'Halo, saya tertarik dengan layanan Anda seperti pada proyek ' . $project->title . '.';
    $specs = collect([
        ['Kategori',   $project->category->name ?? null],
        ['Klien',      $project->client->name ?? null],
        ['Lokasi',     $project->location],
        ['Tahun',      $project->year],
        ['Nilai / luas', $project->value_or_area],
    ])->filter(fn ($x) => filled($x[1]));
@endphp

<header class="page-head grid-sheet">
    <div class="container">
        <div class="crumb">
            <a href="{{ route('home') }}">Beranda</a><span>/</span>
            <a href="{{ route('portfolio.index') }}">Portofolio</a><span>/</span>{{ $project->title }}
        </div>
        <h1>{{ $project->title }}</h1>
    </div>
</header>

<section class="sheet">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                @if ($gallery->isNotEmpty())
                    <div id="gallery" class="carousel slide gallery" data-bs-ride="false">
                        <div class="carousel-inner">
                            @foreach ($gallery as $i => $path)
                                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $path) }}" alt="{{ $project->title }}, foto {{ $i + 1 }}"
                                         @if ($i > 0) loading="lazy" @endif>
                                </div>
                            @endforeach
                        </div>

                        @if ($gallery->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#gallery" data-bs-slide="prev" aria-label="Foto sebelumnya">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#gallery" data-bs-slide="next" aria-label="Foto berikutnya">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>

                            <div class="carousel-indicators thumbs">
                                @foreach ($gallery as $i => $path)
                                    <button type="button" data-bs-target="#gallery" data-bs-slide-to="{{ $i }}"
                                            class="{{ $i === 0 ? 'active' : '' }}" @if ($i === 0) aria-current="true" @endif
                                            aria-label="Foto {{ $i + 1 }}">
                                        <img src="{{ asset('storage/' . $path) }}" alt="" loading="lazy">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="empty-note">Foto proyek belum tersedia.</div>
                @endif

                @if (!empty($project->description))
                    <div class="mt-5">
                        <h2 class="mb-3">Tentang proyek</h2>
                        {!! nl2br(e($project->description)) !!}
                    </div>
                @endif
            </div>

            <aside class="col-lg-4">
                <div class="sticky-head">
                    @if ($specs->isNotEmpty())
                        <dl class="spec mb-4">
                            @foreach ($specs as [$label, $value])
                                <div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>
                            @endforeach
                        </dl>
                    @endif

                    <div class="d-grid gap-2">
                        @if (!empty($wa))
                            <a class="btn btn-blue" target="_blank" rel="noopener"
                               href="https://wa.me/{{ $wa }}?text={{ urlencode($waText) }}">
                                <i class="bi bi-whatsapp me-2"></i>Tanya lewat WhatsApp
                            </a>
                        @endif
                        <a class="btn btn-line" href="{{ route('contact') }}">Ajukan penawaran</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

@if (($related ?? collect())->isNotEmpty())
    <section class="sheet sheet-alt">
        <div class="container">
            <h2 class="mb-4">Proyek lainnya</h2>
            <div class="row g-4">
                @foreach ($related as $project)
                    <div class="col-md-6 col-lg-4">
                        @include('partials.project-card', ['project' => $project])
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
