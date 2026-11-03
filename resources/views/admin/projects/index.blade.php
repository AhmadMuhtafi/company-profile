@extends('admin.layouts.app')

@section('title', 'Proyek')
@section('page-title', 'Manajemen Proyek')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Proyek</h4>
        <p class="text-secondary mb-0">
            Kelola portofolio dan proyek perusahaan.
        </p>
    </div>

    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Proyek
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">No.</th>
                    <th>Cover</th>
                    <th>Nama Proyek</th>
                    <th>Kategori</th>
                    <th>Klien</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td class="ps-3">
                            {{ $projects->firstItem() + $loop->index }}
                        </td>

                        <td>
                            @if ($project->cover_image)
                                <img
                                    src="{{ asset('storage/'.$project->cover_image) }}"
                                    alt="{{ $project->title }}"
                                    width="75"
                                    height="50"
                                    class="rounded"
                                    style="object-fit: cover"
                                >
                            @else
                                <div class="bg-body-secondary rounded d-flex align-items-center justify-content-center"
                                     style="width:75px;height:50px">
                                    <i class="bi bi-image text-secondary"></i>
                                </div>
                            @endif
                        </td>

                        <td>
                            <div class="fw-semibold">{{ $project->title }}</div>

                            @if ($project->is_featured)
                                <span class="badge text-bg-warning mt-1">
                                    <i class="bi bi-star-fill me-1"></i>Unggulan
                                </span>
                            @endif
                        </td>

                        <td>{{ $project->category->name ?? '-' }}</td>

                        <td>{{ $project->client->name ?? '-' }}</td>

                        <td>{{ $project->year ?? '-' }}</td>

                        <td>
                            @if ($project->is_published)
                                <span class="badge text-bg-success">Tayang</span>
                            @else
                                <span class="badge text-bg-secondary">Draf</span>
                            @endif
                        </td>

                        <td class="text-end pe-3">
                            <a href="{{ route('admin.projects.images.index', $project) }}"
                                class="btn btn-sm btn-outline-secondary"
                                title="Kelola Galeri">
                                <i class="bi bi-images"></i>
                            </a>

                            <a href="{{ route('admin.projects.edit', $project) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('admin.projects.destroy', $project) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus proyek ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="bi bi-building"></i>
                                Belum ada proyek.
                                <div class="mt-3">
                                    <a href="{{ route('admin.projects.create') }}"
                                       class="btn btn-primary btn-sm">
                                        Tambah Proyek Pertama
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $projects->links() }}
</div>

@endsection