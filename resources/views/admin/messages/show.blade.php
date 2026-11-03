@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Detail Pesan</h4>
        <p class="text-muted mb-0">
            Informasi lengkap pesan dari pengunjung website.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-3 text-muted">Nama Pengirim</div>
                <div class="col-md-9 fw-semibold">
                    {{ $message->name }}
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-3 text-muted">Kontak</div>
                <div class="col-md-9">
                    {{ $message->phone_email }}
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-3 text-muted">Perusahaan</div>
                <div class="col-md-9">
                    {{ $message->company ?? '-' }}
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-3 text-muted">Tanggal Pesan</div>
                <div class="col-md-9">
                    {{ $message->created_at?->format('d M Y, H:i') ?? '-' }}
                </div>
            </div>

            <hr>

            <div class="mb-4">
                <label class="form-label text-muted">Isi Pesan</label>

                <div class="border rounded p-3 bg-light"
                     style="white-space: pre-line;">
                    {{ $message->message }}
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap">

                <a href="{{ route('admin.messages.index') }}"
                   class="btn btn-light">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>

                @if($message->phone_email)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $message->phone_email) }}"
                       target="_blank"
                       class="btn btn-success">
                        <i class="bi bi-whatsapp me-1"></i> Hubungi via WhatsApp
                    </a>
                @endif

                <form action="{{ route('admin.messages.destroy', $message) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Hapus Pesan
                    </button>
                </form>

            </div>

        </div>
    </div>

</div>
@endsection
