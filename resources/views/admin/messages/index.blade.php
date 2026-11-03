@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Pesan Masuk</h4>
        <p class="text-muted mb-0">
            Kelola pesan yang dikirim melalui formulir kontak website.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="60">No.</th>
                            <th>Nama Pengirim</th>
                            <th>Kontak</th>
                            <th>Perusahaan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($messages as $message)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="fw-semibold">
                                    {{ $message->name }}
                                </td>

                                <td>{{ $message->phone_email }}</td>

                                <td>{{ $message->company ?? '-' }}</td>

                                <td>
                                    @if($message->is_read)
                                        <span class="badge bg-success">
                                            Sudah Dibaca
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            Belum Dibaca
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $message->created_at?->format('d M Y H:i') ?? '-' }}
                                </td>

                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.messages.show', $message) }}"
                                           class="btn btn-sm btn-primary"
                                           title="Lihat pesan">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <form action="{{ route('admin.messages.destroy', $message) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Hapus pesan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7"
                                    class="text-center text-muted py-4">
                                    Belum ada pesan masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
