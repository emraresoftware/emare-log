@extends('layouts.app')
@section('title', 'Evrak Detayı')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-file-alt me-2"></i>Evrak Detayı</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="text-center py-4">
                <i class="fas fa-file-alt fa-3x mb-3 text-primary"></i>
                <h5>Evrak bilgileri yükleniyor...</h5>
            </div>
        </div>
    </div>
</div>
@endsection