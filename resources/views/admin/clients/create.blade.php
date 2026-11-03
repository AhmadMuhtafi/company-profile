@extends('admin.layouts.app')

@section('title', 'Tambah Klien')
@section('page-title', 'Tambah Klien')

@section('content')

<h4 class="fw-bold mb-1">Tambah Klien</h4>
<p class="text-secondary mb-4">Tambahkan data klien perusahaan.</p>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <form action="{{ route('admin.clients.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Klien *</label>

                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       placeholder="Masukkan nama klien"
                       required>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Logo Klien</label>

                <input type="file"
                       name="logo"
                       class="form-control @error('logo') is-invalid @enderror"
                       accept="image/*">

                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <small class="text-secondary">
                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                </small>
            </div>

            <div class="form-check mb-4">
                <input type="checkbox"
                       name="show_logo"
                       value="1"
                       class="form-check-input"
                       id="show_logo"
                       @checked(old('show_logo', true))>

                <label class="form-check-label" for="show_logo">
                    Tampilkan logo di website
                </label>
            </div>

            <button class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan
            </button>

            <a href="{{ route('admin.clients.index') }}"
               class="btn btn-light border">
                Kembali
            </a>
        </form>

    </div>
</div>

@endsection