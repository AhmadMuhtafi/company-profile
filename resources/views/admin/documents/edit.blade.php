
@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Edit Dokumen</h4>
        <p class="text-muted mb-0">Perbarui informasi atau file dokumen.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.documents.update', $document) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Judul Dokumen</label>
                    <input type="text"
                           name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $document->title) }}">

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">File Saat Ini</label>
                    <div>
                        <a href="{{ asset('storage/' . $document->file_path) }}"
                           target="_blank"
                           class="text-decoration-none">
                            <i class="bi bi-file-earmark-text me-1"></i>
                            Lihat Dokumen Saat Ini
                        </a>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Ganti File (Opsional)</label>
                    <input type="file"
                           name="file"
                           class="form-control @error('file') is-invalid @enderror"
                           accept=".pdf,.doc,.docx">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti file.
                        Format PDF, DOC, DOCX. Maksimal 10 MB.
                    </small>

                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>

                    <a href="{{ route('admin.documents.index') }}"
                       class="btn btn-light">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
