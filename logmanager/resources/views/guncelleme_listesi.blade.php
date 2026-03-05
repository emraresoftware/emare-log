@extends('layouts.app')
@section('title', 'Güncelleme Listesi')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-sync-alt me-2"></i>Güncelleme Listesi</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="timeline">
                <div class="border-start border-3 border-primary ps-3 mb-4">
                    <h5 class="text-primary">v1.0.0 <small class="text-muted">- 2 Mart 2026</small></h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-plus text-success me-2"></i>Sistem ilk kurulumu tamamlandı</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Müşteri yönetimi modülü</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Fatura işlemleri modülü</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Bayi yönetimi modülü</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Mikrotik entegrasyonu</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Raporlama sistemi</li>
                        <li><i class="fas fa-plus text-success me-2"></i>SMS ve E-posta yönetimi</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Telekom modülü</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Teknik servis yönetimi</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Stok ve envanter yönetimi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection