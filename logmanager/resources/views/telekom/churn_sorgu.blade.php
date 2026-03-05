@extends('layouts.app')
@section('title', 'Churn Sorgu')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-search me-2"></i>Churn Sorgu</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">TC Kimlik / Abone No</label>
                    <input type="text" name="sorgu" class="form-control" placeholder="TC Kimlik veya Abone No" value="{{ request('sorgu') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Sorgula</button>
                </div>
            </form>
            <div class="text-center text-muted py-4">
                <i class="fas fa-user-slash fa-2x mb-2 d-block"></i>
                Churn durumunu sorgulamak için TC Kimlik veya Abone No girin.
            </div>
        </div>
    </div>
</div>
@endsection