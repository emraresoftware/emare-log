@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mikrotik.index') }}">Mikrotik</a></li>
            <li class="breadcrumb-item active">Hata Raporu</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Mikrotik Hata Raporu</h1>
        <a href="{{ route('mikrotik.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Mikrotik Listesi
        </a>
    </div>

    {{-- Özet --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-danger border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Toplam Hata</h6>
                            <h3 class="mb-0 text-danger">{{ $hatalar->total() ?? 0 }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-bug fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-warning border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Bugünkü Hatalar</h6>
                            <h3 class="mb-0 text-warning">{{ $hatalar->filter(fn($h) => $h->created_at >= now()->startOfDay())->count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-info border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Etkilenen Cihaz</h6>
                            <h3 class="mb-0 text-info">{{ $hatalar->pluck('mikrotik_id')->unique()->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-server fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hata Tablosu --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="hataRaporuTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px">#</th>
                            <th>Cihaz</th>
                            <th>Seviye</th>
                            <th>Mesaj</th>
                            <th>Tarih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hatalar ?? [] as $hata)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $hata->id }}</span></td>
                            <td>
                                @if($hata->mikrotik)
                                    <a href="{{ route('mikrotik.show', $hata->mikrotik->id) }}">
                                        <i class="fas fa-server me-1"></i>{{ $hata->mikrotik->ad }}
                                    </a>
                                    <br><small class="text-muted">{{ $hata->mikrotik->ip_adresi }}</small>
                                @else
                                    <span class="text-muted">Bilinmeyen Cihaz</span>
                                @endif
                            </td>
                            <td><span class="badge bg-danger">{{ $hata->seviye ?? 'hata' }}</span></td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 400px;" title="{{ $hata->mesaj }}">
                                    {{ $hata->mesaj }}
                                </span>
                            </td>
                            <td><small>{{ $hata->created_at?->format('d.m.Y H:i:s') }}</small></td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($hatalar) && $hatalar->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $hatalar->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#hataRaporuTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[4, 'desc']],
        pageLength: 25
    });
});
</script>
@endpush
@endsection
