@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mikrotik.index') }}">Mikrotik</a></li>
            <li class="breadcrumb-item active">Borçlu IP'ler</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-exclamation-circle text-danger me-2"></i>Borçlu IP'ler</h1>
        <a href="{{ route('mikrotik.ip.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> IP Listesine Dön
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="borcluIpTable">
                    <thead class="table-light">
                        <tr>
                            <th>IP Adresi</th>
                            <th>Müşteri</th>
                            <th>Abone No</th>
                            <th>Mikrotik</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ipler ?? [] as $ip)
                        <tr>
                            <td><code>{{ $ip->ip_adresi }}</code></td>
                            <td>
                                @if($ip->musteri)
                                    <a href="{{ route('musteri.show', $ip->musteri->id) }}">
                                        {{ $ip->musteri->isim }} {{ $ip->musteri->soyisim }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $ip->musteri->abone_no ?? '-' }}</td>
                            <td>{{ $ip->mikrotik->ad ?? '-' }}</td>
                            <td><span class="badge bg-danger"><i class="fas fa-ban me-1"></i>Borçtan Kapalı</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($ip->musteri)
                                    <a href="{{ route('musteri.show', $ip->musteri->id) }}" class="btn btn-outline-info" title="Müşteri Detay">
                                        <i class="fas fa-user"></i>
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

            @if(isset($ipler) && $ipler->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $ipler->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#borcluIpTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'asc']],
        pageLength: 25
    });
});
</script>
@endpush
@endsection
