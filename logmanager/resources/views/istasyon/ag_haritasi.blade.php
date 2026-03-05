@extends('layouts.app')
@section('title', 'Ağ Haritası')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-map-marked-alt me-2"></i>Ağ Haritası</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body" style="height:600px;">
            <div class="text-center text-muted py-5">
                <i class="fas fa-map-marked-alt fa-3x mb-3 d-block"></i>
                <h5>Ağ Haritası</h5>
                <p>İstasyon ve verici konumlarını harita üzerinde görüntüleyin.</p>
                <div id="map" style="height:400px; background:#e9ecef; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                    <span class="text-muted">Harita yükleniyor...</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection