@extends('admin.layouts.app')

@section('title', 'Edit Klien')
@section('page-title', 'Edit Klien')

@section('content')

<h4 class="fw-bold mb-1">Edit Klien</h4>
<p class="text-secondary mb-4">Perbarui informasi klien perusahaan.</p>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <form action="{{ route('admin.clients.update', $client) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Klien *</label>

                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $client->name) }}"
                       required>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Logo Saat Ini</label>

                @if ($client->logo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$client->logo) }}"
                             alt="{{ $client->name }}"
                             style="width:120px;height:80px;object-fit:contain">
                    </div>
                @else
                    <p class="text-secondary small">Belum ada logo.</p>
                @endif

                <label class="form-label">Ganti Logo</label>

                <input type="file"
                       name="logo"
                       class="form-control @error('logo') is-invalid @enderror"
                       accept="image/*">

                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check mb-4">
                <input type="checkbox"
                       name="show_logo"
                       value="1"
                       class="form-check-input"
                       id="show_logo"
                       @checked(old('show_logo', $client->show_logo))>

                <label class="form-check-label" for="show_logo">
                    Tampilkan logo di website
                </label>
            </div>

            <button class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan Perubahan
            </button>

            <a href="{{ route('admin.clients.index') }}"
               class="btn btn-light border">
                Kembali
            </a>
        </form>

    </div>
</div>

@endsection