@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fatura.index') }}">Faturalar</a></li>
            <li class="breadcrumb-item active">E-Faturalar</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">E-Faturalar</h1>
        <button type="button" class="btn btn-primary" id="topluGonderBtn">
            <i class="fas fa-paper-plane me-1"></i> Toplu Gönder
        </button>
    </div>

    {{-- Filtreler --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('fatura.efatura') }}" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Başlangıç Tarihi</label>
                    <input type="date" name="baslangic" class="form-control" value="{{ request('baslangic') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Bitiş Tarihi</label>
                    <input type="date" name="bitis" class="form-control" value="{{ request('bitis') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">E-Fatura Durumu</label>
                    <select name="efatura_durum" class="form-select">
                        <option value="">Tümü</option>
                        <option value="gonderildi" {{ request('efatura_durum') == 'gonderildi' ? 'selected' : '' }}>Gönderildi</option>
                        <option value="gonderilmedi" {{ request('efatura_durum') == 'gonderilmedi' ? 'selected' : '' }}>Gönderilmedi</option>
                        <option value="hata" {{ request('efatura_durum') == 'hata' ? 'selected' : '' }}>Hata</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filtrele</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('fatura.efatura') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-undo me-1"></i> Sıfırla</a>
                </div>
            </form>
        </div>
    </div>

    {{-- E-Fatura Tablosu --}}
    <div class="table-card card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="efaturaTable">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="tumunuSec" class="form-check-input"></th>
                            <th>Fatura No</th>
                            <th>Müşteri</th>
                            <th>Tutar</th>
                            <th>E-Fatura Durumu</th>
                            <th>UUID</th>
                            <th>Gönderim Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($efaturalar ?? [] as $fatura)
                        <tr>
                            <td><input type="checkbox" class="form-check-input efatura-check" value="{{ $fatura->id }}"></td>
                            <td><strong>{{ $fatura->fatura_no }}</strong></td>
                            <td>{{ $fatura->musteri->ad_soyad ?? '-' }}</td>
                            <td>₺{{ number_format($fatura->tutar, 2, ',', '.') }}</td>
                            <td>
                                @if($fatura->efatura_durum == 'gonderildi')
                                    <span class="badge bg-success">Gönderildi</span>
                                @elseif($fatura->efatura_durum == 'gonderilmedi')
                                    <span class="badge bg-warning text-dark">Gönderilmedi</span>
                                @elseif($fatura->efatura_durum == 'hata')
                                    <span class="badge bg-danger">Hata</span>
                                @endif
                            </td>
                            <td><small class="text-muted">{{ $fatura->efatura_uuid ?? '-' }}</small></td>
                            <td>{{ $fatura->efatura_gonderim_tarihi ? \Carbon\Carbon::parse($fatura->efatura_gonderim_tarihi)->format('d.m.Y H:i') : '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('fatura.show', $fatura->id) }}" class="btn btn-outline-info" title="Detay">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($fatura->efatura_durum != 'gonderildi')
                                    <button type="button" class="btn btn-outline-primary" onclick="efaturaGonder({{ $fatura->id }})" title="Gönder">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                    @endif
                                    @if($fatura->efatura_uuid)
                                    <a href="{{ route('fatura.efatura.indir', $fatura->id) }}" class="btn btn-outline-success" title="İndir">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($efaturalar) && $efaturalar->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $efaturalar->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#efaturaTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            order: [[6, 'desc']],
            pageLength: 25
        });

        $('#tumunuSec').on('change', function() {
            $('.efatura-check').prop('checked', $(this).is(':checked'));
        });

        $('#topluGonderBtn').on('click', function() {
            let secilen = [];
            $('.efatura-check:checked').each(function() {
                secilen.push($(this).val());
            });
            if (secilen.length === 0) {
                toastr.warning('Lütfen en az bir fatura seçiniz.');
                return;
            }
            if (confirm(secilen.length + ' adet fatura için e-fatura gönderilecek. Devam etmek istiyor musunuz?')) {
                $.post('/faturalar/efatura/toplu-gonder', {
                    _token: '{{ csrf_token() }}',
                    fatura_ids: secilen
                }, function(response) {
                    if (response.success) {
                        toastr.success(response.message || 'E-Faturalar başarıyla gönderildi.');
                        location.reload();
                    } else {
                        toastr.error(response.message || 'Bir hata oluştu.');
                    }
                }).fail(function() {
                    toastr.error('İşlem sırasında bir hata oluştu.');
                });
            }
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
</script>
@endpush
@endsection
