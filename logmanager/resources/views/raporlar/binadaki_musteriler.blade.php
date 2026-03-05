@extends('layouts.app')
@section('title', 'Binadaki Müşteriler')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-building me-2"></i>Binadaki Müşteriler</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Adres / Bina</label>
                    <input type="text" name="adres" class="form-control" placeholder="Adres ara..." value="{{ request('adres') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Ara</button>
                </div>
            </form>
            <div class="text-center text-muted py-4">
                <i class="fas fa-building fa-2x mb-2 d-block"></i>
                Bir bina adresi girerek o binadaki müşterileri görüntüleyin.
            </div>
        </div>
    </div>
</div>
@endsection