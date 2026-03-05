@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mikrotik.index') }}">Mikrotik</a></li>
            <li class="breadcrumb-item active">IP Hatalı Hatlar</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-exclamation-circle text-warning me-2"></i>IP Hatalı Hatlar</h1>
        <a href="{{ route('mikrotik.hat.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Hat Listesi
        </a>
    </div>

    <div class="alert alert-warning">
        <i class="fas fa-info-circle me-2"></i>
        Bu listede IP yapılandırması hatalı olan hatlar gösterilmektedir. Hataları gidermek için ilgili hattı düzenleyebilirsiniz.
    </div>

    {{-- Hatalı Hat Tablosu --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="ipHataliTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Hat Adı</th>
                            <th>Mikrotik</th>
                            <th>Kapasite</th>
                            <th>Kullanılan</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hatlar ?? [] as $hat)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $hat->id }}</span></td>
                            <td>
                                <strong>{{ $hat->ad }}</strong>
                                <br><small class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>IP yapılandırma hatası</small>
                            </td>
                            <td>
                                @if($hat->mikrotik)
                                    <a href="{{ route('mikrotik.show', $hat->mikrotik->id) }}">{{ $hat->mikrotik->ad }}</a>
                                    <br><small class="text-muted">{{ $hat->mikrotik->ip_adresi }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $hat->kapasite }}</td>
                            <td>{{ $hat->kullanilan }}</td>
                            <td>
                                @if($hat->aktif)
                                    <span class="badge bg-warning text-dark">Aktif / Hatalı</span>
                                @else
                                    <span class="badge bg-secondary">Pasif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('mikrotik.hat.edit', $hat->id) }}" class="btn btn-outline-primary" title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($hatlar) && $hatlar->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $hatlar->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#ipHataliTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'asc']],
        pageLength: 25
    });
});
</script>
@endpush
@endsection
