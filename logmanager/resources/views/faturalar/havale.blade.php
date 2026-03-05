@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fatura.index') }}">Faturalar</a></li>
            <li class="breadcrumb-item active">Havale Bildirimleri</li>
        </ol>
    </nav>

    <h1 class="h3 mb-4">Havale Bildirimleri</h1>

    {{-- Havale Bildirimleri Tablosu --}}
    <div class="table-card card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="havaleTable">
                    <thead class="table-light">
                        <tr>
                            <th>Bildirim No</th>
                            <th>Müşteri</th>
                            <th>Tutar</th>
                            <th>Banka</th>
                            <th>Tarih</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($havaleler ?? [] as $havale)
                        <tr>
                            <td><strong>{{ $havale->bildirim_no }}</strong></td>
                            <td>{{ $havale->musteri->ad_soyad ?? '-' }}</td>
                            <td>₺{{ number_format($havale->tutar, 2, ',', '.') }}</td>
                            <td>{{ $havale->banka }}</td>
                            <td>{{ \Carbon\Carbon::parse($havale->tarih)->format('d.m.Y H:i') }}</td>
                            <td>
                                @if($havale->durum == 'beklemede')
                                    <span class="badge bg-warning text-dark">Beklemede</span>
                                @elseif($havale->durum == 'onaylandi')
                                    <span class="badge bg-success">Onaylandı</span>
                                @elseif($havale->durum == 'reddedildi')
                                    <span class="badge bg-danger">Reddedildi</span>
                                @endif
                            </td>
                            <td>
                                @if($havale->durum == 'beklemede')
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-success" onclick="havaleOnayla({{ $havale->id }})" title="Onayla">
                                        <i class="fas fa-check"></i> Onayla
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" onclick="havaleReddet({{ $havale->id }})" title="Reddet">
                                        <i class="fas fa-times"></i> Reddet
                                    </button>
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($havaleler) && $havaleler->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $havaleler->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>

</div>

{{-- Onay Modal --}}
<div class="modal fade" id="onayModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Havale Onayı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="onayForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Bu havale bildirimini onaylamak istediğinize emin misiniz?</p>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea name="aciklama" class="form-control" rows="3" placeholder="Onay açıklaması..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-success">Onayla</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Red Modal --}}
<div class="modal fade" id="redModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Havale Reddi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="redForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Bu havale bildirimini reddetmek istediğinize emin misiniz?</p>
                    <div class="mb-3">
                        <label class="form-label">Red Nedeni <span class="text-danger">*</span></label>
                        <textarea name="red_nedeni" class="form-control" rows="3" placeholder="Red nedeni..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-danger">Reddet</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#havaleTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            order: [[4, 'desc']],
            pageLength: 25
        });
    });

    function havaleOnayla(havaleId) {
        $('#onayForm').attr('action', '/havaleler/' + havaleId + '/onayla');
        new bootstrap.Modal(document.getElementById('onayModal')).show();
    }

    function havaleReddet(havaleId) {
        $('#redForm').attr('action', '/havaleler/' + havaleId + '/reddet');
        new bootstrap.Modal(document.getElementById('redModal')).show();
    }
</script>
@endpush
@endsection
