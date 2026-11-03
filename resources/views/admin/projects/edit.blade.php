@extends('admin.layouts.app')

@section('title', 'Edit Proyek')
@section('page-title', 'Edit Proyek')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-1">Edit Proyek</h4>
    <p class="text-secondary mb-0">Perbarui informasi proyek perusahaan.</p>
</div>

<form action="{{ route('admin.projects.update', $project) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="row g-4">

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h6 class="fw-semibold mb-4">Informasi Proyek</h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Proyek *</label>
                        <input type="text"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $project->title) }}"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kategori *</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @selected(old('category_id', $project->category_id) == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Klien</label>
                            <select name="client_id" class="form-select">
                                <option value="">Tanpa klien</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        @selected(old('client_id', $project->client_id) == $client->id)>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Lokasi</label>
                            <input type="text"
                                   name="location"
                                   class="form-control"
                                   value="{{ old('location', $project->location) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tahun</label>
                            <input type="number"
                                   name="year"
                                   class="form-control"
                                   value="{{ old('year', $project->year) }}"
                                   min="1900"
                                   max="2100">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nilai / Luas Proyek</label>
                        <input type="text"
                               name="value_or_area"
                               class="form-control"
                               value="{{ old('value_or_area', $project->value_or_area) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="6">{{ old('description', $project->description) }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">

                    <h6 class="fw-semibold mb-3">Cover Proyek</h6>

                    @if ($project->cover_image)
                        <img src="{{ asset('storage/'.$project->cover_image) }}"
                             alt="{{ $project->title }}"
                             class="img-fluid rounded mb-3"
                             style="max-height: 180px; width: 100%; object-fit: cover;">
                    @else
                        <p class="text-secondary small">Belum ada cover.</p>
                    @endif

                    <label class="form-label">Ganti Cover</label>

                    <input type="file"
                           name="cover_image"
                           class="form-control"
                           accept="image/jpeg,image/png,image/webp">

                    <small class="text-secondary d-block mt-2">
                        JPG, PNG, WEBP. Maksimal 4 MB.
                    </small>

                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h6 class="fw-semibold mb-3">Pengaturan Publikasi</h6>

                    <div class="form-check mb-3">
                        <input type="checkbox"
                               name="is_featured"
                               value="1"
                               class="form-check-input"
                               id="is_featured"
                               @checked(old('is_featured', $project->is_featured))>

                        <label class="form-check-label" for="is_featured">
                            Proyek unggulan
                        </label>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox"
                               name="is_published"
                               value="1"
                               class="form-check-input"
                               id="is_published"
                               @checked(old('is_published', $project->is_published))>

                        <label class="form-check-label" for="is_published">
                            Publikasikan proyek
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>

                    <a href="{{ route('admin.projects.index') }}"
                       class="btn btn-light border w-100">
                        Kembali
                    </a>

                </div>
            </div>

        </div>
    </div>
</form>

@endsection