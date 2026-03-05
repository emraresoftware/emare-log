@extends('layouts.app')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Online Müşteriler</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('anasayfa') }}">Ana Sayfa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('musteriler.index') }}">Müşteriler</a></li>
                <li class="breadcrumb-item active">Online Müşteriler</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Filtre --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('musteriler.online') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="mikrotik_id" class="form-label">Mikrotik</label>
                    <select class="form-select select2" id="mikrotik_id" name="mikrotik_id">
                        <option value="">Tüm Mikrotikler</option>
                        @foreach($mikrotikler ?? [] as $mikrotik)
                            <option value="{{ $mikrotik->id }}" {{ request('mikrotik_id') == $mikrotik->id ? 'selected' : '' }}>{{ $mikrotik->ad }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="arama" class="form-label">Arama</label>
                    <input type="text" class="form-control" id="arama" name="arama" value="{{ request('arama') }}" placeholder="Abone no, ad soyad, IP...">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i> Filtrele
                    </button>
                    <a href="{{ route('musteriler.online') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-1"></i> Sıfırla
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Özet --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-card-title">Online Müşteri Sayısı</div>
            <div class="stat-card-value text-success">{{ $onlineMusteriler->count() }}</div>
        </div>
    </div>
</div>

{{-- Tablo --}}
<div class="card table-card">
    <div class="card-body">
        @if($onlineMusteriler->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover" id="onlineTable">
                <thead>
                    <tr>
                        <th>Durum</th>
                        <th>Abone No</th>
                        <th>Ad Soyad</th>
                        <th>IP Adresi</th>
                        <th>Mikrotik</th>
                        <th>Bağlantı Süresi</th>
                        <th>Upload</th>
                        <th>Download</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($onlineMusteriler as $musteri)
                    <tr>
                        <td>
                            <span class="text-success"><i class="fas fa-circle"></i></span>
                        </td>
                        <td>{{ $musteri->abone_no }}</td>
                        <td>
                            <a href="{{ route('musteriler.show', $musteri->id) }}">
                                {{ $musteri->ad }} {{ $musteri->soyad }}
                            </a>
                        </td>
                        <td><code>{{ $musteri->ip_adresi }}</code></td>
                        <td>{{ $musteri->mikrotik->ad ?? '-' }}</td>
                        <td>{{ $musteri->baglanti_suresi ?? '-' }}</td>
                        <td>{{ $musteri->upload ?? '0 B' }}</td>
                        <td>{{ $musteri->download ?? '0 B' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('musteriler.show', $musteri->id) }}" class="btn btn-outline-primary" title="Detay">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-outline-danger" onclick="internetKes({{ $musteri->id }})" title="İnternet Kes">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-wifi fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Şu anda online müşteri bulunmuyor</h5>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({ theme: 'bootstrap-5', width: '100%' });

        $('#onlineTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            pageLength: 25,
            order: [[5, 'desc']]
        });
    });

    function internetKes(id) {
        Swal.fire({
            title: 'İnternet Kesme',
            text: 'Bu müşterinin internetini kesmek istediğinize emin misiniz?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Evet, Kes!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/musteriler/' + id + '/internet-toggle',
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        Swal.fire('Başarılı!', response.message, 'success').then(() => { location.reload(); });
                    },
                    error: function() {
                        Swal.fire('Hata!', 'İşlem sırasında bir hata oluştu.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
