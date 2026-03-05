@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hat.index') }}">Hatlar</a></li>
            <li class="breadcrumb-item active">Hat Ekle</li>
        </ol>
    </nav>

    <h1 class="h3 mb-4">Hat Ekle</h1>

    <form method="POST" action="{{ route('hat.store') }}">
        @csrf

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0"><i class="fas fa-network-wired me-2"></i>Hat Bilgileri</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Hat Adı <span class="text-danger">*</span></label>
                        <input type="text" name="ad" class="form-control @error('ad') is-invalid @enderror" value="{{ old('ad') }}" required>
                        @error('ad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mikrotik <span class="text-danger">*</span></label>
                        <select name="mikrotik_id" class="form-select select2 @error('mikrotik_id') is-invalid @enderror" required>
                            <option value="">Mikrotik Seçiniz</option>
                            @foreach($mikrotikler ?? [] as $mikrotik)
                                <option value="{{ $mikrotik->id }}" {{ old('mikrotik_id') == $mikrotik->id ? 'selected' : '' }}>
                                    {{ $mikrotik->ad }} ({{ $mikrotik->ip_adresi }})
                                </option>
                            @endforeach
                        </select>
                        @error('mikrotik_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kapasite <span class="text-danger">*</span></label>
                        <input type="number" name="kapasite" class="form-control @error('kapasite') is-invalid @enderror" value="{{ old('kapasite') }}" min="1" required>
                        @error('kapasite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">VLAN</label>
                        <input type="text" name="vlan" class="form-control" value="{{ old('vlan') }}" placeholder="Örn: 100">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Durum <span class="text-danger">*</span></label>
                        <select name="durum" class="form-select" required>
                            <option value="aktif" {{ old('durum') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="pasif" {{ old('durum') == 'pasif' ? 'selected' : '' }}>Pasif</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Açıklama</label>
                        <textarea name="aciklama" class="form-control" rows="3" placeholder="Hat hakkında açıklama...">{{ old('aciklama') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Butonlar --}}
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('hat.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Geri Dön
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Hat Kaydet
            </button>
        </div>

    </form>

</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Mikrotik Seçiniz',
            allowClear: true
        });
    });
</script>
@endpush
@endsection
