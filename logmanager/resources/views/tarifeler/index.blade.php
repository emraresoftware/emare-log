@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item active">Tarife Listesi</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tarife Listesi</h1>
        <a href="{{ route('tarife.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tarife Ekle
        </a>
    </div>

    {{-- Tarife Tablosu --}}
    <div class="table-card card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tarifelerTable">
                    <thead class="table-light">
                        <tr>
                            <th>Tarife Adı</th>
                            <th>Hız (Download/Upload)</th>
                            <th>Fiyat (₺)</th>
                            <th>KDV Dahil Fiyat</th>
                            <th>Kota</th>
                            <th>Müşteri Sayısı</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tarifeler ?? [] as $tarife)
                        <tr>
                            <td><strong>{{ $tarife->ad }}</strong></td>
                            <td>
                                <span class="text-primary">{{ $tarife->download_hizi }} Mbps</span> /
                                <span class="text-info">{{ $tarife->upload_hizi }} Mbps</span>
                            </td>
                            <td>₺{{ number_format($tarife->fiyat, 2, ',', '.') }}</td>
                            <td>₺{{ number_format($tarife->kdv_dahil_fiyat, 2, ',', '.') }}</td>
                            <td>
                                @if($tarife->kota == 0)
                                    <span class="badge bg-success">Sınırsız</span>
                                @else
                                    {{ $tarife->kota }} GB
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $tarife->musteri_sayisi ?? 0 }}</span>
                            </td>
                            <td>
                                @if($tarife->durum == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Pasif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('tarife.edit', $tarife->id) }}" class="btn btn-outline-primary" title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('tarife.istatistik', $tarife->id) }}" class="btn btn-outline-info" title="İstatistik">
                                        <i class="fas fa-chart-bar"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" onclick="tarifeSil({{ $tarife->id }})" title="Sil">
                                        <i class="fas fa-trash"></i>
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

{{-- Silme Onay Modal --}}
<div class="modal fade" id="silModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tarife Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="silForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Bu tarifeyi silmek istediğinize emin misiniz?</p>
                    <p class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i> Bu işlem geri alınamaz.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-danger">Sil</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tarifelerTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            order: [[0, 'asc']],
            pageLength: 25
        });
    });

    function tarifeSil(tarifeId) {
        $('#silForm').attr('action', '/tarifeler/' + tarifeId);
        new bootstrap.Modal(document.getElementById('silModal')).show();
    }
</script>
@endpush
@endsection
