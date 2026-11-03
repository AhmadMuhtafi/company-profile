@extends('admin.layouts.app')

@section('title', 'Klien')
@section('page-title', 'Manajemen Klien')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Klien</h4>
        <p class="text-secondary mb-0">
            Kelola daftar klien dan logo perusahaan.
        </p>
    </div>

    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Klien
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">No.</th>
                    <th>Logo</th>
                    <th>Nama Klien</th>
                    <th>Visibilitas</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($clients as $client)
                    <tr>
                        <td class="ps-3">
                            {{ $clients->firstItem() + $loop->index }}
                        </td>

                        <td>
                            @if ($client->logo)
                                <img src="{{ asset('storage/'.$client->logo) }}"
                                     alt="{{ $client->name }}"
                                     style="width:65px;height:45px;object-fit:contain">
                            @else
                                <span class="text-secondary small">Tidak ada logo</span>
                            @endif
                        </td>

                        <td class="fw-semibold">{{ $client->name }}</td>

                        <td>
                            @if ($client->show_logo)
                                <span class="badge text-bg-success">Ditampilkan</span>
                            @else
                                <span class="badge text-bg-secondary">Disembunyikan</span>
                            @endif
                        </td>

                        <td class="text-end pe-3">
                            <a href="{{ route('admin.clients.edit', $client) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('admin.clients.destroy', $client) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus klien ini?')">
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
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="bi bi-people"></i>
                                Belum ada data klien.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $clients->links() }}
</div>

@endsection