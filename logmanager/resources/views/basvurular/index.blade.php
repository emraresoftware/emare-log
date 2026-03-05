@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Başvurular</h1>
        <a href="{{ route('basvurular.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Yeni Başvuru
        </a>
    </div>

    {{-- Filtreler --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('basvurular.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="durum_filtre" class="form-label">Durum</label>
                        <select class="form-select" id="durum_filtre" name="durum">
                            <option value="">Tümü</option>
                            <option value="beklemede" {{ request('durum') == 'beklemede' ? 'selected' : '' }}>Beklemede</option>
                            <option value="onaylandi" {{ request('durum') == 'onaylandi' ? 'selected' : '' }}>Onaylandı</option>
                            <option value="reddedildi" {{ request('durum') == 'reddedildi' ? 'selected' : '' }}>Reddedildi</option>
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

    {{-- Başvuru Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="basvuruTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Başvuru No</th>
                        <th>Ad Soyad</th>
                        <th>TC</th>
                        <th>Telefon</th>
                        <th>Tarife</th>
                        <th>Tarih</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($basvurular ?? [] as $basvuru)
                    <tr>
                        <td><strong>#{{ $basvuru->basvuru_no }}</strong></td>
                        <td>{{ $basvuru->ad }} {{ $basvuru->soyad }}</td>
                        <td>{{ $basvuru->tc_no ?? '-' }}</td>
                        <td>{{ $basvuru->telefon }}</td>
                        <td>{{ $basvuru->tarife->ad ?? '-' }}</td>
                        <td>{{ $basvuru->created_at ? $basvuru->created_at->format('d.m.Y') : '-' }}</td>
                        <td>
                            @php
                                $durumRenk = match($basvuru->durum) {
                                    'beklemede' => 'warning',
                                    'onaylandi' => 'success',
                                    'reddedildi' => 'danger',
                                    default => 'secondary'
                                };
                                $durumMetin = match($basvuru->durum) {
                                    'beklemede' => 'Beklemede',
                                    'onaylandi' => 'Onaylandı',
                                    'reddedildi' => 'Reddedildi',
                                    default => $basvuru->durum
                                };
                            @endphp
                            <span class="badge bg-{{ $durumRenk }}">{{ $durumMetin }}</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($basvuru->durum == 'beklemede')
                                <form action="{{ route('basvurular.onayla', $basvuru->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success" title="Onayla"><i class="fas fa-check"></i></button>
                                </form>
                                <form action="{{ route('basvurular.reddet', $basvuru->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger" title="Reddet"><i class="fas fa-times"></i></button>
                                </form>
                                @endif
                                <a href="{{ route('basvurular.edit', $basvuru->id) }}" class="btn btn-warning" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('basvurular.show', $basvuru->id) }}" class="btn btn-info" title="Detay">
                                    <i class="fas fa-eye"></i>
                                </a>
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
    $('#basvuruTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'desc']],
        responsive: true
    });
});
</script>
@endpush
