@extends('layouts.app')
@section('title', 'Yeni Teknik Servis Kaydı')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-tools me-2"></i>Yeni Teknik Servis Kaydı</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('teknik_servis.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Müşteri</label>
                        <select name="musteri_id" class="form-select select2">
                            <option value="">Müşteri Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Servis Tipi</label>
                        <select name="tip" class="form-select">
                            <option value="ariza">Arıza</option>
                            <option value="kurulum">Kurulum</option>
                            <option value="bakim">Bakım</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Açıklama</label>
                        <textarea name="aciklama" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Öncelik</label>
                        <select name="oncelik" class="form-select">
                            <option value="dusuk">Düşük</option>
                            <option value="normal">Normal</option>
                            <option value="yuksek">Yüksek</option>
                            <option value="acil">Acil</option>
                        </select>
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