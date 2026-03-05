@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mikrotik.index') }}">Mikrotik</a></li>
            <li class="breadcrumb-item active">VPN Kullanıcıları</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-shield-alt text-warning me-2"></i>VPN (CHAP) Kullanıcıları</h1>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#vpnEkleModal">
                <i class="fas fa-plus me-1"></i> VPN Kullanıcı Ekle
            </button>
            <a href="{{ route('mikrotik.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Mikrotik Listesi
            </a>
        </div>
    </div>

    {{-- Özet --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Toplam VPN</h6>
                            <h3 class="mb-0">{{ $vpnKullanicilar->total() ?? 0 }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-shield-alt fa-2x text-primary"></i>
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
                            <h6 class="text-muted mb-1">Aktif</h6>
                            <h3 class="mb-0 text-success">{{ $vpnKullanicilar->filter(fn($v) => $v->aktif)->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tablo --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="vpnTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Kullanıcı Adı</th>
                            <th>Mikrotik</th>
                            <th>Profil</th>
                            <th>Remote IP</th>
                            <th>Local IP</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vpnKullanicilar ?? [] as $vpn)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $vpn->id }}</span></td>
                            <td><strong>{{ $vpn->kullanici_adi }}</strong></td>
                            <td>
                                @if($vpn->mikrotik)
                                    <a href="{{ route('mikrotik.show', $vpn->mikrotik->id) }}">{{ $vpn->mikrotik->ad }}</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $vpn->profil ?? '-' }}</td>
                            <td><code>{{ $vpn->remote_address ?? '-' }}</code></td>
                            <td><code>{{ $vpn->local_address ?? '-' }}</code></td>
                            <td>
                                @if($vpn->aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Pasif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="Düzenle" onclick="vpnDuzenle({{ $vpn->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" title="Sil" onclick="vpnSil({{ $vpn->id }})">
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

            @if(isset($vpnKullanicilar) && $vpnKullanicilar->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $vpnKullanicilar->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- VPN Ekle Modal --}}
<div class="modal fade" id="vpnEkleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="#" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-shield-alt me-2"></i>VPN Kullanıcı Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kullanıcı Adı <span class="text-danger">*</span></label>
                            <input type="text" name="kullanici_adi" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Şifre <span class="text-danger">*</span></label>
                            <input type="text" name="sifre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mikrotik <span class="text-danger">*</span></label>
                            <select name="mikrotik_id" class="form-select select2" required>
                                <option value="">Seçiniz</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Profil</label>
                            <input type="text" name="profil" class="form-control" placeholder="default">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Remote Address</label>
                            <input type="text" name="remote_address" class="form-control" placeholder="10.0.0.x">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Local Address</label>
                            <input type="text" name="local_address" class="form-control" placeholder="10.0.0.1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#vpnTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'desc']],
        pageLength: 25
    });
});

function vpnSil(id) {
    Swal.fire({
        title: 'Emin misiniz?', text: 'VPN kullanıcısı silinecek!', icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#e74c3c', cancelButtonText: 'İptal', confirmButtonText: 'Sil'
    }).then((result) => { if (result.isConfirmed) { toastr.success('VPN kullanıcısı silindi.'); } });
}

function vpnDuzenle(id) {
    toastr.info('Düzenleme modalı açılıyor...');
}
</script>
@endpush
@endsection
