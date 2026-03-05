@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Kullanıcı Ekle</h1>
        <a href="{{ route('bayi.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Geri Dön
        </a>
    </div>

    <form action="{{ route('bayi.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            {{-- Kullanıcı Bilgileri --}}
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2 text-primary"></i>Kullanıcı Bilgileri</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Kullanıcı Adı <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-Posta <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Şifre <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Şifre Tekrar <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
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
                                <label for="telefon" class="form-label">Telefon</label>
                                <input type="text" class="form-control" id="telefon" name="telefon" value="{{ old('telefon') }}" placeholder="05XX XXX XX XX">
                            </div>
                            <div class="col-md-6">
                                <label for="bolge_id" class="form-label">Bölge</label>
                                <select class="form-select select2" id="bolge_id" name="bolge_id">
                                    <option value="">Bölge seçiniz</option>
                                    @foreach($bolgeler ?? [] as $bolge)
                                    <option value="{{ $bolge->id }}" {{ old('bolge_id') == $bolge->id ? 'selected' : '' }}>{{ $bolge->ad }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="rol" class="form-label">Rol <span class="text-danger">*</span></label>
                                <select class="form-select @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                                    <option value="">Seçiniz</option>
                                    <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="bayi" {{ old('rol') == 'bayi' ? 'selected' : '' }}>Bayi</option>
                                    <option value="personel" {{ old('rol') == 'personel' ? 'selected' : '' }}>Personel</option>
                                    <option value="tekniker" {{ old('rol') == 'tekniker' ? 'selected' : '' }}>Tekniker</option>
                                </select>
                                @error('rol')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="durum" class="form-label">Durum</label>
                                <select class="form-select" id="durum" name="durum">
                                    <option value="1" {{ old('durum', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('durum') == '0' ? 'selected' : '' }}>Pasif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Yetkiler --}}
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-shield-alt me-2 text-warning"></i>Yetkiler</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $yetkiler = [
                                'musteri_goruntule' => 'Müşteri Görüntüle',
                                'musteri_ekle' => 'Müşteri Ekle',
                                'musteri_duzenle' => 'Müşteri Düzenle',
                                'fatura_kes' => 'Fatura Kes',
                                'odeme_al' => 'Ödeme Al',
                                'mikrotik_yonet' => 'Mikrotik Yönet',
                                'rapor_goruntule' => 'Rapor Görüntüle',
                                'ayar_degistir' => 'Ayar Değiştir',
                                'stok_yonet' => 'Stok Yönet',
                                'kasa_yonet' => 'Kasa Yönet',
                                'sms_gonder' => 'SMS Gönder',
                                'teknik_servis' => 'Teknik Servis',
                                'kullanici_yonet' => 'Kullanıcı Yönet',
                                'log_goruntule' => 'Log Görüntüle',
                            ];
                        @endphp

                        <div class="mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tumYetkiler">
                                <label class="form-check-label fw-bold" for="tumYetkiler">Tüm Yetkiler</label>
                            </div>
                        </div>
                        <hr>
                        <div class="row g-2">
                            @foreach($yetkiler as $key => $label)
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input yetki-checkbox" type="checkbox" id="yetki_{{ $key }}" name="yetkiler[]" value="{{ $key }}"
                                        {{ in_array($key, old('yetkiler', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="yetki_{{ $key }}">{{ $label }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kaydet --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('bayi.index') }}" class="btn btn-secondary">İptal</a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-1"></i> Kaydet
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
    $('.select2').select2({ theme: 'bootstrap-5' });

    // Tüm yetkiler checkbox
    $('#tumYetkiler').on('change', function() {
        $('.yetki-checkbox').prop('checked', $(this).is(':checked'));
    });

    $('.yetki-checkbox').on('change', function() {
        if (!$(this).is(':checked')) {
            $('#tumYetkiler').prop('checked', false);
        }
        if ($('.yetki-checkbox:checked').length === $('.yetki-checkbox').length) {
            $('#tumYetkiler').prop('checked', true);
        }
    });
});
</script>
@endpush
