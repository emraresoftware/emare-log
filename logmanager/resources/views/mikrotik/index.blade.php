@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item active">Mikrotik Listesi</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Mikrotik Listesi</h1>
        <a href="{{ route('mikrotik.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Mikrotik Ekle
        </a>
    </div>

    {{-- Özet Kartları --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Toplam Mikrotik</h6>
                            <h3 class="mb-0">{{ $toplamMikrotik ?? 0 }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-server fa-2x text-primary"></i>
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
                            <h6 class="text-muted mb-1">Aktif</h6>
                            <h3 class="mb-0 text-success">{{ $aktifMikrotik ?? 0 }}</h3>
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
                            <h6 class="text-muted mb-1">Hatalı</h6>
                            <h3 class="mb-0 text-danger">{{ $hataliMikrotik ?? 0 }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
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
                            <h6 class="text-muted mb-1">Ortalama Yük</h6>
                            <h3 class="mb-0 text-info">%{{ $ortalamaYuk ?? 0 }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-microchip fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mikrotik Tablosu --}}
    <div class="table-card card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="mikrotikTable">
                    <thead class="table-light">
                        <tr>
                            <th>Mikrotik Adı</th>
                            <th>IP Adresi</th>
                            <th>Port</th>
                            <th>Kullanıcı Sayısı</th>
                            <th>CPU %</th>
                            <th>Bellek %</th>
                            <th>Uptime</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mikrotikler ?? [] as $mikrotik)
                        <tr>
                            <td><strong>{{ $mikrotik->ad }}</strong></td>
                            <td><code>{{ $mikrotik->ip_adresi }}</code></td>
                            <td>{{ $mikrotik->api_port }}</td>
                            <td><span class="badge bg-info">{{ $mikrotik->kullanici_sayisi ?? 0 }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 6px; width: 60px;">
                                        <div class="progress-bar {{ ($mikrotik->cpu ?? 0) > 80 ? 'bg-danger' : (($mikrotik->cpu ?? 0) > 50 ? 'bg-warning' : 'bg-success') }}"
                                             style="width: {{ $mikrotik->cpu ?? 0 }}%"></div>
                                    </div>
                                    <small>%{{ $mikrotik->cpu ?? 0 }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 6px; width: 60px;">
                                        <div class="progress-bar {{ ($mikrotik->bellek ?? 0) > 80 ? 'bg-danger' : (($mikrotik->bellek ?? 0) > 50 ? 'bg-warning' : 'bg-success') }}"
                                             style="width: {{ $mikrotik->bellek ?? 0 }}%"></div>
                                    </div>
                                    <small>%{{ $mikrotik->bellek ?? 0 }}</small>
                                </div>
                            </td>
                            <td><small>{{ $mikrotik->uptime ?? '-' }}</small></td>
                            <td>
                                @if($mikrotik->durum == 'online')
                                    <span class="badge bg-success">Online</span>
                                @else
                                    <span class="badge bg-danger">Offline</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        İşlemler
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('mikrotik.show', $mikrotik->id) }}"><i class="fas fa-eye me-2"></i>Detay</a></li>
                                        <li><a class="dropdown-item" href="{{ route('mikrotik.edit', $mikrotik->id) }}"><i class="fas fa-edit me-2"></i>Düzenle</a></li>
                                        <li><a class="dropdown-item" href="{{ route('mikrotik.ppp', $mikrotik->id) }}"><i class="fas fa-key me-2"></i>PPP Secret</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="mikrotikBaglan({{ $mikrotik->id }})"><i class="fas fa-plug me-2"></i>Bağlan</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#" onclick="mikrotikSil({{ $mikrotik->id }})">
                                                <i class="fas fa-trash me-2"></i>Sil
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
        </div>
    </div>

</div>

{{-- Silme Onay Modal --}}
<div class="modal fade" id="silModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mikrotik Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="silForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Bu Mikrotik cihazını silmek istediğinize emin misiniz?</p>
                    <p class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i> Bu işlem geri alınamaz ve bağlı tüm kullanıcı kayıtları etkilenebilir.</p>
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
        $('#mikrotikTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            order: [[0, 'asc']],
            pageLength: 25
        });
    });

    function mikrotikBaglan(mikrotikId) {
        toastr.info('Mikrotik cihazına bağlanılıyor...');
        $.post('/mikrotik/' + mikrotikId + '/baglan', {_token: '{{ csrf_token() }}'}, function(response) {
            if (response.success) {
                toastr.success('Bağlantı başarılı.');
                location.reload();
            } else {
                toastr.error(response.message || 'Bağlantı kurulamadı.');
            }
        }).fail(function() {
            toastr.error('Bağlantı sırasında bir hata oluştu.');
        });
    }

    function mikrotikSil(mikrotikId) {
        $('#silForm').attr('action', '/mikrotik/' + mikrotikId);
        new bootstrap.Modal(document.getElementById('silModal')).show();
    }
</script>
@endpush
@endsection
