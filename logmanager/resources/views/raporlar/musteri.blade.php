@extends('layouts.app')
@section('title', 'Müşteri Raporları')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-chart-bar me-2"></i>Müşteri Raporları</h1>
    </div>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white"><i class="fas fa-chart-pie me-2"></i>Durum Dağılımı</div>
                <div class="card-body">
                    <canvas id="durumChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white"><i class="fas fa-chart-pie me-2"></i>Tip Dağılımı</div>
                <div class="card-body">
                    <canvas id="tipChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white"><i class="fas fa-chart-line me-2"></i>Aylık Yeni Müşteri</div>
                <div class="card-body">
                    <canvas id="aylikChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var durumData = @json($durumDagilimi ?? []);
        var tipData = @json($tipDagilimi ?? []);
        var aylikData = @json($aylikYeniMusteri ?? []);

        if(document.getElementById('durumChart')) {
            new Chart(document.getElementById('durumChart'), {
                type: 'doughnut',
                data: {
                    labels: durumData.map(i => i.durum || 'Bilinmiyor'),
                    datasets: [{data: durumData.map(i => i.adet), backgroundColor: ['#28a745','#dc3545','#ffc107','#17a2b8','#6c757d']}]
                }
            });
        }
        if(document.getElementById('tipChart')) {
            new Chart(document.getElementById('tipChart'), {
                type: 'doughnut',
                data: {
                    labels: tipData.map(i => i.tip || 'Bilinmiyor'),
                    datasets: [{data: tipData.map(i => i.adet), backgroundColor: ['#007bff','#28a745','#ffc107','#dc3545','#6c757d']}]
                }
            });
        }
        if(document.getElementById('aylikChart')) {
            new Chart(document.getElementById('aylikChart'), {
                type: 'bar',
                data: {
                    labels: aylikData.map(i => i.yil + '/' + String(i.ay).padStart(2,'0')),
                    datasets: [{label: 'Yeni Müşteri', data: aylikData.map(i => i.adet), backgroundColor: '#17a2b8'}]
                }
            });
        }
    });
    </script>
</div>
@endsection