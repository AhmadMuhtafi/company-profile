
@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Dokumen</h4>
            <p class="text-muted mb-0">Kelola dokumen perusahaan.</p>
        </div>

        <a href="{{ route('admin.documents.create') }}" class="btn btn-primary">
            <i class="bi bi-cloud-upload me-1"></i> Upload Dokumen
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="70">No.</th>
                            <th>Judul Dokumen</th>
                            <th>File</th>
                            <th>Tanggal Upload</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($documents as $document)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="fw-semibold">
                                    {{ $document->title }}
                                </td>

                                <td>
                                    <a href="{{ asset('storage/' . $document->file_path) }}"
                                       target="_blank"
                                       class="text-decoration-none">
                                        <i class="bi bi-file-earmark-text me-1"></i>
                                        Lihat Dokumen
                                    </a>
                                </td>

                                <td>
                                    {{ $document->created_at?->format('d M Y') ?? '-' }}
                                </td>

                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.documents.edit', $document) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('admin.documents.destroy', $document) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada dokumen.
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
