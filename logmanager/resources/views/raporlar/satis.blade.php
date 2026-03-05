@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Satış Raporları</h1>
    </div>

    {{-- Filtreler --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('raporlar.satis') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="baslangic" class="form-label">Başlangıç Tarihi</label>
                        <input type="date" class="form-control" id="baslangic" name="baslangic" value="{{ request('baslangic') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="bitis" class="form-label">Bitiş Tarihi</label>
                        <input type="date" class="form-control" id="bitis" name="bitis" value="{{ request('bitis') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="bolge_filtre" class="form-label">Bölge</label>
                        <select class="form-select" id="bolge_filtre" name="bolge_id">
                            <option value="">Tümü</option>
                            @foreach($bolgeler ?? [] as $bolge)
                            <option value="{{ $bolge->id }}" {{ request('bolge_id') == $bolge->id ? 'selected' : '' }}>{{ $bolge->ad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="personel_filtre" class="form-label">Personel</label>
                        <select class="form-select" id="personel_filtre" name="personel_id">
                            <option value="">Tümü</option>
                            @foreach($personeller ?? [] as $personel)
                            <option value="{{ $personel->id }}" {{ request('personel_id') == $personel->id ? 'selected' : '' }}>{{ $personel->ad_soyad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
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
                        <div class="text-white-50 small">Toplam Satış</div>
                        <div class="fs-4 fw-bold">{{ $toplamSatis ?? 0 }}</div>
                    </div>
                    <i class="fas fa-chart-line fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-success text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Yeni Müşteri</div>
                        <div class="fs-4 fw-bold">{{ $yeniMusteri ?? 0 }}</div>
                    </div>
                    <i class="fas fa-user-plus fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-danger text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">İptal</div>
                        <div class="fs-4 fw-bold">{{ $iptal ?? 0 }}</div>
                    </div>
                    <i class="fas fa-user-minus fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-info text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Net Artış</div>
                        <div class="fs-4 fw-bold">{{ ($yeniMusteri ?? 0) - ($iptal ?? 0) }}</div>
                    </div>
                    <i class="fas fa-chart-bar fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Aylık Satış Trendi Grafiği --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Aylık Satış Trendi</h5>
        </div>
        <div class="card-body">
            <canvas id="satisChart" height="100"></canvas>
        </div>
    </div>

    {{-- Satış Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="satisTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Yeni Kayıt</th>
                        <th>İptal</th>
                        <th>Net</th>
                        <th>Bölge</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($satisVerileri ?? [] as $veri)
                    <tr>
                        <td>{{ $veri->tarih }}</td>
                        <td class="text-success fw-bold">+{{ $veri->yeni_kayit }}</td>
                        <td class="text-danger fw-bold">-{{ $veri->iptal }}</td>
                        <td class="fw-bold {{ $veri->net >= 0 ? 'text-success' : 'text-danger' }}">{{ $veri->net }}</td>
                        <td>{{ $veri->bolge ?? '-' }}</td>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    $('#satisTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'desc']],
        responsive: true
    });

    // Satış Trendi Grafiği
    var ctx = document.getElementById('satisChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels ?? ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Eki', 'Kas', 'Ara']) !!},
            datasets: [
                {
                    label: 'Yeni Kayıt',
                    data: {!! json_encode($chartYeniKayit ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!},
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'İptal',
                    data: {!! json_encode($chartIptal ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!},
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@endpush
