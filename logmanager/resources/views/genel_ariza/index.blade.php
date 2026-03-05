@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Genel Arızalar</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#arizaEkleModal">
            <i class="fas fa-plus me-1"></i> Arıza Ekle
        </button>
    </div>

    {{-- Özet Kartları --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card bg-danger text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Aktif Arızalar</div>
                        <div class="fs-4 fw-bold">{{ $aktifArizalar ?? 0 }}</div>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-success text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Çözülen</div>
                        <div class="fs-4 fw-bold">{{ $cozulen ?? 0 }}</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-warning text-dark p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small">Beklemede</div>
                        <div class="fs-4 fw-bold">{{ $beklemede ?? 0 }}</div>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Arıza Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="arizaTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Arıza No</th>
                        <th>Başlık</th>
                        <th>Etkilenen Bölge</th>
                        <th>Başlangıç</th>
                        <th>Durum</th>
                        <th>Etkilenen Müşteri</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arizalar ?? [] as $ariza)
                    <tr>
                        <td><strong>#{{ $ariza->ariza_no }}</strong></td>
                        <td>{{ $ariza->baslik }}</td>
                        <td>
                            @foreach($ariza->bolgeler ?? [] as $bolge)
                            <span class="badge bg-secondary me-1">{{ $bolge->ad }}</span>
                            @endforeach
                        </td>
                        <td>{{ $ariza->baslangic_tarihi ? $ariza->baslangic_tarihi->format('d.m.Y H:i') : '-' }}</td>
                        <td>
                            @php
                                $durumRenk = match($ariza->durum) {
                                    'aktif' => 'danger',
                                    'cozuldu' => 'success',
                                    'beklemede' => 'warning',
                                    default => 'secondary'
                                };
                                $durumMetin = match($ariza->durum) {
                                    'aktif' => 'Aktif',
                                    'cozuldu' => 'Çözüldü',
                                    'beklemede' => 'Beklemede',
                                    default => $ariza->durum
                                };
                            @endphp
                            <span class="badge bg-{{ $durumRenk }}">{{ $durumMetin }}</span>
                        </td>
                        <td><span class="badge bg-info">{{ $ariza->etkilenen_musteri ?? 0 }}</span></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('genel_ariza.show', $ariza->id) }}" class="btn btn-info" title="Detay">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-warning btn-duzenle" data-id="{{ $ariza->id }}" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($ariza->durum == 'aktif')
                                <form action="{{ route('genel_ariza.coz', $ariza->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success" title="Çözüldü Olarak İşaretle"><i class="fas fa-check"></i></button>
                                </form>
                                @endif
                                <form action="{{ route('genel_ariza.destroy', $ariza->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu arıza kaydını silmek istediğinize emin misiniz?')">
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

{{-- Arıza Ekle Modal --}}
<div class="modal fade" id="arizaEkleModal" tabindex="-1" aria-labelledby="arizaEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('genel_ariza.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="arizaEkleModalLabel">Genel Arıza Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ar_baslik" class="form-label">Başlık <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ar_baslik" name="baslik" required>
                    </div>
                    <div class="mb-3">
                        <label for="ar_aciklama" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="ar_aciklama" name="aciklama" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ar_bolge" class="form-label">Etkilenen Bölge(ler) <span class="text-danger">*</span></label>
                        <select class="form-select select2" id="ar_bolge" name="bolge_ids[]" multiple required>
                            @foreach($bolgeler ?? [] as $bolge)
                            <option value="{{ $bolge->id }}">{{ $bolge->ad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="ar_tarih" class="form-label">Başlangıç Tarihi <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="ar_tarih" name="baslangic_tarihi" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ar_oncelik" class="form-label">Öncelik</label>
                            <select class="form-select" id="ar_oncelik" name="oncelik">
                                <option value="dusuk">Düşük</option>
                                <option value="normal" selected>Normal</option>
                                <option value="yuksek">Yüksek</option>
                                <option value="kritik">Kritik</option>
                            </select>
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
    $('#arizaTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'desc']],
        responsive: true
    });
    $('.select2').select2({ theme: 'bootstrap-5', dropdownParent: $('#arizaEkleModal') });
});
</script>
@endpush
