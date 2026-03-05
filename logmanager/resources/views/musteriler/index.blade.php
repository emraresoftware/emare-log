@extends('layouts.app')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Müşteriler</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('anasayfa') }}">Ana Sayfa</a></li>
                <li class="breadcrumb-item active">Müşteriler</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('musteriler.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Müşteri Ekle
        </a>
        <a href="{{ route('musteriler.export.excel') }}" class="btn btn-outline-success">
            <i class="fas fa-file-excel me-1"></i> Excel Export
        </a>
        <a href="{{ route('musteriler.export.pdf') }}" class="btn btn-outline-danger">
            <i class="fas fa-file-pdf me-1"></i> PDF Export
        </a>
    </div>
</div>

{{-- Filtre Alanı --}}
@include('partials.musteri_filters')

{{-- Özet Kartları --}}
<div class="row mb-4">
    <div class="col-md-2">
        <div class="stat-card">
            <div class="stat-card-title">Toplam Müşteri</div>
            <div class="stat-card-value">{{ $musteriler->total() ?? $musteriler->count() }}</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card">
            <div class="stat-card-title">Aktif</div>
            <div class="stat-card-value text-success">{{ $aktifSayisi ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card">
            <div class="stat-card-title">Pasif</div>
            <div class="stat-card-value text-warning">{{ $pasifSayisi ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card">
            <div class="stat-card-title">İptal</div>
            <div class="stat-card-value text-danger">{{ $iptalSayisi ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card">
            <div class="stat-card-title">Dondurulmuş</div>
            <div class="stat-card-value text-info">{{ $dondurulmusSayisi ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card">
            <div class="stat-card-title">Potansiyel</div>
            <div class="stat-card-value text-secondary">{{ $potansiyelSayisi ?? 0 }}</div>
        </div>
    </div>
</div>

{{-- Müşteri Tablosu --}}
<div class="card table-card">
    <div class="card-body">
        @if($musteriler->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover" id="musterilerTable">
                <thead>
                    <tr>
                        <th>Abone No</th>
                        <th>Ad Soyad / Ünvan</th>
                        <th>TC / Vergi No</th>
                        <th>Tarife</th>
                        <th>Durum</th>
                        <th>Bölge</th>
                        <th>IP</th>
                        <th>Bakiye</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($musteriler as $musteri)
                    <tr>
                        <td>{{ $musteri->abone_no }}</td>
                        <td>
                            <a href="{{ route('musteriler.show', $musteri->id) }}">
                                @if($musteri->musteri_tipi === 'kurumsal')
                                    {{ $musteri->firma_unvani }}
                                @else
                                    {{ $musteri->ad }} {{ $musteri->soyad }}
                                @endif
                            </a>
                        </td>
                        <td>
                            @if($musteri->musteri_tipi === 'kurumsal')
                                {{ $musteri->vergi_no }}
                            @else
                                {{ $musteri->tc_kimlik_no }}
                            @endif
                        </td>
                        <td>{{ $musteri->tarife->ad ?? '-' }}</td>
                        <td>
                            @switch($musteri->durum)
                                @case('aktif')
                                    <span class="badge status-aktif">Aktif</span>
                                    @break
                                @case('pasif')
                                    <span class="badge status-pasif">Pasif</span>
                                    @break
                                @case('iptal')
                                    <span class="badge status-iptal">İptal</span>
                                    @break
                                @case('dondurulmus')
                                    <span class="badge status-dondurulmus">Dondurulmuş</span>
                                    @break
                                @case('potansiyel')
                                    <span class="badge status-potansiyel">Potansiyel</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $musteri->durum }}</span>
                            @endswitch
                        </td>
                        <td>{{ $musteri->bolge->ad ?? '-' }}</td>
                        <td>{{ $musteri->ip_adresi ?? '-' }}</td>
                        <td>
                            <span class="{{ $musteri->bakiye >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($musteri->bakiye, 2, ',', '.') }} ₺
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('musteriler.show', $musteri->id) }}">
                                            <i class="fas fa-eye me-2"></i> Detay
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('musteriler.edit', $musteri->id) }}">
                                            <i class="fas fa-edit me-2"></i> Düzenle
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('faturalar.create', ['musteri_id' => $musteri->id]) }}">
                                            <i class="fas fa-file-invoice me-2"></i> Fatura Kes
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('sms.create', ['musteri_id' => $musteri->id]) }}">
                                            <i class="fas fa-sms me-2"></i> SMS Gönder
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="internetToggle({{ $musteri->id }}, '{{ $musteri->durum }}')">
                                            @if($musteri->durum === 'aktif')
                                                <i class="fas fa-ban me-2 text-danger"></i> İnternet Kes
                                            @else
                                                <i class="fas fa-check-circle me-2 text-success"></i> İnternet Aç
                                            @endif
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" onclick="musteriSil({{ $musteri->id }})">
                                            <i class="fas fa-trash me-2"></i> Sil
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $musteriler->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-users fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Henüz müşteri kaydı bulunmuyor</h5>
            <p class="text-muted">Yeni müşteri eklemek için yukarıdaki "Müşteri Ekle" butonunu kullanabilirsiniz.</p>
            <a href="{{ route('musteriler.create') }}" class="btn btn-success mt-2">
                <i class="fas fa-plus me-1"></i> Müşteri Ekle
            </a>
        </div>
        @endif
    </div>
</div>

{{-- Silme Formu (Gizli) --}}
<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#musterilerTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json'
            },
            pageLength: 25,
            ordering: true,
            searching: false,
            paging: false,
            info: false
        });
    });

    function musteriSil(id) {
        Swal.fire({
            title: 'Emin misiniz?',
            text: 'Bu müşteri kaydı kalıcı olarak silinecektir!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Evet, Sil!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.getElementById('deleteForm');
                form.action = '/musteriler/' + id;
                form.submit();
            }
        });
    }

    function internetToggle(id, durum) {
        let eylem = durum === 'aktif' ? 'kapatmak' : 'açmak';
        Swal.fire({
            title: 'İnternet ' + (durum === 'aktif' ? 'Kesme' : 'Açma'),
            text: 'Bu müşterinin internetini ' + eylem + ' istediğinize emin misiniz?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: durum === 'aktif' ? '#d33' : '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Evet, ' + (durum === 'aktif' ? 'Kes' : 'Aç') + '!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/musteriler/' + id + '/internet-toggle',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire('Başarılı!', response.message, 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Hata!', 'İşlem sırasında bir hata oluştu.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
