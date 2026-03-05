@extends('layouts.app')
@section('title', 'Araç Takip Ayarları')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-car me-2"></i>Araç Takip Ayarları</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">GPS API Anahtarı</label>
                        <input type="text" name="gps_api_key" class="form-control" placeholder="API Key">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Güncelleme Sıklığı (dakika)</label>
                        <input type="number" name="guncelleme_sikligi" class="form-control" value="5" min="1">
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="aktif" id="takipAktif" checked>
                            <label class="form-check-label" for="takipAktif">Takip Aktif</label>
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Kaydet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection