@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Panel Logları</h1>
    </div>

    {{-- Filtreler --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('loglar.panel') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="tarih_filtre" class="form-label">Tarih</label>
                        <input type="date" class="form-control" id="tarih_filtre" name="tarih" value="{{ request('tarih') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="kullanici_filtre" class="form-label">Kullanıcı</label>
                        <select class="form-select" id="kullanici_filtre" name="kullanici_id">
                            <option value="">Tümü</option>
                            @foreach($kullanicilar ?? [] as $kullanici)
                            <option value="{{ $kullanici->id }}" {{ request('kullanici_id') == $kullanici->id ? 'selected' : '' }}>{{ $kullanici->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="islem_tipi" class="form-label">İşlem Tipi</label>
                        <select class="form-select" id="islem_tipi" name="islem_tipi">
                            <option value="">Tümü</option>
                            <option value="giris" {{ request('islem_tipi') == 'giris' ? 'selected' : '' }}>Giriş</option>
                            <option value="cikis" {{ request('islem_tipi') == 'cikis' ? 'selected' : '' }}>Çıkış</option>
                            <option value="ekleme" {{ request('islem_tipi') == 'ekleme' ? 'selected' : '' }}>Ekleme</option>
                            <option value="guncelleme" {{ request('islem_tipi') == 'guncelleme' ? 'selected' : '' }}>Güncelleme</option>
                            <option value="silme" {{ request('islem_tipi') == 'silme' ? 'selected' : '' }}>Silme</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filtrele</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Log Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="panelLogTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Kullanıcı</th>
                        <th>IP Adresi</th>
                        <th>İşlem</th>
                        <th>Detay</th>
                        <th>Modül</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loglar ?? [] as $log)
                    <tr class="
                        @if($log->islem_tipi == 'silme') table-danger
                        @elseif($log->islem_tipi == 'ekleme') table-success
                        @elseif($log->islem_tipi == 'guncelleme') table-warning
                        @elseif($log->islem_tipi == 'giris') table-info
                        @endif
                    ">
                        <td>{{ $log->created_at ? $log->created_at->format('d.m.Y H:i:s') : '-' }}</td>
                        <td>{{ $log->kullanici->name ?? '-' }}</td>
                        <td><code>{{ $log->ip_adresi }}</code></td>
                        <td>
                            @php
                                $islemRenk = match($log->islem_tipi) {
                                    'giris' => 'info',
                                    'cikis' => 'secondary',
                                    'ekleme' => 'success',
                                    'guncelleme' => 'warning',
                                    'silme' => 'danger',
                                    default => 'dark'
                                };
                                $islemMetin = match($log->islem_tipi) {
                                    'giris' => 'Giriş',
                                    'cikis' => 'Çıkış',
                                    'ekleme' => 'Ekleme',
                                    'guncelleme' => 'Güncelleme',
                                    'silme' => 'Silme',
                                    default => $log->islem_tipi
                                };
                            @endphp
                            <span class="badge bg-{{ $islemRenk }}">{{ $islemMetin }}</span>
                        </td>
                        <td>{{ Str::limit($log->detay, 60) }}</td>
                        <td><span class="badge bg-secondary">{{ $log->modul ?? '-' }}</span></td>
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
    $('#panelLogTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'desc']],
        responsive: true
    });
});
</script>
@endpush
