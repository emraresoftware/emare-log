@extends('layouts.app')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Müşteri Notları</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('anasayfa') }}">Ana Sayfa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('musteriler.index') }}">Müşteriler</a></li>
                <li class="breadcrumb-item active">Müşteri Notları</li>
            </ol>
        </nav>
    </div>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#notEkleModal">
        <i class="fas fa-plus me-1"></i> Not Ekle
    </button>
</div>

{{-- Filtre --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('musteri-notlari.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="baslangic_tarihi" class="form-label">Başlangıç Tarihi</label>
                    <input type="date" class="form-control" id="baslangic_tarihi" name="baslangic_tarihi" value="{{ request('baslangic_tarihi') }}">
                </div>
                <div class="col-md-3">
                    <label for="bitis_tarihi" class="form-label">Bitiş Tarihi</label>
                    <input type="date" class="form-control" id="bitis_tarihi" name="bitis_tarihi" value="{{ request('bitis_tarihi') }}">
                </div>
                <div class="col-md-3">
                    <label for="arama" class="form-label">Arama</label>
                    <input type="text" class="form-control" id="arama" name="arama" value="{{ request('arama') }}" placeholder="Müşteri adı veya not içeriği...">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i> Filtrele
                    </button>
                    <a href="{{ route('musteri-notlari.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-1"></i> Sıfırla
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Notlar Tablosu --}}
<div class="card table-card">
    <div class="card-body">
        @if($notlar->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover" id="notlarTable">
                <thead>
                    <tr>
                        <th>Müşteri</th>
                        <th>Not</th>
                        <th>Yazan</th>
                        <th>Tarih</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notlar as $not)
                    <tr>
                        <td>
                            <a href="{{ route('musteriler.show', $not->musteri_id) }}">
                                {{ $not->musteri->ad ?? '' }} {{ $not->musteri->soyad ?? '' }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $not->musteri->abone_no ?? '' }}</small>
                        </td>
                        <td>{{ Str::limit($not->not, 100) }}</td>
                        <td>{{ $not->yazan->name ?? 'Bilinmiyor' }}</td>
                        <td>
                            {{ $not->created_at->format('d.m.Y H:i') }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('musteriler.show', $not->musteri_id) }}#notlar" class="btn btn-outline-primary" title="Müşteri Detay">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('musteri-notlari.destroy', $not->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Sil" onclick="return confirm('Bu notu silmek istediğinize emin misiniz?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $notlar->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-sticky-note fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Henüz müşteri notu bulunmuyor</h5>
        </div>
        @endif
    </div>
</div>

{{-- Not Ekle Modal --}}
<div class="modal fade" id="notEkleModal" tabindex="-1" aria-labelledby="notEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('musteri-notlari.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="notEkleModalLabel">
                        <i class="fas fa-plus me-2"></i> Yeni Not Ekle
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modal_musteri_id" class="form-label">Müşteri</label>
                        <select class="form-select select2-modal" id="modal_musteri_id" name="musteri_id" required>
                            <option value="">Müşteri Seçiniz</option>
                            @foreach($musteriler ?? [] as $musteri)
                                <option value="{{ $musteri->id }}">{{ $musteri->abone_no }} - {{ $musteri->ad }} {{ $musteri->soyad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modal_not" class="form-label">Not</label>
                        <textarea class="form-control" id="modal_not" name="not" rows="4" placeholder="Müşteri notu..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#notlarTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            pageLength: 25,
            searching: false,
            paging: false,
            info: false,
            order: [[3, 'desc']]
        });

        // Modal içindeki Select2
        $('#notEkleModal').on('shown.bs.modal', function () {
            $('.select2-modal').select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $('#notEkleModal')
            });
        });
    });
</script>
@endpush
