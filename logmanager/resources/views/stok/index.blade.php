@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Stok Listesi</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#stokEkleModal">
            <i class="fas fa-plus me-1"></i> Stok Ekle
        </button>
    </div>

    {{-- Özet Kartları --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card bg-primary text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Toplam Stok</div>
                        <div class="fs-4 fw-bold">{{ $toplamStok ?? 0 }}</div>
                    </div>
                    <i class="fas fa-boxes-stacked fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-success text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Depodaki</div>
                        <div class="fs-4 fw-bold">{{ $depodaki ?? 0 }}</div>
                    </div>
                    <i class="fas fa-warehouse fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-info text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Müşteride</div>
                        <div class="fs-4 fw-bold">{{ $musteride ?? 0 }}</div>
                    </div>
                    <i class="fas fa-user-check fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-danger text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Arızalı</div>
                        <div class="fs-4 fw-bold">{{ $arizali ?? 0 }}</div>
                    </div>
                    <i class="fas fa-triangle-exclamation fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Stok Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="stokTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Ürün Adı</th>
                        <th>Seri No</th>
                        <th>Depo</th>
                        <th>Durum</th>
                        <th>Müşteri</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stoklar ?? [] as $stok)
                    <tr>
                        <td>{{ $stok->urun->ad ?? '-' }}</td>
                        <td><code>{{ $stok->seri_no }}</code></td>
                        <td>{{ $stok->depo->ad ?? '-' }}</td>
                        <td>
                            @php
                                $durumRenk = match($stok->durum) {
                                    'depoda' => 'success',
                                    'musteride' => 'info',
                                    'arizali' => 'danger',
                                    'sokum' => 'secondary',
                                    default => 'warning'
                                };
                                $durumMetin = match($stok->durum) {
                                    'depoda' => 'Depoda',
                                    'musteride' => 'Müşteride',
                                    'arizali' => 'Arızalı',
                                    'sokum' => 'Söküm',
                                    default => 'Bilinmiyor'
                                };
                            @endphp
                            <span class="badge bg-{{ $durumRenk }}">{{ $durumMetin }}</span>
                        </td>
                        <td>{{ $stok->musteri->ad_soyad ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-success btn-musteriye-ver" data-id="{{ $stok->id }}" title="Müşteriye Ver">
                                    <i class="fas fa-user-plus"></i>
                                </button>
                                <button class="btn btn-info btn-depoya-al" data-id="{{ $stok->id }}" title="Depoya Al">
                                    <i class="fas fa-warehouse"></i>
                                </button>
                                <button class="btn btn-warning btn-ariza-bildir" data-id="{{ $stok->id }}" title="Arıza Bildir">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                                <button class="btn btn-secondary btn-duzenle" data-id="{{ $stok->id }}" title="Düzenle">
                                    <i class="fas fa-edit"></i>
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

{{-- Stok Ekle Modal --}}
<div class="modal fade" id="stokEkleModal" tabindex="-1" aria-labelledby="stokEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('stok.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="stokEkleModalLabel">Stok Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="urun_id" class="form-label">Ürün <span class="text-danger">*</span></label>
                        <select class="form-select select2" id="urun_id" name="urun_id" required>
                            <option value="">Ürün seçiniz</option>
                            @foreach($urunler ?? [] as $urun)
                            <option value="{{ $urun->id }}">{{ $urun->ad }} - {{ $urun->marka }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="seri_no" class="form-label">Seri No <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="seri_no" name="seri_no" required>
                    </div>
                    <div class="mb-3">
                        <label for="depo_id" class="form-label">Depo <span class="text-danger">*</span></label>
                        <select class="form-select" id="depo_id" name="depo_id" required>
                            <option value="">Depo seçiniz</option>
                            @foreach($depolar ?? [] as $depo)
                            <option value="{{ $depo->id }}">{{ $depo->ad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stok_aciklama" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="stok_aciklama" name="aciklama" rows="3"></textarea>
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#stokTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'asc']],
        responsive: true
    });
    $('.select2').select2({ theme: 'bootstrap-5', dropdownParent: $('#stokEkleModal') });
});
</script>
@endpush
