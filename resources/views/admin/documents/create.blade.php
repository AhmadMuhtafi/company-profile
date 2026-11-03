
@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Upload Dokumen</h4>
        <p class="text-muted mb-0">Tambahkan dokumen perusahaan.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.documents.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label class="form-label">Judul Dokumen</label>
                    <input type="text"
                           name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}"
                           placeholder="Contoh: Company Profile">

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Pilih File</label>
                    <input type="file"
                           name="file"
                           class="form-control @error('file') is-invalid @enderror"
                           accept=".pdf,.doc,.docx">

                    <small class="text-muted">
                        Format PDF, DOC, DOCX. Maksimal 10 MB.
                    </small>

                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cloud-upload me-1"></i> Upload
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
