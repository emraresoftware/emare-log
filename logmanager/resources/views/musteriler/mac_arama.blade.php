@extends('layouts.app')
@section('title', 'MAC Arama')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-search me-2"></i>MAC Arama</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">MAC Adresi</label>
                    <input type="text" name="mac" class="form-control" placeholder="AA:BB:CC:DD:EE:FF" value="{{ request('mac') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Ara</button>
                </div>
            </form>
            <div class="text-center text-muted py-4">
                <i class="fas fa-ethernet fa-2x mb-2 d-block"></i>
                MAC adresi girerek müşteri arayabilirsiniz.
            </div>
        </div>
    </div>
</div>
@endsection