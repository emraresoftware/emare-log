@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tahsilat Raporu</h1>
    </div>

    {{-- Filtreler --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('raporlar.tahsilat') }}">
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
                        <label for="tip_filtre" class="form-label">Tahsilat Tipi</label>
                        <select class="form-select" id="tip_filtre" name="tip">
                            <option value="">Tümü</option>
                            <option value="nakit" {{ request('tip') == 'nakit' ? 'selected' : '' }}>Nakit</option>
                            <option value="havale" {{ request('tip') == 'havale' ? 'selected' : '' }}>Havale</option>
                            <option value="kredi_karti" {{ request('tip') == 'kredi_karti' ? 'selected' : '' }}>Kredi Kartı</option>
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
                        <div class="text-white-50 small">Toplam Tahsilat</div>
                        <div class="fs-4 fw-bold">₺{{ number_format($toplamTahsilat ?? 0, 2, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-success text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Nakit</div>
                        <div class="fs-4 fw-bold">₺{{ number_format($nakit ?? 0, 2, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-money-bill fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-info text-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small">Havale</div>
                        <div class="fs-4 fw-bold">₺{{ number_format($havale ?? 0, 2, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-university fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-warning text-dark p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small">Kredi Kartı</div>
                        <div class="fs-4 fw-bold">₺{{ number_format($krediKarti ?? 0, 2, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-credit-card fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Günlük Tahsilat Grafiği --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-chart-bar me-2 text-primary"></i>Günlük Tahsilat</h5>
        </div>
        <div class="card-body">
            <canvas id="tahsilatChart" height="100"></canvas>
        </div>
    </div>

    {{-- Tahsilat Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="tahsilatTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Tahsilatçı</th>
                        <th>Nakit (₺)</th>
                        <th>Havale (₺)</th>
                        <th>K.Kartı (₺)</th>
                        <th>Toplam (₺)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tahsilatVerileri ?? [] as $veri)
                    <tr>
                        <td>{{ $veri->tarih }}</td>
                        <td>{{ $veri->tahsilatci ?? '-' }}</td>
                        <td>₺{{ number_format($veri->nakit ?? 0, 2, ',', '.') }}</td>
                        <td>₺{{ number_format($veri->havale ?? 0, 2, ',', '.') }}</td>
                        <td>₺{{ number_format($veri->kredi_karti ?? 0, 2, ',', '.') }}</td>
                        <td class="fw-bold">₺{{ number_format($veri->toplam ?? 0, 2, ',', '.') }}</td>
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
    $('#tahsilatTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'desc']],
        responsive: true
    });

    // Günlük tahsilat grafiği
    var ctx = document.getElementById('tahsilatChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels ?? []) !!},
            datasets: [
                {
                    label: 'Nakit',
                    data: {!! json_encode($chartNakit ?? []) !!},
                    backgroundColor: 'rgba(25, 135, 84, 0.7)',
                },
                {
                    label: 'Havale',
                    data: {!! json_encode($chartHavale ?? []) !!},
                    backgroundColor: 'rgba(13, 202, 240, 0.7)',
                },
                {
                    label: 'Kredi Kartı',
                    data: {!! json_encode($chartKrediKarti ?? []) !!},
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true }
            }
        }
    });
});
</script>
@endpush
