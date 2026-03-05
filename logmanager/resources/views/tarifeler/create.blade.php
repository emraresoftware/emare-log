@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tarife.index') }}">Tarifeler</a></li>
            <li class="breadcrumb-item active">Tarife Ekle</li>
        </ol>
    </nav>

    <h1 class="h3 mb-4">Tarife Ekle</h1>

    <form method="POST" action="{{ route('tarife.store') }}">
        @csrf

        {{-- Tarife Bilgileri --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Tarife Bilgileri</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tarife Adı <span class="text-danger">*</span></label>
                        <input type="text" name="ad" class="form-control @error('ad') is-invalid @enderror" value="{{ old('ad') }}" required>
                        @error('ad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tarife Kodu <span class="text-danger">*</span></label>
                        <input type="text" name="kod" class="form-control @error('kod') is-invalid @enderror" value="{{ old('kod') }}" required>
                        @error('kod')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Açıklama</label>
                        <input type="text" name="aciklama" class="form-control" value="{{ old('aciklama') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Hız Bilgileri --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0"><i class="fas fa-tachometer-alt me-2"></i>Hız Bilgileri</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Download Hızı (Mbps) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="download_hizi" class="form-control @error('download_hizi') is-invalid @enderror" value="{{ old('download_hizi') }}" required>
                            <span class="input-group-text">Mbps</span>
                        </div>
                        @error('download_hizi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Upload Hızı (Mbps) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="upload_hizi" class="form-control @error('upload_hizi') is-invalid @enderror" value="{{ old('upload_hizi') }}" required>
                            <span class="input-group-text">Mbps</span>
                        </div>
                        @error('upload_hizi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kota (GB)</label>
                        <div class="input-group">
                            <input type="number" name="kota" class="form-control" value="{{ old('kota', 0) }}" min="0">
                            <span class="input-group-text">GB</span>
                        </div>
                        <small class="text-muted">0 = Sınırsız</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Fiyat --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0"><i class="fas fa-lira-sign me-2"></i>Fiyat Bilgileri</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Fiyat (₺) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">₺</span>
                            <input type="number" step="0.01" name="fiyat" id="fiyat" class="form-control @error('fiyat') is-invalid @enderror" value="{{ old('fiyat') }}" required>
                        </div>
                        @error('fiyat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">KDV Oranı (%) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="kdv_orani" id="kdvOrani" class="form-control @error('kdv_orani') is-invalid @enderror" value="{{ old('kdv_orani', 20) }}" required>
                            <span class="input-group-text">%</span>
                        </div>
                        @error('kdv_orani')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">KDV Dahil Fiyat (₺)</label>
                        <div class="input-group">
                            <span class="input-group-text">₺</span>
                            <input type="text" id="kdvDahilFiyat" class="form-control" readonly>
                        </div>
                        <input type="hidden" name="kdv_dahil_fiyat" id="kdvDahilFiyatHidden">
                    </div>
                </div>
            </div>
        </div>

        {{-- Diğer --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0"><i class="fas fa-cog me-2"></i>Diğer Ayarlar</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Taahhüt Süresi (Ay)</label>
                        <div class="input-group">
                            <input type="number" name="taahhut_suresi" class="form-control" value="{{ old('taahhut_suresi', 0) }}" min="0">
                            <span class="input-group-text">Ay</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kurulum Ücreti (₺)</label>
                        <div class="input-group">
                            <span class="input-group-text">₺</span>
                            <input type="number" step="0.01" name="kurulum_ucreti" class="form-control" value="{{ old('kurulum_ucreti', 0) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Durum <span class="text-danger">*</span></label>
                        <select name="durum" class="form-select" required>
                            <option value="aktif" {{ old('durum') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="pasif" {{ old('durum') == 'pasif' ? 'selected' : '' }}>Pasif</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Butonlar --}}
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('tarife.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Geri Dön
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Tarife Kaydet
            </button>
        </div>

    </form>

</div>

@push('scripts')
<script>
    $(document).ready(function() {
        function kdvHesapla() {
            let fiyat = parseFloat($('#fiyat').val()) || 0;
            let kdvOrani = parseFloat($('#kdvOrani').val()) || 0;
            let kdvDahil = fiyat * (1 + kdvOrani / 100);
            $('#kdvDahilFiyat').val(kdvDahil.toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $('#kdvDahilFiyatHidden').val(kdvDahil.toFixed(2));
        }

        $('#fiyat, #kdvOrani').on('input', kdvHesapla);
        kdvHesapla();
    });
</script>
@endpush
@endsection
