@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">İstasyonlar</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#istasyonEkleModal">
            <i class="fas fa-plus me-1"></i> İstasyon Ekle
        </button>
    </div>

    {{-- İstasyon Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="istasyonTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>İstasyon Adı</th>
                        <th>Konum</th>
                        <th>İl / İlçe</th>
                        <th>Verici Sayısı</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($istasyonlar ?? [] as $istasyon)
                    <tr>
                        <td><strong>{{ $istasyon->ad }}</strong></td>
                        <td>
                            @if($istasyon->lat && $istasyon->lng)
                            <a href="https://www.google.com/maps?q={{ $istasyon->lat }},{{ $istasyon->lng }}" target="_blank" class="text-decoration-none">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $istasyon->lat }}, {{ $istasyon->lng }}
                            </a>
                            @else
                            -
                            @endif
                        </td>
                        <td>{{ $istasyon->il ?? '-' }} / {{ $istasyon->ilce ?? '-' }}</td>
                        <td><span class="badge bg-info">{{ $istasyon->vericiler_count ?? $istasyon->vericiler->count() ?? 0 }}</span></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('istasyon.show', $istasyon->id) }}" class="btn btn-info" title="Detay">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-warning btn-duzenle" data-id="{{ $istasyon->id }}" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('istasyon.destroy', $istasyon->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu istasyonu silmek istediğinize emin misiniz?')">
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

{{-- İstasyon Ekle Modal --}}
<div class="modal fade" id="istasyonEkleModal" tabindex="-1" aria-labelledby="istasyonEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('istasyon.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="istasyonEkleModalLabel">İstasyon Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ist_ad" class="form-label">İstasyon Adı <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ist_ad" name="ad" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="ist_lat" class="form-label">Enlem (Latitude)</label>
                            <input type="text" class="form-control" id="ist_lat" name="lat" placeholder="38.423733">
                        </div>
                        <div class="col-md-6">
                            <label for="ist_lng" class="form-label">Boylam (Longitude)</label>
                            <input type="text" class="form-control" id="ist_lng" name="lng" placeholder="27.142826">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="ist_il" class="form-label">İl</label>
                            <input type="text" class="form-control" id="ist_il" name="il">
                        </div>
                        <div class="col-md-6">
                            <label for="ist_ilce" class="form-label">İlçe</label>
                            <input type="text" class="form-control" id="ist_ilce" name="ilce">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="ist_aciklama" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="ist_aciklama" name="aciklama" rows="3"></textarea>
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
    $('#istasyonTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'asc']],
        responsive: true
    });
});
</script>
@endpush
