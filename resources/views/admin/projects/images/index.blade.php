@extends('admin.layouts.app')

@section('title', 'Galeri Proyek')
@section('page-title', 'Galeri Proyek')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Galeri Proyek</h4>
        <p class="text-secondary mb-0">{{ $project->title }}</p>
    </div>

    <a href="{{ route('admin.projects.index') }}"
       class="btn btn-light border">
        Kembali ke Proyek
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <h6 class="fw-semibold mb-3">Unggah Foto Galeri</h6>

        <form action="{{ route('admin.projects.images.store', $project) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Pilih Foto</label>
                <input type="file"
                       name="images[]"
                       class="form-control"
                       accept="image/jpeg,image/png,image/webp"
                       multiple
                       required>

                <small class="text-secondary">
                    Bisa memilih beberapa foto sekaligus. Maksimal 4 MB per foto.
                </small>

                @error('images')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror

                @foreach ($errors->get('images.*') as $messages)
                    @foreach ($messages as $message)
                        <div class="text-danger small">{{ $message }}</div>
                    @endforeach
                @endforeach
            </div>

            <button class="btn btn-primary">
                <i class="bi bi-cloud-upload me-1"></i> Unggah Foto
            </button>
        </form>
    </div>
</div>

<div class="mb-3">
    <h6 class="fw-semibold">Foto Galeri ({{ $images->count() }})</h6>
</div>

<div class="row g-3">
    @forelse ($images as $image)
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ asset('storage/'.$image->image_path) }}"
                     alt="{{ $image->caption ?? $project->title }}"
                     class="card-img-top"
                     style="height:200px;object-fit:cover">

                <div class="card-body">
                    <form action="{{ route('admin.project-images.update', $image) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-2">
                            <label class="form-label small">Caption</label>
                            <input type="text"
                                   name="caption"
                                   class="form-control form-control-sm"
                                   value="{{ $image->caption }}"
                                   placeholder="Keterangan foto">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">Urutan</label>
                            <input type="number"
                                   name="sort_order"
                                   class="form-control form-control-sm"
                                   value="{{ $image->sort_order }}"
                                   min="0"
                                   required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button class="btn btn-sm btn-primary">
                                Simpan
                            </button>
                    </form>

                            <form action="{{ route('admin.project-images.destroy', $image) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus foto ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="empty-state">
                    <i class="bi bi-images"></i>
                    Belum ada foto galeri.
                </div>
            </div>
        </div>
    @endforelse
</div>

@endsection