@extends('layouts.app')
@section('title', 'Çağrı Merkezi İstatistikleri')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-headset me-2"></i>Çağrı Merkezi İstatistikleri</h1>
    </div>
    <div class="row g-4">
        <div class="col-md-3"><div class="card bg-primary text-white text-center p-3"><h3>0</h3><small>Toplam Çağrı</small></div></div>
        <div class="col-md-3"><div class="card bg-success text-white text-center p-3"><h3>0</h3><small>Cevaplanan</small></div></div>
        <div class="col-md-3"><div class="card bg-warning text-white text-center p-3"><h3>0</h3><small>Bekleyen</small></div></div>
        <div class="col-md-3"><div class="card bg-danger text-white text-center p-3"><h3>0</h3><small>Cevapsız</small></div></div>
    </div>
</div>
@endsection