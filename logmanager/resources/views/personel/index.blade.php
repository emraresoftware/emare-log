@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Personel Listesi</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#personelEkleModal">
            <i class="fas fa-plus me-1"></i> Personel Ekle
        </button>
    </div>

    {{-- Personel Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="personelTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Ad Soyad</th>
                        <th>Telefon</th>
                        <th>E-Posta</th>
                        <th>Departman</th>
                        <th>Görev</th>
                        <th>İşe Giriş</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($personeller ?? [] as $personel)
                    <tr>
                        <td><strong>{{ $personel->ad }} {{ $personel->soyad }}</strong></td>
                        <td>{{ $personel->telefon ?? '-' }}</td>
                        <td>{{ $personel->eposta ?? '-' }}</td>
                        <td>{{ $personel->departman ?? '-' }}</td>
                        <td>{{ $personel->gorev ?? '-' }}</td>
                        <td>{{ $personel->ise_giris_tarihi ? $personel->ise_giris_tarihi->format('d.m.Y') : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $personel->durum ? 'success' : 'secondary' }}">
                                {{ $personel->durum ? 'Aktif' : 'Pasif' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-warning btn-duzenle" data-id="{{ $personel->id }}" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('personel.destroy', $personel->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu personeli silmek istediğinize emin misiniz?')">
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

{{-- Personel Ekle Modal --}}
<div class="modal fade" id="personelEkleModal" tabindex="-1" aria-labelledby="personelEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('personel.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="personelEkleModalLabel">Personel Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="pr_ad" class="form-label">Ad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pr_ad" name="ad" required>
                        </div>
                        <div class="col-md-6">
                            <label for="pr_soyad" class="form-label">Soyad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pr_soyad" name="soyad" required>
                        </div>
                        <div class="col-md-6">
                            <label for="pr_tc" class="form-label">TC Kimlik No</label>
                            <input type="text" class="form-control" id="pr_tc" name="tc_no" maxlength="11">
                        </div>
                        <div class="col-md-6">
                            <label for="pr_telefon" class="form-label">Telefon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pr_telefon" name="telefon" placeholder="05XX XXX XX XX" required>
                        </div>
                        <div class="col-md-6">
                            <label for="pr_eposta" class="form-label">E-Posta</label>
                            <input type="email" class="form-control" id="pr_eposta" name="eposta">
                        </div>
                        <div class="col-md-6">
                            <label for="pr_departman" class="form-label">Departman</label>
                            <select class="form-select" id="pr_departman" name="departman">
                                <option value="">Seçiniz</option>
                                <option value="Teknik">Teknik</option>
                                <option value="Muhasebe">Muhasebe</option>
                                <option value="Satış">Satış</option>
                                <option value="Destek">Destek</option>
                                <option value="Yönetim">Yönetim</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="pr_gorev" class="form-label">Görev</label>
                            <input type="text" class="form-control" id="pr_gorev" name="gorev">
                        </div>
                        <div class="col-md-6">
                            <label for="pr_maas" class="form-label">Maaş (₺)</label>
                            <input type="number" step="0.01" class="form-control" id="pr_maas" name="maas">
                        </div>
                        <div class="col-md-6">
                            <label for="pr_ise_giris" class="form-label">İşe Giriş Tarihi</label>
                            <input type="date" class="form-control" id="pr_ise_giris" name="ise_giris_tarihi">
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
    $('#personelTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'asc']],
        responsive: true
    });
});
</script>
@endpush
