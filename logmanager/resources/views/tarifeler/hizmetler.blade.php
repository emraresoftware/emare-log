@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tarife.index') }}">Tarifeler</a></li>
            <li class="breadcrumb-item active">Hizmet Listesi</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Hizmet Listesi</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hizmetEkleModal">
            <i class="fas fa-plus me-1"></i> Hizmet Ekle
        </button>
    </div>

    {{-- Hizmet Tablosu --}}
    <div class="table-card card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="hizmetlerTable">
                    <thead class="table-light">
                        <tr>
                            <th>Hizmet Adı</th>
                            <th>Fiyat (₺)</th>
                            <th>KDV (%)</th>
                            <th>Açıklama</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hizmetler ?? [] as $hizmet)
                        <tr>
                            <td><strong>{{ $hizmet->ad }}</strong></td>
                            <td>₺{{ number_format($hizmet->fiyat, 2, ',', '.') }}</td>
                            <td>%{{ $hizmet->kdv_orani }}</td>
                            <td>{{ $hizmet->aciklama ?? '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-primary" onclick="hizmetDuzenle({{ $hizmet->id }}, '{{ addslashes($hizmet->ad) }}', {{ $hizmet->fiyat }}, {{ $hizmet->kdv_orani }}, '{{ addslashes($hizmet->aciklama) }}')" title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" onclick="hizmetSil({{ $hizmet->id }})" title="Sil">
                                        <i class="fas fa-trash"></i>
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

</div>

{{-- Hizmet Ekle Modal --}}
<div class="modal fade" id="hizmetEkleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Hizmet Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('hizmet.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Hizmet Adı <span class="text-danger">*</span></label>
                        <input type="text" name="ad" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fiyat (₺) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">₺</span>
                            <input type="number" step="0.01" name="fiyat" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">KDV Oranı (%) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="kdv_orani" class="form-control" value="20" required>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea name="aciklama" class="form-control" rows="3" placeholder="Hizmet açıklaması..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Hizmet Düzenle Modal --}}
<div class="modal fade" id="hizmetDuzenleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Hizmet Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="hizmetDuzenleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Hizmet Adı <span class="text-danger">*</span></label>
                        <input type="text" name="ad" id="duzenleAd" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fiyat (₺) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">₺</span>
                            <input type="number" step="0.01" name="fiyat" id="duzenleFiyat" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">KDV Oranı (%) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="kdv_orani" id="duzenleKdv" class="form-control" required>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea name="aciklama" id="duzenleAciklama" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Silme Onay Modal --}}
<div class="modal fade" id="silModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hizmet Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="silForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Bu hizmeti silmek istediğinize emin misiniz?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-danger">Sil</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#hizmetlerTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            order: [[0, 'asc']],
            pageLength: 25
        });
    });

    function hizmetDuzenle(id, ad, fiyat, kdv, aciklama) {
        $('#hizmetDuzenleForm').attr('action', '/hizmetler/' + id);
        $('#duzenleAd').val(ad);
        $('#duzenleFiyat').val(fiyat);
        $('#duzenleKdv').val(kdv);
        $('#duzenleAciklama').val(aciklama);
        new bootstrap.Modal(document.getElementById('hizmetDuzenleModal')).show();
    }

    function hizmetSil(id) {
        $('#silForm').attr('action', '/hizmetler/' + id);
        new bootstrap.Modal(document.getElementById('silModal')).show();
    }
</script>
@endpush
@endsection
