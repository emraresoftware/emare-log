@extends('layouts.app')
@section('title', 'WhatsApp Ayarları')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-fab fa-whatsapp me-2"></i>WhatsApp Ayarları</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('whatsapp.ayar_kaydet') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">API Anahtarı</label>
                        <input type="text" name="api_key" class="form-control" placeholder="WhatsApp Business API Key">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefon Numarası</label>
                        <input type="text" name="telefon" class="form-control" placeholder="+90 5XX XXX XX XX">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Webhook URL</label>
                        <input type="text" name="webhook_url" class="form-control" placeholder="https://...">
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="aktif" id="wpAktif">
                            <label class="form-check-label" for="wpAktif">WhatsApp Entegrasyonu Aktif</label>
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