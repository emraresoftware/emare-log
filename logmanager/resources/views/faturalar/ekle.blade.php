@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fatura.index') }}">Faturalar</a></li>
            <li class="breadcrumb-item active">Fatura Ekle</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-plus-circle me-2"></i>Yeni Fatura Ekle</h1>
        <a href="{{ route('fatura.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Geri Dön
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('fatura.index') }}" method="POST">
                @csrf

                <div class="row g-3">
                    {{-- Müşteri Seçimi --}}
                    <div class="col-md-6">
                        <label for="musteri_id" class="form-label">Müşteri <span class="text-danger">*</span></label>
                        <select class="form-select select2" id="musteri_id" name="musteri_id" required>
                            <option value="">Müşteri Seçin</option>
                            @foreach($musteriler as $musteri)
                                <option value="{{ $musteri->id }}">{{ $musteri->abone_no }} - {{ $musteri->isim }} {{ $musteri->soyisim }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tarife Seçimi --}}
                    <div class="col-md-6">
                        <label for="tarife_id" class="form-label">Tarife</label>
                        <select class="form-select" id="tarife_id" name="tarife_id">
                            <option value="">Tarife Seçin</option>
                            @foreach($tarifeler as $tarife)
                                <option value="{{ $tarife->id }}" data-fiyat="{{ $tarife->fiyat }}">{{ $tarife->ad }} - {{ number_format($tarife->fiyat, 2) }} ₺</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Fatura Tarihi --}}
                    <div class="col-md-4">
                        <label for="fatura_tarihi" class="form-label">Fatura Tarihi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="fatura_tarihi" name="fatura_tarihi" value="{{ date('Y-m-d') }}" required>
                    </div>

                    {{-- Son Ödeme Tarihi --}}
                    <div class="col-md-4">
                        <label for="son_odeme_tarihi" class="form-label">Son Ödeme Tarihi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="son_odeme_tarihi" name="son_odeme_tarihi" value="{{ date('Y-m-d', strtotime('+15 days')) }}" required>
                    </div>

                    {{-- Tutar --}}
                    <div class="col-md-4">
                        <label for="tutar" class="form-label">Tutar (₺) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" id="tutar" name="tutar" placeholder="0.00" required>
                    </div>

                    {{-- KDV --}}
                    <div class="col-md-3">
                        <label for="kdv_orani" class="form-label">KDV Oranı (%)</label>
                        <select class="form-select" id="kdv_orani" name="kdv_orani">
                            <option value="0">%0</option>
                            <option value="1">%1</option>
                            <option value="10">%10</option>
                            <option value="20" selected>%20</option>
                        </select>
                    </div>

                    {{-- Fatura Tipi --}}
                    <div class="col-md-3">
                        <label for="tip" class="form-label">Fatura Tipi</label>
                        <select class="form-select" id="tip" name="tip">
                            <option value="aylik">Aylık Abonelik</option>
                            <option value="kurulum">Kurulum</option>
                            <option value="cihaz">Cihaz</option>
                            <option value="diger">Diğer</option>
                        </select>
                    </div>

                    {{-- Durum --}}
                    <div class="col-md-3">
                        <label for="durum" class="form-label">Durum</label>
                        <select class="form-select" id="durum" name="durum">
                            <option value="bekliyor">Bekliyor</option>
                            <option value="odendi">Ödendi</option>
                            <option value="gecikti">Gecikti</option>
                            <option value="iptal">İptal</option>
                        </select>
                    </div>

                    {{-- Ödeme Yöntemi --}}
                    <div class="col-md-3">
                        <label for="odeme_yontemi" class="form-label">Ödeme Yöntemi</label>
                        <select class="form-select" id="odeme_yontemi" name="odeme_yontemi">
                            <option value="">Seçiniz</option>
                            <option value="nakit">Nakit</option>
                            <option value="havale">Havale/EFT</option>
                            <option value="kredi_karti">Kredi Kartı</option>
                            <option value="otomatik">Otomatik Çekim</option>
                        </select>
                    </div>

                    {{-- Açıklama --}}
                    <div class="col-12">
                        <label for="aciklama" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="aciklama" name="aciklama" rows="3" placeholder="Opsiyonel açıklama..."></textarea>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('fatura.index') }}" class="btn btn-light">İptal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Fatura Oluştur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.select2').select2({ theme: 'bootstrap-5', placeholder: 'Müşteri Seçin', allowClear: true });

    $('#tarife_id').on('change', function() {
        var fiyat = $(this).find(':selected').data('fiyat');
        if (fiyat) {
            $('#tutar').val(parseFloat(fiyat).toFixed(2));
        }
    });
});
</script>
@endpush
@endsection
