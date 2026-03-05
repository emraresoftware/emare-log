@extends('layouts.app')

@section('title', 'SMS Ayarları')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">SMS Ayarları</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('anasayfa') }}">Ana Sayfa</a></li>
                <li class="breadcrumb-item active">SMS Ayarları</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-cog me-2"></i>SMS Sağlayıcı Ayarları</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('sms.ayar_kaydet') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Sağlayıcı</label>
                    <select name="provider" class="form-select">
                        <option value="netgsm" {{ ($ayarlar->provider ?? '') == 'netgsm' ? 'selected' : '' }}>NetGSM</option>
                        <option value="iletimerkezi" {{ ($ayarlar->provider ?? '') == 'iletimerkezi' ? 'selected' : '' }}>İleti Merkezi</option>
                        <option value="mutlucell" {{ ($ayarlar->provider ?? '') == 'mutlucell' ? 'selected' : '' }}>Mutlucell</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Gönderici ID (Başlık)</label>
                    <input type="text" name="sender_id" class="form-control" value="{{ $ayarlar->sender_id ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">API Key</label>
                    <input type="text" name="api_key" class="form-control" value="{{ $ayarlar->api_key ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">API Secret</label>
                    <input type="password" name="api_secret" class="form-control" value="{{ $ayarlar->api_secret ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kullanıcı Adı</label>
                    <input type="text" name="kullanici_adi" class="form-control" value="{{ $ayarlar->kullanici_adi ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="aktif" value="1" {{ ($ayarlar->aktif ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label">Aktif</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Kaydet</button>
        </form>
    </div>
</div>
@endsection
