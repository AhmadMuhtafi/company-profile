
@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Tambah Layanan</h4>
        <p class="text-muted mb-0">Tambahkan layanan perusahaan.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.services.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Layanan</label>
                    <input type="text" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}"
                           placeholder="Contoh: Konsultasi Bisnis">

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Jelaskan layanan perusahaan...">{{ old('description') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Icon</label>
                    <input type="text" name="icon"
                           class="form-control @error('icon') is-invalid @enderror"
                           value="{{ old('icon') }}"
                           placeholder="Contoh: bi bi-briefcase">

                    <small class="text-muted">
                        Gunakan nama class Bootstrap Icons.
                    </small>

                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Urutan Tampilan</label>
                    <input type="number" name="sort_order"
                           class="form-control @error('sort_order') is-invalid @enderror"
                           value="{{ old('sort_order', 0) }}" min="0">

                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>

                    <a href="{{ route('admin.services.index') }}"
                       class="btn btn-light">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
