@extends('layouts.app')
@section('title', 'Müşteri Taşıma')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-exchange-alt me-2"></i>Müşteri Taşıma</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Kaynak Bayi</label>
                        <select name="kaynak_bayi_id" class="form-select">
                            <option value="">Bayi Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Hedef Bayi</label>
                        <select name="hedef_bayi_id" class="form-select">
                            <option value="">Bayi Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-warning w-100"><i class="fas fa-sync me-1"></i> Taşı</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection