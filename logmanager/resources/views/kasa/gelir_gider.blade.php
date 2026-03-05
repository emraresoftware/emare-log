@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gelir / Gider Yönetimi</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#gelirGiderEkleModal">
            <i class="fas fa-plus me-1"></i> Gelir/Gider Ekle
        </button>
    </div>

    {{-- Filtreler --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('gelir_gider.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="baslangic_tarihi" class="form-label">Başlangıç Tarihi</label>
                        <input type="date" class="form-control" id="baslangic_tarihi" name="baslangic_tarihi" value="{{ request('baslangic_tarihi') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="bitis_tarihi" class="form-label">Bitiş Tarihi</label>
                        <input type="date" class="form-control" id="bitis_tarihi" name="bitis_tarihi" value="{{ request('bitis_tarihi') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="tip_filtre" class="form-label">Tip</label>
                        <select class="form-select" id="tip_filtre" name="tip">
                            <option value="">Tümü</option>
                            <option value="gelir" {{ request('tip') == 'gelir' ? 'selected' : '' }}>Gelir</option>
                            <option value="gider" {{ request('tip') == 'gider' ? 'selected' : '' }}>Gider</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="kategori_filtre" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori_filtre" name="kategori">
                            <option value="">Tümü</option>
                            @foreach($kategoriler ?? [] as $kategori)
                            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filtrele</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Özet Kartları --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card bg-success text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Toplam Gelir</div>
                        <div class="fs-4 fw-bold">₺{{ number_format($toplamGelir ?? 0, 2, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-arrow-trend-up fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-danger text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Toplam Gider</div>
                        <div class="fs-4 fw-bold">₺{{ number_format($toplamGider ?? 0, 2, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-arrow-trend-down fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-info text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Net Kar/Zarar</div>
                        <div class="fs-4 fw-bold">₺{{ number_format(($toplamGelir ?? 0) - ($toplamGider ?? 0), 2, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-scale-balanced fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Gelir Gider Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="gelirGiderTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Tip</th>
                        <th>Kategori</th>
                        <th>Tutar (₺)</th>
                        <th>Açıklama</th>
                        <th>Kasa</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kayitlar ?? [] as $kayit)
                    <tr>
                        <td>{{ $kayit->tarih ? $kayit->tarih->format('d.m.Y') : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $kayit->tip == 'gelir' ? 'success' : 'danger' }}">
                                {{ $kayit->tip == 'gelir' ? 'Gelir' : 'Gider' }}
                            </span>
                        </td>
                        <td>{{ $kayit->kategori }}</td>
                        <td class="fw-bold">₺{{ number_format($kayit->tutar, 2, ',', '.') }}</td>
                        <td>{{ Str::limit($kayit->aciklama, 40) }}</td>
                        <td>{{ $kayit->kasa->ad ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-warning btn-duzenle" data-id="{{ $kayit->id }}" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('gelir_gider.destroy', $kayit->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu kaydı silmek istediğinize emin misiniz?')">
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

{{-- Gelir/Gider Ekle Modal --}}
<div class="modal fade" id="gelirGiderEkleModal" tabindex="-1" aria-labelledby="gelirGiderEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('gelir_gider.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="gelirGiderEkleModalLabel">Gelir/Gider Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="gg_tip" class="form-label">Tip <span class="text-danger">*</span></label>
                        <select class="form-select" id="gg_tip" name="tip" required>
                            <option value="">Seçiniz</option>
                            <option value="gelir">Gelir</option>
                            <option value="gider">Gider</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gg_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="gg_kategori" name="kategori" required>
                            <option value="">Seçiniz</option>
                            @foreach($kategoriler ?? [] as $kategori)
                            <option value="{{ $kategori }}">{{ $kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gg_tutar" class="form-label">Tutar (₺) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" id="gg_tutar" name="tutar" required>
                    </div>
                    <div class="mb-3">
                        <label for="gg_kasa" class="form-label">Kasa <span class="text-danger">*</span></label>
                        <select class="form-select" id="gg_kasa" name="kasa_id" required>
                            <option value="">Seçiniz</option>
                            @foreach($kasalar ?? [] as $kasa)
                            <option value="{{ $kasa->id }}">{{ $kasa->ad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gg_tarih" class="form-label">Tarih <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="gg_tarih" name="tarih" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="gg_aciklama" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="gg_aciklama" name="aciklama" rows="3"></textarea>
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
    $('#gelirGiderTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'desc']],
        responsive: true
    });
});
</script>
@endpush
