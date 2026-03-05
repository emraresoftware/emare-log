@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Genel Ayarlar</h1>
    </div>

    {{-- Sekmeler --}}
    <ul class="nav nav-tabs mb-4" id="ayarlarTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="firma-tab" data-bs-toggle="tab" data-bs-target="#firma" type="button" role="tab">
                <i class="fas fa-building me-1"></i> Firma Bilgileri
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="fatura-tab" data-bs-toggle="tab" data-bs-target="#fatura" type="button" role="tab">
                <i class="fas fa-file-invoice me-1"></i> Fatura Ayarları
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sms-tab" data-bs-toggle="tab" data-bs-target="#sms" type="button" role="tab">
                <i class="fas fa-sms me-1"></i> SMS Ayarları
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="efatura-tab" data-bs-toggle="tab" data-bs-target="#efatura" type="button" role="tab">
                <i class="fas fa-file-alt me-1"></i> E-Fatura
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sistem-tab" data-bs-toggle="tab" data-bs-target="#sistem" type="button" role="tab">
                <i class="fas fa-cog me-1"></i> Sistem
            </button>
        </li>
    </ul>

    <div class="tab-content" id="ayarlarTabContent">
        {{-- Firma Bilgileri --}}
        <div class="tab-pane fade show active" id="firma" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('ayar.guncelle') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="sekme" value="firma">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firma_adi" class="form-label">Firma Adı <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="firma_adi" name="firma_adi" value="{{ $ayarlar['firma_adi'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                @if(!empty($ayarlar['logo']))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $ayarlar['logo']) }}" alt="Logo" class="img-thumbnail" style="max-height: 60px;">
                                </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <label for="adres" class="form-label">Adres</label>
                                <textarea class="form-control" id="adres" name="adres" rows="2">{{ $ayarlar['adres'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="telefon" class="form-label">Telefon</label>
                                <input type="text" class="form-control" id="telefon" name="telefon" value="{{ $ayarlar['telefon'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label for="eposta" class="form-label">E-Posta</label>
                                <input type="email" class="form-control" id="eposta" name="eposta" value="{{ $ayarlar['eposta'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label for="web" class="form-label">Web Sitesi</label>
                                <input type="url" class="form-control" id="web" name="web" value="{{ $ayarlar['web'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="vergi_dairesi" class="form-label">Vergi Dairesi</label>
                                <input type="text" class="form-control" id="vergi_dairesi" name="vergi_dairesi" value="{{ $ayarlar['vergi_dairesi'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="vergi_no" class="form-label">Vergi No</label>
                                <input type="text" class="form-control" id="vergi_no" name="vergi_no" value="{{ $ayarlar['vergi_no'] ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Fatura Ayarları --}}
        <div class="tab-pane fade" id="fatura" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('ayar.guncelle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="sekme" value="fatura">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="fatura_prefix" class="form-label">Fatura Prefix</label>
                                <input type="text" class="form-control" id="fatura_prefix" name="fatura_prefix" value="{{ $ayarlar['fatura_prefix'] ?? 'INV' }}" placeholder="INV">
                            </div>
                            <div class="col-md-6">
                                <label for="sonraki_fatura_no" class="form-label">Sonraki Fatura No</label>
                                <input type="number" class="form-control" id="sonraki_fatura_no" name="sonraki_fatura_no" value="{{ $ayarlar['sonraki_fatura_no'] ?? 1 }}">
                            </div>
                            <div class="col-md-6">
                                <label for="kdv_orani" class="form-label">KDV Oranı (%)</label>
                                <input type="number" step="0.01" class="form-control" id="kdv_orani" name="kdv_orani" value="{{ $ayarlar['kdv_orani'] ?? 20 }}">
                            </div>
                            <div class="col-md-6">
                                <label for="son_odeme_gunu" class="form-label">Son Ödeme Günü</label>
                                <input type="number" class="form-control" id="son_odeme_gunu" name="son_odeme_gunu" value="{{ $ayarlar['son_odeme_gunu'] ?? 15 }}" min="1" max="28">
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- SMS Ayarları --}}
        <div class="tab-pane fade" id="sms" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('ayar.guncelle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="sekme" value="sms">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="sms_provider" class="form-label">SMS Provider</label>
                                <select class="form-select" id="sms_provider" name="sms_provider">
                                    <option value="">Seçiniz</option>
                                    <option value="netgsm" {{ ($ayarlar['sms_provider'] ?? '') == 'netgsm' ? 'selected' : '' }}>NetGSM</option>
                                    <option value="iletimerkezi" {{ ($ayarlar['sms_provider'] ?? '') == 'iletimerkezi' ? 'selected' : '' }}>İleti Merkezi</option>
                                    <option value="mutlucell" {{ ($ayarlar['sms_provider'] ?? '') == 'mutlucell' ? 'selected' : '' }}>Mutlucell</option>
                                    <option value="vatansms" {{ ($ayarlar['sms_provider'] ?? '') == 'vatansms' ? 'selected' : '' }}>Vatan SMS</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="sms_sender_id" class="form-label">Sender ID (Başlık)</label>
                                <input type="text" class="form-control" id="sms_sender_id" name="sms_sender_id" value="{{ $ayarlar['sms_sender_id'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="sms_api_key" class="form-label">API Key</label>
                                <input type="text" class="form-control" id="sms_api_key" name="sms_api_key" value="{{ $ayarlar['sms_api_key'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="sms_api_secret" class="form-label">API Secret</label>
                                <input type="password" class="form-control" id="sms_api_secret" name="sms_api_secret" value="{{ $ayarlar['sms_api_secret'] ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- E-Fatura --}}
        <div class="tab-pane fade" id="efatura" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('ayar.guncelle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="sekme" value="efatura">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="efatura_provider" class="form-label">E-Fatura Provider</label>
                                <select class="form-select" id="efatura_provider" name="efatura_provider">
                                    <option value="">Seçiniz</option>
                                    <option value="parasut" {{ ($ayarlar['efatura_provider'] ?? '') == 'parasut' ? 'selected' : '' }}>Paraşüt</option>
                                    <option value="logo" {{ ($ayarlar['efatura_provider'] ?? '') == 'logo' ? 'selected' : '' }}>Logo</option>
                                    <option value="kolaybi" {{ ($ayarlar['efatura_provider'] ?? '') == 'kolaybi' ? 'selected' : '' }}>KolayBi</option>
                                    <option value="bizimhesap" {{ ($ayarlar['efatura_provider'] ?? '') == 'bizimhesap' ? 'selected' : '' }}>BizimHesap</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="efatura_api_key" class="form-label">API Key</label>
                                <input type="text" class="form-control" id="efatura_api_key" name="efatura_api_key" value="{{ $ayarlar['efatura_api_key'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="efatura_api_secret" class="form-label">API Secret</label>
                                <input type="password" class="form-control" id="efatura_api_secret" name="efatura_api_secret" value="{{ $ayarlar['efatura_api_secret'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="efatura_firma_kodu" class="form-label">Firma Kodu</label>
                                <input type="text" class="form-control" id="efatura_firma_kodu" name="efatura_firma_kodu" value="{{ $ayarlar['efatura_firma_kodu'] ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sistem --}}
        <div class="tab-pane fade" id="sistem" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('ayar.guncelle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="sekme" value="sistem">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="dil" class="form-label">Dil</label>
                                <select class="form-select" id="dil" name="dil">
                                    <option value="tr" {{ ($ayarlar['dil'] ?? 'tr') == 'tr' ? 'selected' : '' }}>Türkçe</option>
                                    <option value="en" {{ ($ayarlar['dil'] ?? '') == 'en' ? 'selected' : '' }}>English</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="timezone" class="form-label">Timezone</label>
                                <select class="form-select" id="timezone" name="timezone">
                                    <option value="Europe/Istanbul" {{ ($ayarlar['timezone'] ?? 'Europe/Istanbul') == 'Europe/Istanbul' ? 'selected' : '' }}>Europe/Istanbul</option>
                                    <option value="UTC" {{ ($ayarlar['timezone'] ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="bakim_modu" class="form-label">Bakım Modu</label>
                                <select class="form-select" id="bakim_modu" name="bakim_modu">
                                    <option value="0" {{ ($ayarlar['bakim_modu'] ?? '0') == '0' ? 'selected' : '' }}>Kapalı</option>
                                    <option value="1" {{ ($ayarlar['bakim_modu'] ?? '') == '1' ? 'selected' : '' }}>Açık</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Dikkat:</strong> Bakım modunu açtığınızda admin hariç tüm kullanıcılar sisteme erişemez.
                            </div>
                        </div>
                        <div class="mt-2 text-end">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
