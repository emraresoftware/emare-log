@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fatura.index') }}">Faturalar</a></li>
            <li class="breadcrumb-item active">Ödeme Al</li>
        </ol>
    </nav>

    <h1 class="h3 mb-4">Ödeme Al</h1>

    {{-- Müşteri Arama --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0"><i class="fas fa-search me-2"></i>Müşteri Ara</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Abone No veya TC Kimlik No</label>
                    <input type="text" id="musteriArama" class="form-control" placeholder="Abone No veya TC No giriniz...">
                </div>
                <div class="col-md-2">
                    <button type="button" id="araBtn" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Ara
                    </button>
                </div>
            </div>
            <div id="aramaSONuclari" class="mt-3" style="display: none;">
                <div class="list-group" id="musteriListesi"></div>
            </div>
        </div>
    </div>

    {{-- Müşteri Bilgileri & Ödeme Formu (gizli, seçim sonrası görünür) --}}
    <div id="odemeSection" style="display: none;">

        {{-- Müşteri Bilgi Kartı --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0"><i class="fas fa-user me-2"></i>Müşteri Bilgileri</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <p class="mb-1"><strong>Ad Soyad:</strong> <span id="musteriAd"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1"><strong>Abone No:</strong> <span id="musteriAboneNo"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1"><strong>Bakiye:</strong> <span id="musteriBakiye" class="fw-bold"></span></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ödenmemiş Faturalar --}}
        <div class="table-card card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0"><i class="fas fa-file-invoice me-2"></i>Ödenmemiş Faturalar</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" id="tumunuSec" class="form-check-input"></th>
                                <th>Fatura No</th>
                                <th>Fatura Tarihi</th>
                                <th>Son Ödeme</th>
                                <th>Tutar</th>
                                <th>Ödenen</th>
                                <th>Kalan</th>
                            </tr>
                        </thead>
                        <tbody id="faturaListesi">
                            {{-- Ajax ile doldurulacak --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Ödeme Formu --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0"><i class="fas fa-money-bill-wave me-2"></i>Ödeme Bilgileri</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('fatura.odeme_al.store') }}" id="odemeForm">
                    @csrf
                    <input type="hidden" name="musteri_id" id="musteriId">
                    <input type="hidden" name="secilen_faturalar" id="secilenFaturalar">

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Toplam Seçilen</label>
                            <div class="input-group">
                                <span class="input-group-text">₺</span>
                                <input type="text" id="toplamSecilen" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Ödeme Tutarı <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₺</span>
                                <input type="number" step="0.01" name="tutar" id="odemeTutari" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Ödeme Yöntemi <span class="text-danger">*</span></label>
                            <select name="odeme_yontemi" class="form-select" required>
                                <option value="">Seçiniz</option>
                                <option value="nakit">Nakit</option>
                                <option value="havale">Havale / EFT</option>
                                <option value="kredi_karti">Kredi Kartı</option>
                                <option value="pos">POS</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Makbuz No</label>
                            <input type="text" name="makbuz_no" class="form-control" placeholder="Makbuz numarası">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Açıklama</label>
                            <textarea name="aciklama" class="form-control" rows="2" placeholder="Ödeme ile ilgili açıklama..."></textarea>
                        </div>
                    </div>

                    {{-- Özet --}}
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="alert alert-info mb-0">
                                <div class="d-flex justify-content-between">
                                    <span>Toplam Seçilen:</span>
                                    <strong id="ozetToplamSecilen">₺0,00</strong>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between">
                                    <span>Ödeme Tutarı:</span>
                                    <strong id="ozetOdemeTutari">₺0,00</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-end justify-content-end">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle me-2"></i>Ödeme Al
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Müşteri Arama
        $('#araBtn').on('click', function() {
            let query = $('#musteriArama').val().trim();
            if (query.length < 2) {
                toastr.warning('En az 2 karakter giriniz.');
                return;
            }

            $.get('/api/musteri-ara', {q: query}, function(data) {
                if (data.length === 0) {
                    $('#musteriListesi').html('<div class="list-group-item text-muted">Sonuç bulunamadı.</div>');
                } else {
                    let html = '';
                    data.forEach(function(m) {
                        html += '<a href="#" class="list-group-item list-group-item-action musteri-sec" ' +
                                'data-id="' + m.id + '" data-ad="' + m.ad_soyad + '" ' +
                                'data-abone="' + m.abone_no + '" data-bakiye="' + m.bakiye + '">' +
                                '<strong>' + m.ad_soyad + '</strong> - Abone: ' + m.abone_no +
                                ' - Bakiye: ₺' + parseFloat(m.bakiye).toLocaleString('tr-TR', {minimumFractionDigits: 2}) +
                                '</a>';
                    });
                    $('#musteriListesi').html(html);
                }
                $('#aramaSONuclari').show();
            });
        });

        // Enter ile arama
        $('#musteriArama').on('keypress', function(e) {
            if (e.which === 13) $('#araBtn').click();
        });

        // Müşteri Seçim
        $(document).on('click', '.musteri-sec', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let ad = $(this).data('ad');
            let abone = $(this).data('abone');
            let bakiye = $(this).data('bakiye');

            $('#musteriId').val(id);
            $('#musteriAd').text(ad);
            $('#musteriAboneNo').text(abone);
            $('#musteriBakiye').text('₺' + parseFloat(bakiye).toLocaleString('tr-TR', {minimumFractionDigits: 2}));
            $('#aramaSONuclari').hide();

            // Ödenmemiş faturaları getir
            $.get('/api/musteri/' + id + '/odenmemis-faturalar', function(faturalar) {
                let html = '';
                faturalar.forEach(function(f) {
                    html += '<tr>' +
                        '<td><input type="checkbox" class="form-check-input fatura-check" data-kalan="' + f.kalan + '" value="' + f.id + '"></td>' +
                        '<td>' + f.fatura_no + '</td>' +
                        '<td>' + f.fatura_tarihi + '</td>' +
                        '<td>' + f.son_odeme_tarihi + '</td>' +
                        '<td>₺' + parseFloat(f.tutar).toLocaleString('tr-TR', {minimumFractionDigits: 2}) + '</td>' +
                        '<td>₺' + parseFloat(f.odenen).toLocaleString('tr-TR', {minimumFractionDigits: 2}) + '</td>' +
                        '<td class="text-danger fw-bold">₺' + parseFloat(f.kalan).toLocaleString('tr-TR', {minimumFractionDigits: 2}) + '</td>' +
                        '</tr>';
                });
                if (faturalar.length === 0) {
                    html = '<tr><td colspan="7" class="text-center text-muted">Ödenmemiş fatura bulunamadı.</td></tr>';
                }
                $('#faturaListesi').html(html);
                $('#odemeSection').show();
            });
        });

        // Tümünü Seç
        $('#tumunuSec').on('change', function() {
            $('.fatura-check').prop('checked', $(this).is(':checked'));
            toplamHesapla();
        });

        // Fatura seçimi değiştiğinde
        $(document).on('change', '.fatura-check', function() {
            toplamHesapla();
        });

        // Ödeme tutarı değiştiğinde
        $('#odemeTutari').on('input', function() {
            let val = parseFloat($(this).val()) || 0;
            $('#ozetOdemeTutari').text('₺' + val.toLocaleString('tr-TR', {minimumFractionDigits: 2}));
        });

        // Form gönderimi
        $('#odemeForm').on('submit', function() {
            let secilen = [];
            $('.fatura-check:checked').each(function() {
                secilen.push($(this).val());
            });
            $('#secilenFaturalar').val(JSON.stringify(secilen));
        });

        function toplamHesapla() {
            let toplam = 0;
            $('.fatura-check:checked').each(function() {
                toplam += parseFloat($(this).data('kalan'));
            });
            $('#toplamSecilen').val(toplam.toLocaleString('tr-TR', {minimumFractionDigits: 2}));
            $('#odemeTutari').val(toplam.toFixed(2));
            $('#ozetToplamSecilen').text('₺' + toplam.toLocaleString('tr-TR', {minimumFractionDigits: 2}));
            $('#ozetOdemeTutari').text('₺' + toplam.toLocaleString('tr-TR', {minimumFractionDigits: 2}));
        }
    });
</script>
@endpush
@endsection
