@extends('admin.layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Kategori</h4>
        <p class="text-secondary mb-0">
            Kelola kategori untuk mengelompokkan proyek perusahaan.
        </p>
    </div>

    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>
        Tambah Kategori
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent py-3">
        <h6 class="fw-semibold mb-0">Daftar Kategori</h6>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3" width="70">No.</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Dibuat</th>
                    <th class="text-end pe-3" width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="ps-3">
                            {{ $categories->firstItem() + $loop->index }}
                        </td>

                        <td class="fw-semibold">
                            {{ $category->name }}
                        </td>

                        <td>
                            <span class="text-secondary">
                                {{ $category->slug }}
                            </span>
                        </td>

                        <td class="text-secondary">
                            {{ $category->created_at->format('d/m/Y') }}
                        </td>

                        <td class="text-end pe-3">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="btn btn-sm btn-outline-primary"
                               title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="bi bi-tags"></i>
                                Belum ada kategori.
                                <div class="mt-3">
                                    <a href="{{ route('admin.categories.create') }}"
                                       class="btn btn-primary btn-sm">
                                        Tambah Kategori Pertama
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
    {{ $categories->links() }}
</div>

@endsection