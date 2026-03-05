@extends('layouts.app')
@section('title', 'Ürün Gönder')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-shipping-fast me-2"></i>Ürün Gönder</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Ürün</label>
                        <select name="urun_id" class="form-select select2">
                            <option value="">Ürün Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Hedef Depo / Müşteri</label>
                        <select name="hedef" class="form-select">
                            <option value="">Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Adet</label>
                        <input type="number" name="adet" class="form-control" value="1" min="1">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Açıklama</label>
                        <input type="text" name="aciklama" class="form-control">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane me-1"></i> Gönder</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection