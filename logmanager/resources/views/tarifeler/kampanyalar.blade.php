@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tarife.index') }}">Tarifeler</a></li>
            <li class="breadcrumb-item active">Kampanyalar</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Kampanyalar</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kampanyaEkleModal">
            <i class="fas fa-plus me-1"></i> Kampanya Ekle
        </button>
    </div>

    {{-- Kampanya Tablosu --}}
    <div class="table-card card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="kampanyalarTable">
                    <thead class="table-light">
                        <tr>
                            <th>Kampanya Adı</th>
                            <th>İndirim Oranı/Tutarı</th>
                            <th>Başlangıç</th>
                            <th>Bitiş</th>
                            <th>Durum</th>
                            <th>Müşteri Sayısı</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kampanyalar ?? [] as $kampanya)
                        <tr>
                            <td><strong>{{ $kampanya->ad }}</strong></td>
                            <td>
                                @if($kampanya->indirim_tipi == 'yuzde')
                                    <span class="badge bg-info">%{{ $kampanya->indirim }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">₺{{ number_format($kampanya->indirim, 2, ',', '.') }}</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($kampanya->baslangic_tarihi)->format('d.m.Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($kampanya->bitis_tarihi)->format('d.m.Y') }}</td>
                            <td>
                                @if($kampanya->durum == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($kampanya->durum == 'pasif')
                                    <span class="badge bg-secondary">Pasif</span>
                                @elseif($kampanya->durum == 'suresi_doldu')
                                    <span class="badge bg-danger">Süresi Doldu</span>
                                @endif
                            </td>
                            <td><span class="badge bg-primary">{{ $kampanya->musteri_sayisi ?? 0 }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-primary" onclick="kampanyaDuzenle({{ $kampanya->id }})" title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" onclick="kampanyaSil({{ $kampanya->id }})" title="Sil">
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

{{-- Kampanya Ekle Modal --}}
<div class="modal fade" id="kampanyaEkleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Kampanya Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('kampanya.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kampanya Adı <span class="text-danger">*</span></label>
                            <input type="text" name="ad" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">İndirim Tipi <span class="text-danger">*</span></label>
                            <select name="indirim_tipi" class="form-select" required>
                                <option value="yuzde">Yüzde (%)</option>
                                <option value="tutar">Tutar (₺)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">İndirim <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="indirim" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tarife</label>
                            <select name="tarife_id" class="form-select">
                                <option value="">Tüm Tarifeler</option>
                                @foreach($tarifeler ?? [] as $tarife)
                                    <option value="{{ $tarife->id }}">{{ $tarife->ad }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Başlangıç Tarihi <span class="text-danger">*</span></label>
                            <input type="date" name="baslangic_tarihi" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Bitiş Tarihi <span class="text-danger">*</span></label>
                            <input type="date" name="bitis_tarihi" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Açıklama</label>
                            <textarea name="aciklama" class="form-control" rows="3" placeholder="Kampanya açıklaması..."></textarea>
                        </div>
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

{{-- Silme Onay Modal --}}
<div class="modal fade" id="silModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kampanya Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="silForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Bu kampanyayı silmek istediğinize emin misiniz?</p>
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
        $('#kampanyalarTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            order: [[2, 'desc']],
            pageLength: 25
        });
    });

    function kampanyaDuzenle(kampanyaId) {
        window.location.href = '/kampanyalar/' + kampanyaId + '/duzenle';
    }

    function kampanyaSil(kampanyaId) {
        $('#silForm').attr('action', '/kampanyalar/' + kampanyaId);
        new bootstrap.Modal(document.getElementById('silModal')).show();
    }
</script>
@endpush
@endsection
