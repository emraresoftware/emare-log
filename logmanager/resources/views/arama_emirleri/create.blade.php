@extends('layouts.app')
@section('title', 'Yeni Arama Emri')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-phone me-2"></i>Yeni Arama Emri</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('arama_emirleri.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Müşteri</label>
                        <select name="musteri_id" class="form-select select2">
                            <option value="">Müşteri Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Aranacak Tarih</label>
                        <input type="datetime-local" name="arama_tarihi" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Arama Sebebi</label>
                        <textarea name="sebep" class="form-control" rows="3"></textarea>
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