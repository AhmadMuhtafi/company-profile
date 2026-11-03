@extends('admin.layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-1">Tambah Kategori</h4>
    <p class="text-secondary mb-0">
        Tambahkan kategori baru untuk proyek perusahaan.
    </p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label fw-semibold">
                    Nama Kategori <span class="text-danger">*</span>
                </label>

                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Contoh: Konstruksi Gedung"
                       value="{{ old('name') }}"
                       required>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <small class="text-secondary">
                    Slug akan dibuat otomatis berdasarkan nama kategori.
                </small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Simpan Kategori
                </button>

                <a href="{{ route('admin.categories.index') }}"
                   class="btn btn-light border">
                    Kembali
                </a>
            </div>
        </form>

    </div>
</div>

@endsection