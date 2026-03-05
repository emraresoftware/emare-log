@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Kasa Listesi</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kasaEkleModal">
            <i class="fas fa-plus me-1"></i> Kasa Ekle
        </button>
    </div>

    {{-- Özet Kartları --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card bg-primary text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Toplam Kasa Bakiye</div>
                        <div class="fs-4 fw-bold">₺{{ number_format($toplamBakiye ?? 0, 2, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-wallet fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-success text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Bugünkü Giriş</div>
                        <div class="fs-4 fw-bold">₺{{ number_format($bugunGiris ?? 0, 2, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-arrow-down fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-danger text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Bugünkü Çıkış</div>
                        <div class="fs-4 fw-bold">₺{{ number_format($bugunCikis ?? 0, 2, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-arrow-up fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-info text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Net</div>
                        <div class="fs-4 fw-bold">₺{{ number_format(($bugunGiris ?? 0) - ($bugunCikis ?? 0), 2, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-balance-scale fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Kasa Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="kasaTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th></th>
                        <th>Kasa Adı</th>
                        <th>Bakiye (₺)</th>
                        <th>Son İşlem</th>
                        <th>Sorumlu</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kasalar ?? [] as $kasa)
                    <tr>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary btn-expand" data-bs-toggle="collapse" data-bs-target="#hareketler-{{ $kasa->id }}">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </td>
                        <td>{{ $kasa->ad }}</td>
                        <td class="{{ $kasa->bakiye >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                            ₺{{ number_format($kasa->bakiye, 2, ',', '.') }}
                        </td>
                        <td>{{ $kasa->son_islem ? $kasa->son_islem->format('d.m.Y H:i') : '-' }}</td>
                        <td>{{ $kasa->sorumlu->name ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('kasa.show', $kasa->id) }}" class="btn btn-info" title="Detay">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-warning btn-duzenle" data-id="{{ $kasa->id }}" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('kasa.destroy', $kasa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu kasayı silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" title="Sil"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse" id="hareketler-{{ $kasa->id }}">
                        <td colspan="6">
                            <div class="p-3 bg-light rounded">
                                <h6 class="mb-2">Son Kasa Hareketleri</h6>
                                <table class="table table-sm table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Tarih</th>
                                            <th>Tip</th>
                                            <th>Tutar</th>
                                            <th>Açıklama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kasa->hareketler->take(5) ?? [] as $hareket)
                                        <tr>
                                            <td>{{ $hareket->created_at->format('d.m.Y H:i') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $hareket->tip == 'giris' ? 'success' : 'danger' }}">
                                                    {{ $hareket->tip == 'giris' ? 'Giriş' : 'Çıkış' }}
                                                </span>
                                            </td>
                                            <td>₺{{ number_format($hareket->tutar, 2, ',', '.') }}</td>
                                            <td>{{ $hareket->aciklama }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

{{-- Kasa Ekle Modal --}}
<div class="modal fade" id="kasaEkleModal" tabindex="-1" aria-labelledby="kasaEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('kasa.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="kasaEkleModalLabel">Kasa Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ad" class="form-label">Kasa Adı <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ad" name="ad" required>
                    </div>
                    <div class="mb-3">
                        <label for="aciklama" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="aciklama" name="aciklama" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="baslangic_bakiye" class="form-label">Başlangıç Bakiye (₺)</label>
                        <input type="number" step="0.01" class="form-control" id="baslangic_bakiye" name="baslangic_bakiye" value="0.00">
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
    $('#kasaTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[1, 'asc']],
        responsive: true
    });
});
</script>
@endpush
