@extends('layouts.app')
@section('title', 'Evrak Ayarları')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-file-alt me-2"></i>Evrak Ayarları</h1>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('evrak.ayarlar') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Zorunlu Evraklar</label>
                        <textarea name="zorunlu_evraklar" class="form-control" rows="3" placeholder="Her satıra bir evrak tipi yazın">{{ $ayarlar['evrak_zorunlu_evraklar'] ?? '' }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Maksimum Dosya Boyutu (MB)</label>
                        <input type="number" name="maksimum_dosya_boyutu" class="form-control" value="{{ $ayarlar['evrak_maksimum_dosya_boyutu'] ?? 10 }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">İzin Verilen Uzantılar</label>
                        <input type="text" name="izin_verilen_uzantilar" class="form-control" value="{{ $ayarlar['evrak_izin_verilen_uzantilar'] ?? 'pdf,jpg,png,doc,docx' }}">
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