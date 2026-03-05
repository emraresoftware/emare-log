@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Abone Logları</h1>
    </div>

    {{-- Filtreler --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('loglar.abone') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="tarih_filtre" class="form-label">Tarih</label>
                        <input type="date" class="form-control" id="tarih_filtre" name="tarih" value="{{ request('tarih') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="musteri_filtre" class="form-label">Müşteri</label>
                        <select class="form-select select2" id="musteri_filtre" name="musteri_id">
                            <option value="">Tümü</option>
                            @foreach($musteriler ?? [] as $musteri)
                            <option value="{{ $musteri->id }}" {{ request('musteri_id') == $musteri->id ? 'selected' : '' }}>{{ $musteri->ad_soyad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="log_tipi" class="form-label">Log Tipi</label>
                        <select class="form-select" id="log_tipi" name="log_tipi">
                            <option value="">Tümü</option>
                            <option value="baglanti" {{ request('log_tipi') == 'baglanti' ? 'selected' : '' }}>Bağlantı</option>
                            <option value="kesinti" {{ request('log_tipi') == 'kesinti' ? 'selected' : '' }}>Kesinti</option>
                            <option value="hiz_degisiklik" {{ request('log_tipi') == 'hiz_degisiklik' ? 'selected' : '' }}>Hız Değişiklik</option>
                            <option value="odeme" {{ request('log_tipi') == 'odeme' ? 'selected' : '' }}>Ödeme</option>
                            <option value="diger" {{ request('log_tipi') == 'diger' ? 'selected' : '' }}>Diğer</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filtrele</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Abone Log Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="aboneLogTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Müşteri</th>
                        <th>Abone No</th>
                        <th>İşlem</th>
                        <th>Detay</th>
                        <th>Kullanıcı</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loglar ?? [] as $log)
                    <tr>
                        <td>{{ $log->created_at ? $log->created_at->format('d.m.Y H:i:s') : '-' }}</td>
                        <td>{{ $log->musteri->ad_soyad ?? '-' }}</td>
                        <td><code>{{ $log->abone_no ?? '-' }}</code></td>
                        <td>
                            @php
                                $tipRenk = match($log->log_tipi) {
                                    'baglanti' => 'success',
                                    'kesinti' => 'danger',
                                    'hiz_degisiklik' => 'warning',
                                    'odeme' => 'info',
                                    default => 'secondary'
                                };
                                $tipMetin = match($log->log_tipi) {
                                    'baglanti' => 'Bağlantı',
                                    'kesinti' => 'Kesinti',
                                    'hiz_degisiklik' => 'Hız Değişiklik',
                                    'odeme' => 'Ödeme',
                                    default => 'Diğer'
                                };
                            @endphp
                            <span class="badge bg-{{ $tipRenk }}">{{ $tipMetin }}</span>
                        </td>
                        <td>{{ Str::limit($log->detay, 60) }}</td>
                        <td>{{ $log->kullanici->name ?? '-' }}</td>
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
    $('.select2').select2({ theme: 'bootstrap-5' });
    $('#aboneLogTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'desc']],
        responsive: true
    });
});
</script>
@endpush
