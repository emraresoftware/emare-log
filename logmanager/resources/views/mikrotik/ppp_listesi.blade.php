@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mikrotik.index') }}">Mikrotik</a></li>
            <li class="breadcrumb-item active">PPP Listesi</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-key text-primary me-2"></i>PPP Secret Listesi</h1>
        <div>
            <button class="btn btn-success" onclick="pppSenkronize()">
                <i class="fas fa-sync-alt me-1"></i> Mikrotik'ten Çek
            </button>
            <a href="{{ route('mikrotik.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Mikrotik Listesi
            </a>
        </div>
    </div>

    {{-- Filtre --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Mikrotik</label>
                    <select name="mikrotik_id" class="form-select">
                        <option value="">Tüm Cihazlar</option>
                        @foreach($pppKullanicilar ?? [] as $mk)
                            <option value="{{ $mk->id }}" {{ request('mikrotik_id') == $mk->id ? 'selected' : '' }}>
                                {{ $mk->ad }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Arama</label>
                    <input type="text" name="arama" class="form-control" placeholder="Kullanıcı adı ara..." value="{{ request('arama') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Ara</button>
                </div>
            </form>
        </div>
    </div>

    {{-- PPP Tablosu --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="pppTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Mikrotik</th>
                            <th>IP Adresi</th>
                            <th>PPP Kullanıcı Sayısı</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pppKullanicilar ?? [] as $mk)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $mk->id }}</span></td>
                            <td>
                                <a href="{{ route('mikrotik.show', $mk->id) }}">
                                    <strong>{{ $mk->ad }}</strong>
                                </a>
                            </td>
                            <td><code>{{ $mk->ip_adresi }}</code></td>
                            <td><span class="badge bg-info">{{ $mk->kullanici_sayisi ?? 0 }}</span></td>
                            <td>
                                @if($mk->durum == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($mk->durum == 'hata')
                                    <span class="badge bg-danger">Hata</span>
                                @else
                                    <span class="badge bg-secondary">Pasif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('mikrotik.show', $mk->id) }}" class="btn btn-outline-info" title="PPP Detay">
                                        <i class="fas fa-list"></i>
                                    </a>
                                    <button class="btn btn-outline-success" onclick="pppCihazSenkronize({{ $mk->id }})" title="PPP Çek">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#pppTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'asc']],
        pageLength: 25
    });
});

function pppSenkronize() {
    Swal.fire({
        title: 'PPP Senkronizasyonu',
        text: 'Tüm Mikrotik cihazlarından PPP Secret listesi çekilecek. Devam etmek istiyor musunuz?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Evet, Çek',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            toastr.info('PPP Secret listesi çekiliyor...');
        }
    });
}

function pppCihazSenkronize(mikrotikId) {
    toastr.info('Cihazdan PPP Secret listesi çekiliyor...');
}
</script>
@endpush
@endsection
