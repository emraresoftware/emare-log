@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item active">Tüm Faturalar</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tüm Faturalar</h1>
        <div>
            <a href="{{ route('fatura.odeme_al') }}" class="btn btn-success"><i class="fas fa-money-bill-wave me-1"></i> Ödeme Al</a>
            <a href="{{ route('fatura.efatura') }}" class="btn btn-info text-white"><i class="fas fa-file-invoice me-1"></i> E-Faturalar</a>
        </div>
    </div>

    {{-- Özet Kartları --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Toplam Fatura</h6>
                            <h3 class="mb-0">{{ number_format($toplamFatura ?? 0) }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-file-invoice fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Ödenen</h6>
                            <h3 class="mb-0 text-success">{{ number_format($odenen ?? 0) }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Ödenmeyen</h6>
                            <h3 class="mb-0 text-danger">{{ number_format($odenmeyen ?? 0) }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Toplam Tutar</h6>
                            <h3 class="mb-0 text-info">₺{{ number_format($toplamTutar ?? 0, 2, ',', '.') }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-lira-sign fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtreler --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('fatura.index') }}" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Başlangıç Tarihi</label>
                    <input type="date" name="baslangic" class="form-control" value="{{ request('baslangic') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Bitiş Tarihi</label>
                    <input type="date" name="bitis" class="form-control" value="{{ request('bitis') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Durum</label>
                    <select name="durum" class="form-select">
                        <option value="">Tümü</option>
                        <option value="odendi" {{ request('durum') == 'odendi' ? 'selected' : '' }}>Ödendi</option>
                        <option value="odenmedi" {{ request('durum') == 'odenmedi' ? 'selected' : '' }}>Ödenmedi</option>
                        <option value="kismi" {{ request('durum') == 'kismi' ? 'selected' : '' }}>Kısmi Ödeme</option>
                        <option value="iptal" {{ request('durum') == 'iptal' ? 'selected' : '' }}>İptal</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Fatura Tipi</label>
                    <select name="tip" class="form-select">
                        <option value="">Tümü</option>
                        <option value="abonelik" {{ request('tip') == 'abonelik' ? 'selected' : '' }}>Abonelik</option>
                        <option value="kurulum" {{ request('tip') == 'kurulum' ? 'selected' : '' }}>Kurulum</option>
                        <option value="diger" {{ request('tip') == 'diger' ? 'selected' : '' }}>Diğer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filtrele</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('fatura.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-undo me-1"></i> Sıfırla</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Fatura Tablosu --}}
    <div class="table-card card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="faturalarTable">
                    <thead class="table-light">
                        <tr>
                            <th>Fatura No</th>
                            <th>Abone No</th>
                            <th>Müşteri</th>
                            <th>Tutar</th>
                            <th>Ödenen</th>
                            <th>Kalan</th>
                            <th>Durum</th>
                            <th>Fatura Tarihi</th>
                            <th>Son Ödeme</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faturalar ?? [] as $fatura)
                        <tr>
                            <td><strong>{{ $fatura->fatura_no }}</strong></td>
                            <td>{{ $fatura->abone_no }}</td>
                            <td>{{ $fatura->musteri->ad_soyad ?? '-' }}</td>
                            <td>₺{{ number_format($fatura->tutar, 2, ',', '.') }}</td>
                            <td class="text-success">₺{{ number_format($fatura->odenen, 2, ',', '.') }}</td>
                            <td class="text-danger">₺{{ number_format($fatura->kalan, 2, ',', '.') }}</td>
                            <td>
                                @if($fatura->durum == 'odendi')
                                    <span class="badge bg-success">Ödendi</span>
                                @elseif($fatura->durum == 'odenmedi')
                                    <span class="badge bg-danger">Ödenmedi</span>
                                @elseif($fatura->durum == 'kismi')
                                    <span class="badge bg-warning text-dark">Kısmi Ödeme</span>
                                @elseif($fatura->durum == 'iptal')
                                    <span class="badge bg-secondary">İptal</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($fatura->fatura_tarihi)->format('d.m.Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($fatura->son_odeme_tarihi)->format('d.m.Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        İşlemler
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('fatura.show', $fatura->id) }}"><i class="fas fa-eye me-2"></i>Detay</a></li>
                                        <li><a class="dropdown-item" href="{{ route('fatura.odeme_al', ['fatura_id' => $fatura->id]) }}"><i class="fas fa-money-bill me-2"></i>Ödeme Al</a></li>
                                        <li><a class="dropdown-item" href="{{ route('fatura.yazdir', $fatura->id) }}" target="_blank"><i class="fas fa-print me-2"></i>Yazdır</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="efaturaGonder({{ $fatura->id }})"><i class="fas fa-paper-plane me-2"></i>E-Fatura Gönder</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#" onclick="faturaIptal({{ $fatura->id }})">
                                                <i class="fas fa-ban me-2"></i>İptal Et
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($faturalar) && $faturalar->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $faturalar->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>

</div>

{{-- İptal Modal --}}
<div class="modal fade" id="iptalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fatura İptal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="iptalForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Bu faturayı iptal etmek istediğinize emin misiniz?</p>
                    <div class="mb-3">
                        <label class="form-label">İptal Nedeni</label>
                        <textarea name="iptal_nedeni" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-danger">İptal Et</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#faturalarTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            order: [[7, 'desc']],
            pageLength: 25
        });
    });

    function efaturaGonder(faturaId) {
        if (confirm('E-Fatura göndermek istediğinize emin misiniz?')) {
            $.post('/faturalar/' + faturaId + '/efatura-gonder', {_token: '{{ csrf_token() }}'}, function(response) {
                if (response.success) {
                    toastr.success('E-Fatura başarıyla gönderildi.');
                    location.reload();
                } else {
                    toastr.error(response.message || 'Bir hata oluştu.');
                }
            }).fail(function() {
                toastr.error('E-Fatura gönderilirken bir hata oluştu.');
            });
        }
    }

    function faturaIptal(faturaId) {
        $('#iptalForm').attr('action', '/faturalar/' + faturaId + '/iptal');
        new bootstrap.Modal(document.getElementById('iptalModal')).show();
    }
</script>
@endpush
@endsection
