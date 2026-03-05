@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Telekom Başvuruları</h1>
    </div>

    {{-- Filtreler --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('telekom.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="durum_filtre" class="form-label">Durum</label>
                        <select class="form-select" id="durum_filtre" name="durum">
                            <option value="">Tümü</option>
                            <option value="beklemede" {{ request('durum') == 'beklemede' ? 'selected' : '' }}>Beklemede</option>
                            <option value="onaylandi" {{ request('durum') == 'onaylandi' ? 'selected' : '' }}>Onaylandı</option>
                            <option value="reddedildi" {{ request('durum') == 'reddedildi' ? 'selected' : '' }}>Reddedildi</option>
                            <option value="islemde" {{ request('durum') == 'islemde' ? 'selected' : '' }}>İşlemde</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="baslangic" class="form-label">Başlangıç Tarihi</label>
                        <input type="date" class="form-control" id="baslangic" name="baslangic" value="{{ request('baslangic') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="bitis" class="form-label">Bitiş Tarihi</label>
                        <input type="date" class="form-control" id="bitis" name="bitis" value="{{ request('bitis') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filtrele</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Telekom Başvuru Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="telekomTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Başvuru No</th>
                        <th>Müşteri</th>
                        <th>Başvuru Tipi</th>
                        <th>Tarih</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($basvurular ?? [] as $basvuru)
                    <tr>
                        <td><strong>#{{ $basvuru->basvuru_no }}</strong></td>
                        <td>{{ $basvuru->musteri->ad_soyad ?? '-' }}</td>
                        <td>{{ $basvuru->basvuru_tipi }}</td>
                        <td>{{ $basvuru->created_at ? $basvuru->created_at->format('d.m.Y') : '-' }}</td>
                        <td>
                            @php
                                $durumRenk = match($basvuru->durum) {
                                    'beklemede' => 'warning',
                                    'onaylandi' => 'success',
                                    'reddedildi' => 'danger',
                                    'islemde' => 'info',
                                    default => 'secondary'
                                };
                                $durumMetin = match($basvuru->durum) {
                                    'beklemede' => 'Beklemede',
                                    'onaylandi' => 'Onaylandı',
                                    'reddedildi' => 'Reddedildi',
                                    'islemde' => 'İşlemde',
                                    default => $basvuru->durum
                                };
                            @endphp
                            <span class="badge bg-{{ $durumRenk }}">{{ $durumMetin }}</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('telekom.show', $basvuru->id) }}" class="btn btn-info" title="Detay">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-warning btn-duzenle" data-id="{{ $basvuru->id }}" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('telekom.destroy', $basvuru->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu başvuruyu silmek istediğinize emin misiniz?')">
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#telekomTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'desc']],
        responsive: true
    });
});
</script>
@endpush
