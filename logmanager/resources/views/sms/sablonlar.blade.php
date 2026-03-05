@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">SMS Şablonları</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sablonEkleModal">
            <i class="fas fa-plus me-1"></i> Şablon Ekle
        </button>
    </div>

    {{-- Şablon Kartları --}}
    <div class="row g-3">
        @forelse($sablonlar ?? [] as $sablon)
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">
                        <i class="fas fa-envelope me-1 text-primary"></i> {{ $sablon->ad }}
                    </h5>
                    <p class="card-text text-muted flex-grow-1" style="font-size: 0.9rem;">
                        {{ Str::limit($sablon->mesaj, 120) }}
                    </p>
                    <div class="mt-2">
                        @if(str_contains($sablon->mesaj, '{AD}'))
                            <span class="badge bg-light text-dark border me-1 mb-1">{AD}</span>
                        @endif
                        @if(str_contains($sablon->mesaj, '{SOYAD}'))
                            <span class="badge bg-light text-dark border me-1 mb-1">{SOYAD}</span>
                        @endif
                        @if(str_contains($sablon->mesaj, '{ABONE_NO}'))
                            <span class="badge bg-light text-dark border me-1 mb-1">{ABONE_NO}</span>
                        @endif
                        @if(str_contains($sablon->mesaj, '{BAKIYE}'))
                            <span class="badge bg-light text-dark border me-1 mb-1">{BAKIYE}</span>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-transparent d-flex justify-content-between">
                    <a href="{{ route('sms.gonder', ['sablon' => $sablon->id]) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-paper-plane me-1"></i> Kullan
                    </a>
                    <div>
                        <button class="btn btn-sm btn-warning btn-sablon-duzenle" data-id="{{ $sablon->id }}" data-ad="{{ $sablon->ad }}" data-mesaj="{{ $sablon->mesaj }}" title="Düzenle">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('sms.sablon.destroy', $sablon->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu şablonu silmek istediğinize emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Sil"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center text-muted py-5">
                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                Henüz SMS şablonu bulunmamaktadır.
            </div>
        </div>
        @endforelse
    </div>
</div>

{{-- Şablon Ekle Modal --}}
<div class="modal fade" id="sablonEkleModal" tabindex="-1" aria-labelledby="sablonEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('sms.sablon.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="sablonEkleModalLabel">SMS Şablonu Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sablon_ad" class="form-label">Şablon Adı <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sablon_ad" name="ad" required>
                    </div>
                    <div class="mb-3">
                        <label for="sablon_mesaj" class="form-label">Mesaj <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="sablon_mesaj" name="mesaj" rows="5" required></textarea>
                        <div class="form-text">
                            Kullanılabilir değişkenler:
                            <span class="badge bg-secondary cursor-pointer me-1 btn-degisken" data-tag="{AD}">{AD}</span>
                            <span class="badge bg-secondary cursor-pointer me-1 btn-degisken" data-tag="{SOYAD}">{SOYAD}</span>
                            <span class="badge bg-secondary cursor-pointer me-1 btn-degisken" data-tag="{ABONE_NO}">{ABONE_NO}</span>
                            <span class="badge bg-secondary cursor-pointer btn-degisken" data-tag="{BAKIYE}">{BAKIYE}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Değişken etiketlerini tıkla-ekle
    $(document).on('click', '.btn-degisken', function() {
        var tag = $(this).data('tag');
        var textarea = $('#sablon_mesaj');
        var cursorPos = textarea.prop('selectionStart');
        var textBefore = textarea.val().substring(0, cursorPos);
        var textAfter = textarea.val().substring(cursorPos);
        textarea.val(textBefore + tag + textAfter);
        textarea.focus();
    });

    // Düzenle butonu
    $(document).on('click', '.btn-sablon-duzenle', function() {
        var id = $(this).data('id');
        var ad = $(this).data('ad');
        var mesaj = $(this).data('mesaj');
        $('#sablon_ad').val(ad);
        $('#sablon_mesaj').val(mesaj);
        $('#sablonEkleModal form').attr('action', '/sms/sablon/' + id);
        $('#sablonEkleModal form').append('<input type="hidden" name="_method" value="PUT">');
        $('#sablonEkleModalLabel').text('SMS Şablonu Düzenle');
        $('#sablonEkleModal').modal('show');
    });

    // Modal kapandığında formu sıfırla
    $('#sablonEkleModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('form').attr('action', '{{ route("sms.sablon.store") }}');
        $(this).find('input[name="_method"]').remove();
        $('#sablonEkleModalLabel').text('SMS Şablonu Ekle');
    });
});
</script>
@endpush
