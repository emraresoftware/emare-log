@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mikrotik.hat.index') }}">Hatlar</a></li>
            <li class="breadcrumb-item active">Hat Düzenle</li>
        </ol>
    </nav>

    <h1 class="h3 mb-4">Hat Düzenle: {{ $hat->ad }}</h1>

    <form method="POST" action="{{ route('mikrotik.hat.store') }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="hat_id" value="{{ $hat->id }}">

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0"><i class="fas fa-network-wired me-2"></i>Hat Bilgileri</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Hat Adı <span class="text-danger">*</span></label>
                        <input type="text" name="ad" class="form-control @error('ad') is-invalid @enderror" value="{{ old('ad', $hat->ad) }}" required>
                        @error('ad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mikrotik <span class="text-danger">*</span></label>
                        <select name="mikrotik_id" class="form-select select2 @error('mikrotik_id') is-invalid @enderror" required>
                            <option value="">Mikrotik Seçiniz</option>
                            @foreach($mikrotikler ?? [] as $mikrotik)
                                <option value="{{ $mikrotik->id }}" {{ old('mikrotik_id', $hat->mikrotik_id) == $mikrotik->id ? 'selected' : '' }}>
                                    {{ $mikrotik->ad }} ({{ $mikrotik->ip_adresi }})
                                </option>
                            @endforeach
                        </select>
                        @error('mikrotik_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hat Tipi</label>
                        <input type="text" name="hat_tipi" class="form-control" value="{{ old('hat_tipi', $hat->hat_tipi) }}" placeholder="Örn: Fiber, ADSL">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kapasite <span class="text-danger">*</span></label>
                        <input type="number" name="kapasite" class="form-control @error('kapasite') is-invalid @enderror" value="{{ old('kapasite', $hat->kapasite) }}" min="0" required>
                        @error('kapasite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kullanılan</label>
                        <input type="number" name="kullanilan" class="form-control" value="{{ old('kullanilan', $hat->kullanilan) }}" min="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Durum <span class="text-danger">*</span></label>
                        <select name="aktif" class="form-select" required>
                            <option value="1" {{ old('aktif', $hat->aktif) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('aktif', $hat->aktif) == 0 ? 'selected' : '' }}>Pasif</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('mikrotik.hat.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Geri Dön
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Güncelle
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.select2').select2({ theme: 'bootstrap-5', placeholder: 'Mikrotik Seçiniz', allowClear: true });
});
</script>
@endpush
@endsection
