
@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Layanan</h4>
            <p class="text-muted mb-0">Kelola layanan perusahaan.</p>
        </div>

        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Layanan
        </a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="70">No.</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th>Icon</th>
                            <th>Urutan</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $service->title }}</td>
                                <td>{{ Str::limit($service->description, 70) }}</td>
                                <td>{{ $service->icon ?? '-' }}</td>
                                <td>{{ $service->sort_order }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.services.edit', $service) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('admin.services.destroy', $service) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
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
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada data layanan.
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
