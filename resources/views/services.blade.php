@extends('layouts.app')

@section('title', 'Layanan')
@section('description', 'Layanan dan ruang lingkup pekerjaan perusahaan kami.')

@section('content')
@php
    $s = $settings ?? [];

    $serviceList = ($services ?? collect())->isNotEmpty() ? $services : collect([
        ['title' => 'Layanan utama pertama', 'description' => 'Jelaskan layanan ini dalam satu atau dua kalimat yang konkret.', 'icon' => 'bi-building'],
        ['title' => 'Layanan utama kedua',   'description' => 'Sebutkan ruang lingkup dan hasil yang diterima klien.',          'icon' => 'bi-tools'],
        ['title' => 'Layanan utama ketiga',  'description' => 'Tambahkan detail yang dibutuhkan tim pengadaan pengembang.',    'icon' => 'bi-clipboard-check'],
    ]);

    // Alur kerja bersifat urutan, jadi diberi nomor. Ubah sesuai proses Anda.
    $steps = [
        ['Konsultasi',    'Kami memahami kebutuhan, lokasi, anggaran, dan jadwal proyek.'],
        ['Penawaran',     'Rencana anggaran biaya dan jadwal dikirim secara tertulis dan rinci.'],
        ['Pelaksanaan',   'Pekerjaan berjalan dengan laporan progres berkala dan pengawasan mutu.'],
        ['Serah terima',  'Pemeriksaan akhir, dokumen serah terima, dan masa pemeliharaan.'],
    ];
@endphp

<header class="page-head grid-sheet">
    <div class="container">
        <div class="crumb"><a href="{{ route('home') }}">Beranda</a><span>/</span>Layanan</div>
        <h1>Layanan</h1>
    </div>
</header>

<section class="sheet">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="sticky-head">
                    <h2>Ruang lingkup pekerjaan</h2>
                    <p class="text-muted-2 mt-3">Setiap layanan dapat dikerjakan terpisah atau digabung dalam satu paket.</p>
                </div>
            </div>
            <div class="col-lg-8">
                <ul class="ruled">
                    @foreach ($serviceList as $sv)
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

<section class="sheet sheet-alt">
    <div class="container">
        <h2 class="mb-4">Alur kerja</h2>
        <div class="steps">
            @foreach ($steps as $i => [$title, $text])
                <div class="step">
                    <b>{{ $i + 1 }}</b>
                    <h3>{{ $title }}</h3>
                    <p>{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h2>Ceritakan kebutuhan proyek Anda</h2>
                <p class="mt-3 mb-0">Semakin jelas lokasi, ukuran, dan jadwal, semakin cepat kami menyiapkan penawaran.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('contact') }}" class="btn btn-blue">Ajukan penawaran</a>
            </div>
        </div>
    </div>
</section>
@endsection
