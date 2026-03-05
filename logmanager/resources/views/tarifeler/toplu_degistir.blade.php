@extends('layouts.app')
@section('title', 'Toplu Tarife Değiştir')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-exchange-alt me-2"></i>Toplu Tarife Değiştir</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="#">
                @csrf
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Mevcut Tarife</label>
                        <select name="mevcut_tarife_id" class="form-select">
                            <option value="">Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Yeni Tarife</label>
                        <select name="yeni_tarife_id" class="form-select">
                            <option value="">Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-warning w-100"><i class="fas fa-sync me-1"></i> Değiştir</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection