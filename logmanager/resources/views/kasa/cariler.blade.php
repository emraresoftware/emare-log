@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Cari Listesi</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cariEkleModal">
            <i class="fas fa-plus me-1"></i> Cari Ekle
        </button>
    </div>

    {{-- Cari Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="cariTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Cari Kodu</th>
                        <th>Cari Adı</th>
                        <th>Tip</th>
                        <th>Bakiye (₺)</th>
                        <th>Telefon</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cariler ?? [] as $cari)
                    <tr>
                        <td><span class="badge bg-secondary">{{ $cari->cari_kodu }}</span></td>
                        <td>{{ $cari->ad }}</td>
                        <td>
                            <span class="badge bg-{{ $cari->tip == 'alacak' ? 'success' : 'danger' }}">
                                {{ $cari->tip == 'alacak' ? 'Alacak' : 'Borç' }}
                            </span>
                        </td>
                        <td class="{{ $cari->bakiye >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                            ₺{{ number_format($cari->bakiye, 2, ',', '.') }}
                        </td>
                        <td>{{ $cari->telefon ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('cari.show', $cari->id) }}" class="btn btn-info" title="Detay">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('cari.fatura', $cari->id) }}" class="btn btn-success" title="Fatura Kes">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
                                <button class="btn btn-warning btn-duzenle" data-id="{{ $cari->id }}" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('cari.destroy', $cari->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu cariyi silmek istediğinize emin misiniz?')">
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

{{-- Cari Ekle Modal --}}
<div class="modal fade" id="cariEkleModal" tabindex="-1" aria-labelledby="cariEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('cari.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="cariEkleModalLabel">Cari Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="cari_ad" class="form-label">Cari Adı <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="cari_ad" name="ad" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cari_kodu" class="form-label">Cari Kodu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="cari_kodu" name="cari_kodu" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tip" class="form-label">Tip <span class="text-danger">*</span></label>
                            <select class="form-select" id="tip" name="tip" required>
                                <option value="">Seçiniz</option>
                                <option value="alacak">Alacak</option>
                                <option value="borc">Borç</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="telefon" class="form-label">Telefon</label>
                            <input type="text" class="form-control" id="telefon" name="telefon" placeholder="05XX XXX XX XX">
                        </div>
                        <div class="col-md-6">
                            <label for="eposta" class="form-label">E-Posta</label>
                            <input type="email" class="form-control" id="eposta" name="eposta">
                        </div>
                        <div class="col-md-6">
                            <label for="adres" class="form-label">Adres</label>
                            <input type="text" class="form-control" id="adres" name="adres">
                        </div>
                        <div class="col-12">
                            <label for="cari_aciklama" class="form-label">Açıklama</label>
                            <textarea class="form-control" id="cari_aciklama" name="aciklama" rows="3"></textarea>
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#cariTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'asc']],
        responsive: true
    });
});
</script>
@endpush
