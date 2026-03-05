@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">SMS Gönder</h1>
        <a href="{{ route('sms.rapor') }}" class="btn btn-outline-secondary">
            <i class="fas fa-chart-bar me-1"></i> SMS Raporları
        </a>
    </div>

    <div class="row g-4">
        {{-- SMS Gönderim Formu --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-paper-plane me-2 text-primary"></i>SMS Gönderimi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sms.gonder.post') }}" method="POST" id="smsForm">
                        @csrf

                        {{-- Gönderim Tipi --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Gönderim Tipi</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gonderim_tipi" id="tipTekli" value="tekli" checked>
                                    <label class="form-check-label" for="tipTekli">Tekli</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gonderim_tipi" id="tipToplu" value="toplu">
                                    <label class="form-check-label" for="tipToplu">Toplu</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gonderim_tipi" id="tipGrup" value="gruba">
                                    <label class="form-check-label" for="tipGrup">Gruba</label>
                                </div>
                            </div>
                        </div>

                        {{-- Tekli Gönderim --}}
                        <div id="tekliAlani">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="telefon_no" class="form-label">Telefon No</label>
                                    <input type="text" class="form-control" id="telefon_no" name="telefon" placeholder="05XX XXX XX XX">
                                </div>
                                <div class="col-md-6">
                                    <label for="musteri_sec" class="form-label">veya Müşteri Seç</label>
                                    <select class="form-select select2" id="musteri_sec" name="musteri_id">
                                        <option value="">Müşteri seçiniz</option>
                                        @foreach($musteriler ?? [] as $musteri)
                                        <option value="{{ $musteri->id }}" data-telefon="{{ $musteri->telefon }}">
                                            {{ $musteri->ad_soyad }} - {{ $musteri->telefon }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Toplu Gönderim --}}
                        <div id="topluAlani" class="d-none">
                            <div class="mb-3">
                                <label for="filtre" class="form-label">Filtre Seç</label>
                                <select class="form-select" id="filtre" name="filtre">
                                    <option value="">Seçiniz</option>
                                    <option value="tum_aktif">Tüm Aktif Müşteriler</option>
                                    <option value="borclu">Borçlu Müşteriler</option>
                                    <option value="bolge">Bölge Bazlı</option>
                                </select>
                            </div>
                            <div id="bolgeSec" class="mb-3 d-none">
                                <label for="bolge_id" class="form-label">Bölge</label>
                                <select class="form-select select2" id="bolge_id" name="bolge_id">
                                    <option value="">Bölge seçiniz</option>
                                    @foreach($bolgeler ?? [] as $bolge)
                                    <option value="{{ $bolge->id }}">{{ $bolge->ad }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Gruba Gönderim --}}
                        <div id="grupAlani" class="d-none">
                            <div class="mb-3">
                                <label for="grup_id" class="form-label">Müşteri Grubu</label>
                                <select class="form-select select2" id="grup_id" name="grup_id">
                                    <option value="">Grup seçiniz</option>
                                    @foreach($gruplar ?? [] as $grup)
                                    <option value="{{ $grup->id }}">{{ $grup->ad }} ({{ $grup->musteriler_count ?? 0 }} müşteri)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Şablon Seç --}}
                        <div class="mb-3">
                            <label for="sablon_sec" class="form-label">Şablon Seç</label>
                            <select class="form-select" id="sablon_sec" name="sablon_id">
                                <option value="">Şablon kullanmadan yaz</option>
                                @foreach($sablonlar ?? [] as $sablon)
                                <option value="{{ $sablon->id }}" data-mesaj="{{ $sablon->mesaj }}">{{ $sablon->ad }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Mesaj --}}
                        <div class="mb-3">
                            <label for="mesaj" class="form-label">Mesaj <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="mesaj" name="mesaj" rows="5" required maxlength="918">{{ $secilenSablon->mesaj ?? '' }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">
                                    Değişkenler:
                                    <span class="badge bg-light text-dark border cursor-pointer btn-tag" data-tag="{AD}">{AD}</span>
                                    <span class="badge bg-light text-dark border cursor-pointer btn-tag" data-tag="{SOYAD}">{SOYAD}</span>
                                    <span class="badge bg-light text-dark border cursor-pointer btn-tag" data-tag="{ABONE_NO}">{ABONE_NO}</span>
                                    <span class="badge bg-light text-dark border cursor-pointer btn-tag" data-tag="{BAKIYE}">{BAKIYE}</span>
                                </small>
                                <small class="text-muted"><span id="charCount">0</span>/918 karakter | <span id="smsCount">0</span> SMS</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-paper-plane me-2"></i> Gönder
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Önizleme --}}
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 1rem;">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-eye me-2 text-secondary"></i>Önizleme</h5>
                </div>
                <div class="card-body">
                    <div class="bg-light rounded p-3" style="min-height: 200px;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-sms text-primary me-2"></i>
                            <strong>SMS Mesajı</strong>
                        </div>
                        <hr>
                        <div id="mesajOnizleme" class="text-muted" style="white-space: pre-wrap;">
                            Mesajınızı yazın...
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted d-block"><i class="fas fa-info-circle me-1"></i>Gönderim tipi: <strong id="tipOnizleme">Tekli</strong></small>
                        <small class="text-muted d-block"><i class="fas fa-users me-1"></i>Alıcı sayısı: <strong id="aliciSayisi">1</strong></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.select2').select2({ theme: 'bootstrap-5' });

    // Gönderim tipi değişikliği
    $('input[name="gonderim_tipi"]').on('change', function() {
        var tip = $(this).val();
        $('#tekliAlani, #topluAlani, #grupAlani').addClass('d-none');
        if (tip === 'tekli') {
            $('#tekliAlani').removeClass('d-none');
            $('#tipOnizleme').text('Tekli');
        } else if (tip === 'toplu') {
            $('#topluAlani').removeClass('d-none');
            $('#tipOnizleme').text('Toplu');
        } else {
            $('#grupAlani').removeClass('d-none');
            $('#tipOnizleme').text('Gruba');
        }
    });

    // Filtre - Bölge seç göster/gizle
    $('#filtre').on('change', function() {
        if ($(this).val() === 'bolge') {
            $('#bolgeSec').removeClass('d-none');
        } else {
            $('#bolgeSec').addClass('d-none');
        }
    });

    // Müşteri seçildiğinde telefon doldur
    $('#musteri_sec').on('change', function() {
        var telefon = $(this).find(':selected').data('telefon');
        if (telefon) $('#telefon_no').val(telefon);
    });

    // Şablon seçildiğinde mesaj doldur
    $('#sablon_sec').on('change', function() {
        var mesaj = $(this).find(':selected').data('mesaj');
        if (mesaj) {
            $('#mesaj').val(mesaj);
            updatePreview();
            updateCharCount();
        }
    });

    // Değişken tag ekle
    $(document).on('click', '.btn-tag', function() {
        var tag = $(this).data('tag');
        var textarea = $('#mesaj');
        var cursorPos = textarea.prop('selectionStart');
        var text = textarea.val();
        textarea.val(text.substring(0, cursorPos) + tag + text.substring(cursorPos));
        textarea.focus();
        updatePreview();
        updateCharCount();
    });

    // Mesaj yazıldıkça güncelle
    $('#mesaj').on('input', function() {
        updatePreview();
        updateCharCount();
    });

    function updatePreview() {
        var mesaj = $('#mesaj').val() || 'Mesajınızı yazın...';
        $('#mesajOnizleme').text(mesaj);
    }

    function updateCharCount() {
        var len = $('#mesaj').val().length;
        $('#charCount').text(len);
        var smsCount = len === 0 ? 0 : Math.ceil(len / 160);
        $('#smsCount').text(smsCount);
    }
});
</script>
@endpush
