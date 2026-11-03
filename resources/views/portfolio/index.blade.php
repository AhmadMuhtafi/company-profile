@extends('layouts.app')

@section('title', 'Portofolio')
@section('description', 'Daftar proyek yang telah kami selesaikan.')

@section('content')
<header class="page-head grid-sheet">
    <div class="container">
        <div class="crumb"><a href="{{ route('home') }}">Beranda</a><span>/</span>Portofolio</div>
        <h1>Portofolio</h1>
    </div>
</header>

<section class="sheet">
    <div class="container">

        {{-- Filter kategori --}}
        @if (($categories ?? collect())->isNotEmpty())
            <nav class="tabs mb-5" aria-label="Filter kategori">
                <a href="{{ route('portfolio.index') }}" class="{{ empty($activeCategory) ? 'active' : '' }}">Semua</a>
                @foreach ($categories as $cat)
                    <a href="{{ route('portfolio.index', ['kategori' => $cat->slug]) }}"
                       class="{{ ($activeCategory ?? null) === $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </nav>
        @endif

        {{-- Daftar proyek --}}
        @if ($projects->isNotEmpty())
            <div class="row g-4">
                @foreach ($projects as $project)
                    <div class="col-md-6 col-lg-4">
                        @include('partials.project-card', ['project' => $project])
                    </div>
                @endforeach
            </div>

            <div class="mt-5">
                {{ $projects->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="empty-note">
                Belum ada proyek di kategori ini.
                @if (!empty($activeCategory))
                    <div class="mt-3"><a href="{{ route('portfolio.index') }}" class="btn btn-line btn-sm">Tampilkan semua proyek</a></div>
                @endif
            </div>
        @endif
    </div>
</section>

{{-- Klien --}}
@if (($clients ?? collect())->isNotEmpty())
    <section class="sheet sheet-alt">
        <div class="container">
            <h2 class="mb-4">Klien dan mitra</h2>
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
@endsection
