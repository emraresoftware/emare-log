@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Yeni Başvuru</h1>
        <a href="{{ route('basvurular.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Geri Dön
        </a>
    </div>

    <form action="{{ route('basvurular.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            {{-- Kişisel Bilgiler --}}
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2 text-primary"></i>Kişisel Bilgiler</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="ad" class="form-label">Ad <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('ad') is-invalid @enderror" id="ad" name="ad" value="{{ old('ad') }}" required>
                                @error('ad')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="soyad" class="form-label">Soyad <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('soyad') is-invalid @enderror" id="soyad" name="soyad" value="{{ old('soyad') }}" required>
                                @error('soyad')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tc_no" class="form-label">TC Kimlik No <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tc_no') is-invalid @enderror" id="tc_no" name="tc_no" value="{{ old('tc_no') }}" maxlength="11" required>
                                @error('tc_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="dogum_tarihi" class="form-label">Doğum Tarihi</label>
                                <input type="date" class="form-control" id="dogum_tarihi" name="dogum_tarihi" value="{{ old('dogum_tarihi') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="telefon" class="form-label">Telefon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('telefon') is-invalid @enderror" id="telefon" name="telefon" value="{{ old('telefon') }}" placeholder="05XX XXX XX XX" required>
                                @error('telefon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="eposta" class="form-label">E-Posta</label>
                                <input type="email" class="form-control" id="eposta" name="eposta" value="{{ old('eposta') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Adres ve Tarife Bilgileri --}}
            <div class="col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2 text-danger"></i>Adres Bilgileri</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="il" class="form-label">İl <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="il" name="il" value="{{ old('il') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="ilce" class="form-label">İlçe <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ilce" name="ilce" value="{{ old('ilce') }}" required>
                            </div>
                            <div class="col-12">
                                <label for="adres" class="form-label">Adres <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="adres" name="adres" rows="3" required>{{ old('adres') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-wifi me-2 text-success"></i>Tarife Bilgileri</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="tarife_id" class="form-label">Tarife <span class="text-danger">*</span></label>
                                <select class="form-select @error('tarife_id') is-invalid @enderror" id="tarife_id" name="tarife_id" required>
                                    <option value="">Tarife seçiniz</option>
                                    @foreach($tarifeler ?? [] as $tarife)
                                    <option value="{{ $tarife->id }}" {{ old('tarife_id') == $tarife->id ? 'selected' : '' }}>
                                        {{ $tarife->ad }} - ₺{{ number_format($tarife->fiyat, 2, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('tarife_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="not" class="form-label">Not</label>
                                <textarea class="form-control" id="not" name="not" rows="2">{{ old('not') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kaydet --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('basvurular.index') }}" class="btn btn-secondary">İptal</a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-1"></i> Başvuruyu Kaydet
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // TC doğrulaması
    $('#tc_no').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);
    });
});
</script>
@endpush
