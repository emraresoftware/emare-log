@extends('layouts.app')
@section('title', 'Log Sunucusu Durum')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-server me-2"></i>Log Sunucusu Durum</h1>
    </div>
    <div class="row g-4">
        <div class="col-md-4"><div class="card bg-success text-white text-center p-3"><i class="fas fa-check-circle fa-2x mb-2"></i><h5>Aktif</h5><small>Log Sunucusu</small></div></div>
        <div class="col-md-4"><div class="card bg-info text-white text-center p-3"><i class="fas fa-database fa-2x mb-2"></i><h5>0 GB</h5><small>Disk Kullanımı</small></div></div>
        <div class="col-md-4"><div class="card bg-warning text-white text-center p-3"><i class="fas fa-clock fa-2x mb-2"></i><h5>0 gün</h5><small>Uptime</small></div></div>
    </div>
</div>
@endsection