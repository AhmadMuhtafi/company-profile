{{-- Kartu proyek. Dipakai di beranda, daftar portofolio, dan proyek terkait. Kirim variabel: $project --}}
<a href="{{ route('portfolio.show', $project->slug) }}" class="pcard h-100">
    <div class="thumb">
        @if ($project->cover_image)
            <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->title }}" loading="lazy">
        @else
            <i class="bi bi-image" aria-hidden="true"></i>
        @endif
    </div>
    <div class="cap">
        <div>
            <h3>{{ $project->title }}</h3>
            <div class="meta">
                {{ $project->category->name ?? 'Proyek' }}@if ($project->location), {{ $project->location }}@endif
            </div>
        </div>
        @if ($project->year)
            <span class="yr">{{ $project->year }}</span>
        @endif
    </div>
</a>
