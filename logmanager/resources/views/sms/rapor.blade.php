@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">SMS Raporları</h1>
    </div>

    {{-- Filtreler --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('sms.rapor') }}">
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
                        <label for="durum_filtre" class="form-label">Durum</label>
                        <select class="form-select" id="durum_filtre" name="durum">
                            <option value="">Tümü</option>
                            <option value="gonderildi" {{ request('durum') == 'gonderildi' ? 'selected' : '' }}>Gönderildi</option>
                            <option value="basarisiz" {{ request('durum') == 'basarisiz' ? 'selected' : '' }}>Başarısız</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filtrele</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Özet Kartları --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card bg-primary text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Toplam Gönderilen</div>
                        <div class="fs-4 fw-bold">{{ $toplamGonderilen ?? 0 }}</div>
                    </div>
                    <i class="fas fa-paper-plane fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-success text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Başarılı</div>
                        <div class="fs-4 fw-bold">{{ $basarili ?? 0 }}</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-danger text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Başarısız</div>
                        <div class="fs-4 fw-bold">{{ $basarisiz ?? 0 }}</div>
                    </div>
                    <i class="fas fa-times-circle fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-warning text-dark p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small">Kalan Kredi</div>
                        <div class="fs-4 fw-bold">{{ $kredi ?? 0 }}</div>
                    </div>
                    <i class="fas fa-coins fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- SMS Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="smsRaporTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Alıcı</th>
                        <th>Müşteri</th>
                        <th>Mesaj</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($smsler ?? [] as $sms)
                    <tr>
                        <td>{{ $sms->created_at ? $sms->created_at->format('d.m.Y H:i') : '-' }}</td>
                        <td>{{ $sms->telefon }}</td>
                        <td>{{ $sms->musteri->ad_soyad ?? '-' }}</td>
                        <td>{{ Str::limit($sms->mesaj, 50) }}</td>
                        <td>
                            <span class="badge bg-{{ $sms->durum == 'gonderildi' ? 'success' : 'danger' }}">
                                {{ $sms->durum == 'gonderildi' ? 'Gönderildi' : 'Başarısız' }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info btn-detay" data-id="{{ $sms->id }}" title="Detay">
                                <i class="fas fa-eye"></i>
                            </button>
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
    $('#smsRaporTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'desc']],
        responsive: true
    });
});
</script>
@endpush
