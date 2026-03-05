@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Teknik Servis Listesi</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#isEmriEkleModal">
            <i class="fas fa-plus me-1"></i> İş Emri Ekle
        </button>
    </div>

    {{-- Özet Kartları --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card bg-primary text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Toplam</div>
                        <div class="fs-4 fw-bold">{{ $toplam ?? 0 }}</div>
                    </div>
                    <i class="fas fa-clipboard-list fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-warning text-dark p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small">Açık</div>
                        <div class="fs-4 fw-bold">{{ $acik ?? 0 }}</div>
                    </div>
                    <i class="fas fa-folder-open fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-success text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Tamamlanan</div>
                        <div class="fs-4 fw-bold">{{ $tamamlanan ?? 0 }}</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-info text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Beklemede</div>
                        <div class="fs-4 fw-bold">{{ $beklemede ?? 0 }}</div>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtreler --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('teknik_servis.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="durum_filtre" class="form-label">Durum</label>
                        <select class="form-select" id="durum_filtre" name="durum">
                            <option value="">Tümü</option>
                            <option value="acik" {{ request('durum') == 'acik' ? 'selected' : '' }}>Açık</option>
                            <option value="devam_ediyor" {{ request('durum') == 'devam_ediyor' ? 'selected' : '' }}>Devam Ediyor</option>
                            <option value="beklemede" {{ request('durum') == 'beklemede' ? 'selected' : '' }}>Beklemede</option>
                            <option value="tamamlandi" {{ request('durum') == 'tamamlandi' ? 'selected' : '' }}>Tamamlandı</option>
                            <option value="iptal" {{ request('durum') == 'iptal' ? 'selected' : '' }}>İptal</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="baslangic" class="form-label">Başlangıç</label>
                        <input type="date" class="form-control" id="baslangic" name="baslangic" value="{{ request('baslangic') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="bitis" class="form-label">Bitiş</label>
                        <input type="date" class="form-control" id="bitis" name="bitis" value="{{ request('bitis') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="personel_filtre" class="form-label">Personel</label>
                        <select class="form-select" id="personel_filtre" name="personel_id">
                            <option value="">Tümü</option>
                            @foreach($personeller ?? [] as $personel)
                            <option value="{{ $personel->id }}" {{ request('personel_id') == $personel->id ? 'selected' : '' }}>{{ $personel->ad_soyad }}</option>
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

    {{-- İş Emirleri Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="teknikServisTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>İş Emri No</th>
                        <th>Müşteri</th>
                        <th>İş Tanımı</th>
                        <th>Atanan Personel</th>
                        <th>Tarih</th>
                        <th>Durum</th>
                        <th>Öncelik</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($isEmirleri ?? [] as $isEmri)
                    <tr>
                        <td><strong>#{{ $isEmri->is_emri_no }}</strong></td>
                        <td>{{ $isEmri->musteri->ad_soyad ?? '-' }}</td>
                        <td>{{ $isEmri->isTanimi->ad ?? '-' }}</td>
                        <td>{{ $isEmri->personel->ad_soyad ?? '-' }}</td>
                        <td>{{ $isEmri->created_at ? $isEmri->created_at->format('d.m.Y') : '-' }}</td>
                        <td>
                            @php
                                $durumRenk = match($isEmri->durum) {
                                    'acik' => 'warning',
                                    'devam_ediyor' => 'primary',
                                    'beklemede' => 'info',
                                    'tamamlandi' => 'success',
                                    'iptal' => 'secondary',
                                    default => 'dark'
                                };
                                $durumMetin = match($isEmri->durum) {
                                    'acik' => 'Açık',
                                    'devam_ediyor' => 'Devam Ediyor',
                                    'beklemede' => 'Beklemede',
                                    'tamamlandi' => 'Tamamlandı',
                                    'iptal' => 'İptal',
                                    default => $isEmri->durum
                                };
                            @endphp
                            <span class="badge bg-{{ $durumRenk }}">{{ $durumMetin }}</span>
                        </td>
                        <td>
                            @php
                                $oncelikRenk = match($isEmri->oncelik) {
                                    'dusuk' => 'secondary',
                                    'normal' => 'info',
                                    'yuksek' => 'warning',
                                    'acil' => 'danger',
                                    default => 'dark'
                                };
                                $oncelikMetin = match($isEmri->oncelik) {
                                    'dusuk' => 'Düşük',
                                    'normal' => 'Normal',
                                    'yuksek' => 'Yüksek',
                                    'acil' => 'Acil',
                                    default => $isEmri->oncelik
                                };
                            @endphp
                            <span class="badge bg-{{ $oncelikRenk }}">{{ $oncelikMetin }}</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('teknik_servis.show', $isEmri->id) }}" class="btn btn-info" title="Detay">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-warning btn-duzenle" data-id="{{ $isEmri->id }}" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('teknik_servis.destroy', $isEmri->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu iş emrini silmek istediğinize emin misiniz?')">
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

{{-- İş Emri Ekle Modal --}}
<div class="modal fade" id="isEmriEkleModal" tabindex="-1" aria-labelledby="isEmriEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('teknik_servis.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="isEmriEkleModalLabel">İş Emri Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="ie_musteri" class="form-label">Müşteri <span class="text-danger">*</span></label>
                            <select class="form-select select2" id="ie_musteri" name="musteri_id" required>
                                <option value="">Müşteri seçiniz</option>
                                @foreach($musteriler ?? [] as $musteri)
                                <option value="{{ $musteri->id }}">{{ $musteri->ad_soyad }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ie_is_tanimi" class="form-label">İş Tanımı <span class="text-danger">*</span></label>
                            <select class="form-select select2" id="ie_is_tanimi" name="is_tanimi_id" required>
                                <option value="">İş tanımı seçiniz</option>
                                @foreach($isTanimlari ?? [] as $isTanimi)
                                <option value="{{ $isTanimi->id }}">{{ $isTanimi->ad }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ie_personel" class="form-label">Personel <span class="text-danger">*</span></label>
                            <select class="form-select select2" id="ie_personel" name="personel_id" required>
                                <option value="">Personel seçiniz</option>
                                @foreach($personeller ?? [] as $personel)
                                <option value="{{ $personel->id }}">{{ $personel->ad_soyad }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ie_oncelik" class="form-label">Öncelik <span class="text-danger">*</span></label>
                            <select class="form-select" id="ie_oncelik" name="oncelik" required>
                                <option value="dusuk">Düşük</option>
                                <option value="normal" selected>Normal</option>
                                <option value="yuksek">Yüksek</option>
                                <option value="acil">Acil</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ie_tarih" class="form-label">Planlanan Tarih</label>
                            <input type="datetime-local" class="form-control" id="ie_tarih" name="planlanan_tarih">
                        </div>
                        <div class="col-12">
                            <label for="ie_aciklama" class="form-label">Açıklama</label>
                            <textarea class="form-control" id="ie_aciklama" name="aciklama" rows="3"></textarea>
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
    $('#teknikServisTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'desc']],
        responsive: true
    });
    $('.select2').select2({ theme: 'bootstrap-5', dropdownParent: $('#isEmriEkleModal') });
});
</script>
@endpush
