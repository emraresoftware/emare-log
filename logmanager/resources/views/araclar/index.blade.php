@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Araç Listesi</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#aracEkleModal">
            <i class="fas fa-plus me-1"></i> Araç Ekle
        </button>
    </div>

    {{-- Araç Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="aracTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Plaka</th>
                        <th>Marka</th>
                        <th>Model</th>
                        <th>Yıl</th>
                        <th>Sorumlu Personel</th>
                        <th>Muayene Tarihi</th>
                        <th>Sigorta Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($araclar ?? [] as $arac)
                    <tr>
                        <td><strong>{{ $arac->plaka }}</strong></td>
                        <td>{{ $arac->marka }}</td>
                        <td>{{ $arac->model }}</td>
                        <td>{{ $arac->yil }}</td>
                        <td>{{ $arac->personel->ad_soyad ?? '-' }}</td>
                        <td>
                            @if($arac->muayene_tarihi)
                                <span class="{{ $arac->muayene_tarihi->isPast() ? 'text-danger fw-bold' : '' }}">
                                    {{ $arac->muayene_tarihi->format('d.m.Y') }}
                                </span>
                                @if($arac->muayene_tarihi->isPast())
                                    <i class="fas fa-exclamation-circle text-danger ms-1" title="Süresi geçmiş"></i>
                                @endif
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            @if($arac->sigorta_tarihi)
                                <span class="{{ $arac->sigorta_tarihi->isPast() ? 'text-danger fw-bold' : '' }}">
                                    {{ $arac->sigorta_tarihi->format('d.m.Y') }}
                                </span>
                                @if($arac->sigorta_tarihi->isPast())
                                    <i class="fas fa-exclamation-circle text-danger ms-1" title="Süresi geçmiş"></i>
                                @endif
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $arac->durum ? 'success' : 'secondary' }}">
                                {{ $arac->durum ? 'Aktif' : 'Pasif' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-warning btn-duzenle" data-id="{{ $arac->id }}" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('arac.destroy', $arac->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu aracı silmek istediğinize emin misiniz?')">
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

{{-- Araç Ekle Modal --}}
<div class="modal fade" id="aracEkleModal" tabindex="-1" aria-labelledby="aracEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('arac.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="aracEkleModalLabel">Araç Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="ar_plaka" class="form-label">Plaka <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="ar_plaka" name="plaka" placeholder="34 ABC 123" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ar_marka" class="form-label">Marka <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="ar_marka" name="marka" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ar_model" class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="ar_model" name="model" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ar_yil" class="form-label">Yıl</label>
                            <input type="number" class="form-control" id="ar_yil" name="yil" min="2000" max="{{ date('Y') + 1 }}" value="{{ date('Y') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="ar_personel" class="form-label">Sorumlu Personel</label>
                            <select class="form-select" id="ar_personel" name="personel_id">
                                <option value="">Seçiniz</option>
                                @foreach($personeller ?? [] as $personel)
                                <option value="{{ $personel->id }}">{{ $personel->ad }} {{ $personel->soyad }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ar_km" class="form-label">Kilometre</label>
                            <input type="number" class="form-control" id="ar_km" name="km" min="0">
                        </div>
                        <div class="col-md-6">
                            <label for="ar_muayene" class="form-label">Muayene Tarihi</label>
                            <input type="date" class="form-control" id="ar_muayene" name="muayene_tarihi">
                        </div>
                        <div class="col-md-6">
                            <label for="ar_sigorta" class="form-label">Sigorta Tarihi</label>
                            <input type="date" class="form-control" id="ar_sigorta" name="sigorta_tarihi">
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
    $('#aracTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'asc']],
        responsive: true
    });
});
</script>
@endpush
