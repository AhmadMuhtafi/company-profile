@extends('layouts.app')

@section('title', 'Kontak')
@section('description', 'Hubungi kami untuk konsultasi dan penawaran proyek.')

@section('content')
@php
    $s = $settings ?? [];
    $profilePdf = !empty($s['profile_pdf']) ? asset('storage/' . $s['profile_pdf']) : null;

    $info = collect([
        ['Alamat',        $s['address'] ?? null,        null],
        ['Telepon',       $s['phone'] ?? null,          !empty($s['phone']) ? 'tel:' . preg_replace('/[^\d+]/', '', $s['phone']) : null],
        ['Email',         $s['email'] ?? null,          !empty($s['email']) ? 'mailto:' . $s['email'] : null],
        ['Jam kerja',     $s['office_hours'] ?? null,   null],
    ])->filter(fn ($x) => filled($x[1]));
@endphp

<header class="page-head grid-sheet">
    <div class="container">
        <div class="crumb"><a href="{{ route('home') }}">Beranda</a><span>/</span>Kontak</div>
        <h1>Ajukan penawaran</h1>
    </div>
</header>

<section class="sheet">
    <div class="container">
        <div class="row g-5">

            {{-- Formulir --}}
            <div class="col-lg-7">
                @if (session('success'))
                    <div class="alert alert-success rounded-0 border-0 border-start border-4 border-success" role="status">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger rounded-0 border-0 border-start border-4 border-danger" role="alert">
                        Pesan belum terkirim. Periksa kolom yang ditandai di bawah.
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" data-loading novalidate>
                    @csrf

                    {{-- Kolom jebakan untuk bot. Jangan dihapus. --}}
                    <div class="hp" aria-hidden="true">
                        <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror" autocomplete="name" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone_email" class="form-label">Telepon atau email</label>
                            <input type="text" id="phone_email" name="phone_email" value="{{ old('phone_email') }}"
                                   class="form-control @error('phone_email') is-invalid @enderror" required>
                            @error('phone_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="company" class="form-label">Perusahaan atau proyek <span class="text-muted-2 fw-normal">(opsional)</span></label>
                            <input type="text" id="company" name="company" value="{{ old('company') }}"
                                   class="form-control @error('company') is-invalid @enderror" autocomplete="organization">
                            @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">Kebutuhan Anda</label>
                            <textarea id="message" name="message" rows="6"
                                      class="form-control @error('message') is-invalid @enderror"
                                      placeholder="Contoh: jenis pekerjaan, lokasi, perkiraan ukuran, dan target waktu." required>{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-blue">Kirim pesan</button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Informasi kontak --}}
            <aside class="col-lg-5">
                @if ($info->isNotEmpty())
                    <dl class="spec mb-4">
                        @foreach ($info as [$label, $value, $href])
                            <div>
                                <dt>{{ $label }}</dt>
                                <dd>
                                    @if ($href)<a href="{{ $href }}" class="text-decoration-none text-reset">{{ $value }}</a>@else{{ $value }}@endif
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                @endif

                <div class="d-grid gap-2">
                    @if (!empty($wa))
                        <a class="btn btn-blue" target="_blank" rel="noopener"
                           href="https://wa.me/{{ $wa }}?text={{ urlencode('Halo, saya ingin berkonsultasi tentang proyek.') }}">
                            <i class="bi bi-whatsapp me-2"></i>Chat WhatsApp
                        </a>
                    @endif
                    @if ($profilePdf)
                        <a class="btn btn-line" href="{{ $profilePdf }}" download>
                            <i class="bi bi-download me-2"></i>Unduh company profile
                        </a>
                    @endif
                </div>
            </aside>
        </div>

        @if (!empty($s['map_embed']))
            <div class="map-wrap mt-5">
                <iframe src="{{ $s['map_embed'] }}" title="Lokasi kantor" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
            </div>
        @endif
    </div>
</section>
@endsection
