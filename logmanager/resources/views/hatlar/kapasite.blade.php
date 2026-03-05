@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mikrotik.index') }}">Mikrotik</a></li>
            <li class="breadcrumb-item active">Hat Kapasiteleri</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-chart-bar text-info me-2"></i>Hat Kapasite Raporu</h1>
        <a href="{{ route('mikrotik.hat.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Hat Listesi
        </a>
    </div>

    {{-- Özet --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Toplam Hat</h6>
                            <h3 class="mb-0">{{ ($hatlar ?? collect())->count() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-network-wired fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Toplam Kapasite</h6>
                            <h3 class="mb-0">{{ ($hatlar ?? collect())->sum('kapasite') }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-database fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Kullanılan</h6>
                            <h3 class="mb-0 text-warning">{{ ($hatlar ?? collect())->sum('kullanilan') }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-users fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    @php
                        $toplamKapasite = ($hatlar ?? collect())->sum('kapasite');
                        $toplamKullanilan = ($hatlar ?? collect())->sum('kullanilan');
                        $genelDoluluk = $toplamKapasite > 0 ? round(($toplamKullanilan / $toplamKapasite) * 100, 1) : 0;
                    @endphp
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Genel Doluluk</h6>
                            <h3 class="mb-0 {{ $genelDoluluk > 90 ? 'text-danger' : ($genelDoluluk > 70 ? 'text-warning' : 'text-success') }}">%{{ $genelDoluluk }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-tachometer-alt fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hat Tablosu --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="kapasiteTable">
                    <thead class="table-light">
                        <tr>
                            <th>Hat Adı</th>
                            <th>Mikrotik</th>
                            <th>Hat Tipi</th>
                            <th>Kapasite</th>
                            <th>Kullanılan</th>
                            <th>Boş</th>
                            <th>Doluluk</th>
                            <th>Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hatlar ?? [] as $hat)
                        @php
                            $doluluk = $hat->kapasite > 0 ? round(($hat->kullanilan / $hat->kapasite) * 100, 1) : 0;
                            $bos = $hat->kapasite - $hat->kullanilan;
                            $barClass = $doluluk > 90 ? 'bg-danger' : ($doluluk > 70 ? 'bg-warning' : 'bg-success');
                        @endphp
                        <tr>
                            <td><strong>{{ $hat->ad }}</strong></td>
                            <td>
                                @if($hat->mikrotik)
                                    <a href="{{ route('mikrotik.show', $hat->mikrotik->id) }}">{{ $hat->mikrotik->ad }}</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $hat->hat_tipi ?? '-' }}</td>
                            <td>{{ $hat->kapasite }}</td>
                            <td>{{ $hat->kullanilan }}</td>
                            <td>
                                <span class="{{ $bos <= 5 ? 'text-danger fw-bold' : ($bos <= 20 ? 'text-warning' : 'text-success') }}">
                                    {{ $bos }}
                                </span>
                            </td>
                            <td style="min-width: 150px">
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 10px;">
                                        <div class="progress-bar {{ $barClass }}" style="width: {{ $doluluk }}%"></div>
                                    </div>
                                    <span class="fw-bold" style="min-width: 50px;">%{{ $doluluk }}</span>
                                </div>
                            </td>
                            <td>
                                @if($hat->aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Pasif</span>
                                @endif
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
    $('#kapasiteTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[6, 'desc']],
        pageLength: 50
    });
});
</script>
@endpush
@endsection
