@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Pengaturan Website</h4>
        <p class="text-muted mb-0">Kelola informasi dan identitas perusahaan.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            Periksa kembali data yang kamu masukkan.
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Identitas Perusahaan</h5>

                <div class="mb-3">
                    <label class="form-label">Nama Perusahaan</label>
                    <input type="text" name="settings[company_name]"
                        class="form-control"
                        value="{{ old('settings.company_name', $settings['company_name'] ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tagline</label>
                    <input type="text" name="settings[tagline]"
                        class="form-control"
                        value="{{ old('settings.tagline', $settings['tagline'] ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Singkat</label>
                    <textarea name="settings[about_short]" rows="3"
                        class="form-control">{{ old('settings.about_short', $settings['about_short'] ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Profil Lengkap</label>
                    <textarea name="settings[about_long]" rows="5"
                        class="form-control">{{ old('settings.about_long', $settings['about_long'] ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun Berdiri</label>
                    <input type="number" name="settings[founded_year]"
                        class="form-control"
                        value="{{ old('settings.founded_year', $settings['founded_year'] ?? '') }}">
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Visi dan Misi</h5>

                <div class="mb-3">
                    <label class="form-label">Visi</label>
                    <textarea name="settings[vision]" rows="3"
                        class="form-control">{{ old('settings.vision', $settings['vision'] ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Misi</label>
                    <textarea name="settings[mission]" rows="5"
                        class="form-control"
                        placeholder="Tuliskan satu poin misi per baris">{{ old('settings.mission', $settings['mission'] ?? '') }}</textarea>
                    <small class="text-muted">Gunakan baris baru untuk memisahkan setiap poin misi.</small>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Statistik Perusahaan</h5>

                <div class="row">
                    @foreach([
                        'stat_years' => 'Pengalaman (tahun)',
                        'stat_projects' => 'Jumlah Proyek',
                        'stat_clients' => 'Jumlah Klien',
                        'stat_employees' => 'Jumlah Karyawan',
                    ] as $key => $label)
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ $label }}</label>
                            <input type="number" min="0"
                                name="settings[{{ $key }}]"
                                class="form-control"
                                value="{{ old('settings.'.$key, $settings[$key] ?? '') }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Legalitas Perusahaan</h5>

                @foreach([
                    'akta_no' => 'Nomor Akta',
                    'nib' => 'NIB',
                    'npwp' => 'NPWP',
                    'sbu' => 'SBU',
                    'qualification' => 'Kualifikasi Perusahaan',
                ] as $key => $label)
                    <div class="mb-3">
                        <label class="form-label">{{ $label }}</label>
                        <input type="text"
                            name="settings[{{ $key }}]"
                            class="form-control"
                            value="{{ old('settings.'.$key, $settings[$key] ?? '') }}">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Informasi Kontak</h5>

                <div class="mb-3">
                    <label class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="settings[wa_number]"
                        class="form-control"
                        placeholder="081234567890"
                        value="{{ old('settings.wa_number', $settings['wa_number'] ?? '') }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="settings[phone]"
                            class="form-control"
                            value="{{ old('settings.phone', $settings['phone'] ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="settings[email]"
                            class="form-control"
                            value="{{ old('settings.email', $settings['email'] ?? '') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="settings[address]" rows="3"
                        class="form-control">{{ old('settings.address', $settings['address'] ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jam Operasional</label>
                    <input type="text" name="settings[office_hours]"
                        class="form-control"
                        placeholder="Senin - Jumat, 08.00 - 17.00"
                        value="{{ old('settings.office_hours', $settings['office_hours'] ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Google Maps Embed URL</label>
                    <textarea name="settings[map_embed]" rows="3"
                        class="form-control"
                        placeholder="Masukkan URL src dari Google Maps Embed">{{ old('settings.map_embed', $settings['map_embed'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Media Sosial</h5>

                @foreach([
                    'instagram' => 'Instagram',
                    'facebook' => 'Facebook',
                    'linkedin' => 'LinkedIn',
                    'youtube' => 'YouTube',
                ] as $key => $label)
                    <div class="mb-3">
                        <label class="form-label">{{ $label }}</label>
                        <input type="url"
                            name="settings[{{ $key }}]"
                            class="form-control"
                            placeholder="https://..."
                            value="{{ old('settings.'.$key, $settings[$key] ?? '') }}">
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary mb-4">
            <i class="bi bi-save me-1"></i> Simpan Pengaturan
        </button>

    </form>
</div>
@endsection
