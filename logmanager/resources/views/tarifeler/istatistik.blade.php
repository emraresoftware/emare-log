@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tarife.index') }}">Tarifeler</a></li>
            <li class="breadcrumb-item active">Tarife İstatistiği</li>
        </ol>
    </nav>

    <h1 class="h3 mb-4">Tarife İstatistiği</h1>

    {{-- Grafikler --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0"><i class="fas fa-chart-bar me-2"></i>Tarife Başına Müşteri Sayısı</h5>
                </div>
                <div class="card-body">
                    <canvas id="musteriBarChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0"><i class="fas fa-chart-pie me-2"></i>Tarife Dağılımı</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="tarifePieChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Detay Tablosu --}}
    <div class="table-card card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0"><i class="fas fa-table me-2"></i>Tarife İstatistikleri</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="istatistikTable">
                    <thead class="table-light">
                        <tr>
                            <th>Tarife</th>
                            <th>Müşteri Sayısı</th>
                            <th>Aylık Gelir</th>
                            <th>Oran (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $toplamMusteri = collect($tarifeIstatistik ?? [])->sum('musteri_sayisi'); @endphp
                        @forelse($tarifeIstatistik ?? [] as $stat)
                        <tr>
                            <td><strong>{{ $stat->tarife_adi }}</strong></td>
                            <td>{{ number_format($stat->musteri_sayisi) }}</td>
                            <td>₺{{ number_format($stat->aylik_gelir, 2, ',', '.') }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar" style="width: {{ $toplamMusteri > 0 ? round(($stat->musteri_sayisi / $toplamMusteri) * 100, 1) : 0 }}%"></div>
                                    </div>
                                    <span>%{{ $toplamMusteri > 0 ? number_format(($stat->musteri_sayisi / $toplamMusteri) * 100, 1, ',', '.') : '0' }}</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                    @endforelse
                    </tbody>
                    @if(isset($tarifeIstatistik) && count($tarifeIstatistik) > 0)
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td>Toplam</td>
                            <td>{{ number_format(collect($tarifeIstatistik)->sum('musteri_sayisi')) }}</td>
                            <td>₺{{ number_format(collect($tarifeIstatistik)->sum('aylik_gelir'), 2, ',', '.') }}</td>
                            <td>%100</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        const istatistikData = @json($tarifeIstatistik ?? []);
        const labels = istatistikData.map(item => item.tarife_adi);
        const musteriSayilari = istatistikData.map(item => item.musteri_sayisi);
        const gelirler = istatistikData.map(item => item.aylik_gelir);

        const renkler = [
            '#0d6efd', '#198754', '#dc3545', '#ffc107', '#0dcaf0',
            '#6f42c1', '#fd7e14', '#20c997', '#d63384', '#6610f2',
            '#adb5bd', '#495057'
        ];

        // Bar Chart
        new Chart(document.getElementById('musteriBarChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Müşteri Sayısı',
                    data: musteriSayilari,
                    backgroundColor: renkler.slice(0, labels.length),
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        // Pie Chart
        new Chart(document.getElementById('tarifePieChart'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: musteriSayilari,
                    backgroundColor: renkler.slice(0, labels.length),
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 15 }
                    }
                }
            }
        });

        $('#istatistikTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            paging: false,
            searching: false,
            info: false,
            order: [[1, 'desc']]
        });
    });
</script>
@endpush
@endsection
