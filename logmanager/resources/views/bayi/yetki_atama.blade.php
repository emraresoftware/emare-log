@extends('layouts.app')
@section('title', 'Yetki Atama')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-user-shield me-2"></i>Yetki Atama</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Bayi Seç</label>
                        <select name="user_id" class="form-select">
                            <option value="">Bayi Seçiniz...</option>
                            @foreach($bayiler ?? [] as $bayi)
                            <option value="{{ $bayi->id }}">{{ $bayi->ad }} {{ $bayi->soyad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Yetkiler</label>
                        <div class="row">
                            @foreach(['musteri_goruntule','musteri_ekle','musteri_duzenle','fatura_goruntule','fatura_ekle','tahsilat','rapor_goruntule'] as $yetki)
                            <div class="col-md-3 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="yetkiler[]" value="{{ $yetki }}" id="yetki_{{ $yetki }}">
                                    <label class="form-check-label" for="yetki_{{ $yetki }}">{{ ucfirst(str_replace('_', ' ', $yetki)) }}</label>
                                </div>
                            </div>
                            @endforeach
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