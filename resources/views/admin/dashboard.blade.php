@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@php
    $stats          = $stats ?? [];
    $recentMessages = $recentMessages ?? collect();
    $recentProjects = $recentProjects ?? collect();

    $adminName = auth('admin')->user()->email ?? 'Admin';
    $link = fn (string $name) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';

    $statLabels = [
        'projects' => 'Proyek', 'total_projects' => 'Proyek', 'clients' => 'Klien', 'services' => 'Layanan',
        'categories' => 'Kategori', 'documents' => 'Dokumen', 'messages' => 'Pesan masuk',
        'unread_messages' => 'Belum dibaca', 'featured_projects' => 'Proyek unggulan',
    ];
    $statIcons = [
        'projects' => 'bi-building', 'total_projects' => 'bi-building', 'clients' => 'bi-people',
        'services' => 'bi-tools', 'categories' => 'bi-tags', 'documents' => 'bi-file-earmark-pdf',
        'messages' => 'bi-envelope', 'unread_messages' => 'bi-envelope-exclamation',
        'featured_projects' => 'bi-star',
    ];
    $tones = ['primary', 'success', 'warning', 'info', 'danger', 'secondary'];
@endphp

{{-- Sapaan --}}
<div class="mb-4">
    <h1 class="h3 fw-bold mb-1">Halo, {{ $adminName }}</h1>
    <p class="text-secondary mb-0">Berikut ringkasan website company profile Anda hari ini.</p>
</div>

{{-- Statistik --}}
<div class="row g-3 mb-4">
    @forelse ($stats as $key => $value)
        @php
            $tone  = $tones[$loop->index % count($tones)];
            $label = $statLabels[$key] ?? ucfirst(str_replace('_', ' ', $key));
            $icon  = $statIcons[$key] ?? 'bi-bar-chart';
        @endphp
        <div class="col-6 col-xl-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-{{ $tone }}-subtle text-{{ $tone }}">
                        <i class="bi {{ $icon }}"></i>
                    </div>
                    <div>
                        <div class="text-secondary small">{{ $label }}</div>
                        <div class="fs-3 fw-bold lh-1 mt-1">
                            {{ is_numeric($value) ? number_format($value, 0, ',', '.') : $value }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="empty-state"><i class="bi bi-bar-chart"></i>Belum ada data statistik.</div>
            </div>
        </div>
    @endforelse
</div>

{{-- Aksi cepat --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h2 class="h6 fw-semibold mb-3">Aksi cepat</h2>
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <a href="{{ $link('admin.projects.create') }}" class="quick-action"><i class="bi bi-plus-circle"></i><span>Tambah proyek</span></a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="{{ $link('admin.clients.create') }}" class="quick-action"><i class="bi bi-person-plus"></i><span>Tambah klien</span></a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="{{ $link('admin.documents.create') }}" class="quick-action"><i class="bi bi-cloud-upload"></i><span>Unggah dokumen</span></a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="{{ $link('admin.settings.index') }}" class="quick-action"><i class="bi bi-sliders"></i><span>Ubah angka beranda</span></a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Pesan terbaru --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                <h2 class="h6 fw-semibold mb-0">Pesan terbaru</h2>
                <a href="{{ $link('admin.messages.index') }}" class="small text-decoration-none">Lihat semua</a>
            </div>
            <div class="card-body p-0">
                @forelse ($recentMessages as $m)
                    <div class="msg-item d-flex gap-3">
                        <span class="avatar flex-shrink-0">{{ strtoupper(mb_substr($m->name, 0, 1)) }}</span>
                        <div class="min-w-0 flex-grow-1">
                            <div class="d-flex justify-content-between gap-2">
                                <span class="fw-semibold text-truncate">
                                    {{ $m->name }}
                                    @unless ($m->is_read)
                                        <span class="badge text-bg-primary ms-1">Baru</span>
                                    @endunless
                                </span>
                                <small class="text-secondary text-nowrap">{{ optional($m->created_at)->diffForHumans() }}</small>
                            </div>
                            @if ($m->company)
                                <small class="text-secondary d-block">{{ $m->company }}</small>
                            @endif
                            <div class="text-secondary small text-truncate mt-1">{{ $m->message }}</div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state"><i class="bi bi-inbox"></i>Belum ada pesan masuk.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Proyek terbaru --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                <h2 class="h6 fw-semibold mb-0">Proyek terbaru</h2>
                <a href="{{ $link('admin.projects.index') }}" class="small text-decoration-none">Kelola proyek</a>
            </div>
            <div class="card-body p-0">
                @if ($recentProjects->isEmpty())
                    <div class="empty-state">
                        <i class="bi bi-building"></i>
                        Belum ada proyek.
                        <div class="mt-3">
                            <a href="{{ $link('admin.projects.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg me-1"></i>Tambah proyek pertama
                            </a>
                        </div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Proyek</th>
                                    <th>Kategori</th>
                                    <th>Tahun</th>
                                    <th class="pe-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentProjects as $p)
                                    <tr>
                                        <td class="ps-3 fw-semibold">{{ $p->title }}</td>
                                        <td class="text-secondary">{{ $p->category->name ?? '-' }}</td>
                                        <td class="text-secondary">{{ $p->year }}</td>
                                        <td class="pe-3">
                                            @if ($p->is_published)
                                                <span class="badge text-bg-success">Tayang</span>
                                            @else
                                                <span class="badge text-bg-secondary">Draf</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection