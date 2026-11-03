@extends('admin.layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-1">Edit Kategori</h4>
    <p class="text-secondary mb-0">
        Perbarui informasi kategori.
    </p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <form action="{{ route('admin.categories.update', $category) }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label fw-semibold">
                    Nama Kategori <span class="text-danger">*</span>
                </label>

                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $category->name) }}"
                       required>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <small class="text-secondary">
                    Slug akan diperbarui otomatis jika nama kategori berubah.
                </small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Simpan Perubahan
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