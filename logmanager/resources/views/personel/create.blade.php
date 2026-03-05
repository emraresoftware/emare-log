@extends('layouts.app')
@section('title', 'Yeni Personel')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-user-plus me-2"></i>Yeni Personel</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('personel.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Ad</label>
                        <input type="text" name="ad" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Soyad</label>
                        <input type="text" name="soyad" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefon</label>
                        <input type="text" name="telefon" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">E-posta</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Departman</label>
                        <select name="departman" class="form-select">
                            <option value="teknik">Teknik</option>
                            <option value="muhasebe">Muhasebe</option>
                            <option value="satis">Satış</option>
                            <option value="destek">Destek</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Maaş</label>
                        <input type="number" name="maas" class="form-control" step="0.01">
                    </div>
                    <div class="col-12 text-end">
                        <a href="{{ route('personel.index') }}" class="btn btn-secondary me-2">İptal</a>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Kaydet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection