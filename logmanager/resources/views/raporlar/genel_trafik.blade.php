@extends('layouts.app')
@section('title', 'Genel Trafik Raporları')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-signal me-2"></i>Genel Trafik Raporları</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <canvas id="trafikChart" height="300"></canvas>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if(document.getElementById('trafikChart')) {
            new Chart(document.getElementById('trafikChart'), {
                type: 'line',
                data: {
                    labels: ['00:00','04:00','08:00','12:00','16:00','20:00','23:59'],
                    datasets: [
                        {label: 'Download (Mbps)', data: [0,0,0,0,0,0,0], borderColor: '#28a745', fill: false},
                        {label: 'Upload (Mbps)', data: [0,0,0,0,0,0,0], borderColor: '#007bff', fill: false}
                    ]
                }
            });
        }
    });
    </script>
</div>
@endsection