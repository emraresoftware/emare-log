@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Ürün Listesi</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#urunEkleModal">
            <i class="fas fa-plus me-1"></i> Ürün Ekle
        </button>
    </div>

    {{-- Ürün Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="urunTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Ürün Adı</th>
                        <th>Marka</th>
                        <th>Model</th>
                        <th>Kategori</th>
                        <th>Toplam Adet</th>
                        <th>Fiyat (₺)</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($urunler ?? [] as $urun)
                    <tr>
                        <td>{{ $urun->ad }}</td>
                        <td>{{ $urun->marka ?? '-' }}</td>
                        <td>{{ $urun->model ?? '-' }}</td>
                        <td><span class="badge bg-secondary">{{ $urun->kategori }}</span></td>
                        <td>
                            <span class="fw-bold">{{ $urun->miktar ?? 0 }}</span>
                        </td>
                        <td class="fw-bold">₺{{ number_format($urun->fiyat ?? 0, 2, ',', '.') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-warning btn-duzenle" data-id="{{ $urun->id }}" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('urun.destroy', $urun->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu ürünü silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" title="Sil"><i class="fas fa-trash"></i></button>
                                </form>
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

{{-- Ürün Ekle Modal --}}
<div class="modal fade" id="urunEkleModal" tabindex="-1" aria-labelledby="urunEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('urun.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="urunEkleModalLabel">Ürün Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="urun_ad" class="form-label">Ürün Adı <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="urun_ad" name="ad" required>
                    </div>
                    <div class="mb-3">
                        <label for="marka" class="form-label">Marka</label>
                        <input type="text" class="form-control" id="marka" name="marka">
                    </div>
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" name="model">
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="">Seçiniz</option>
                            <option value="Modem">Modem</option>
                            <option value="Switch">Switch</option>
                            <option value="Router">Router</option>
                            <option value="Kablo">Kablo</option>
                            <option value="Diğer">Diğer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fiyat" class="form-label">Fiyat (₺)</label>
                        <input type="number" step="0.01" class="form-control" id="fiyat" name="fiyat" value="0.00">
                    </div>
                    <div class="mb-3">
                        <label for="urun_aciklama" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="urun_aciklama" name="aciklama" rows="3"></textarea>
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
    $('#urunTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'asc']],
        responsive: true
    });
});
</script>
@endpush
