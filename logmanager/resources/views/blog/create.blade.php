@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Blog Yazısı Oluştur</h1>
        <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Geri Dön
        </a>
    </div>

    <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            {{-- İçerik --}}
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="baslik" class="form-label">Başlık <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('baslik') is-invalid @enderror" id="baslik" name="baslik" value="{{ old('baslik') }}" required>
                            @error('baslik')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="icerik" class="form-label">İçerik <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('icerik') is-invalid @enderror" id="icerik" name="icerik" rows="18" required>{{ old('icerik') }}</textarea>
                            @error('icerik')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ayarlar --}}
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Yayın Ayarları</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="durum" class="form-label">Durum</label>
                            <select class="form-select" id="durum" name="durum">
                                <option value="taslak" {{ old('durum') == 'taslak' ? 'selected' : '' }}>Taslak</option>
                                <option value="yayinda" {{ old('durum') == 'yayinda' ? 'selected' : '' }}>Yayında</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="">Seçiniz</option>
                                <option value="Duyuru" {{ old('kategori') == 'Duyuru' ? 'selected' : '' }}>Duyuru</option>
                                <option value="Haber" {{ old('kategori') == 'Haber' ? 'selected' : '' }}>Haber</option>
                                <option value="Rehber" {{ old('kategori') == 'Rehber' ? 'selected' : '' }}>Rehber</option>
                                <option value="Kampanya" {{ old('kategori') == 'Kampanya' ? 'selected' : '' }}>Kampanya</option>
                                <option value="Teknik" {{ old('kategori') == 'Teknik' ? 'selected' : '' }}>Teknik</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="etiketler" class="form-label">Etiketler</label>
                            <input type="text" class="form-control" id="etiketler" name="etiketler" value="{{ old('etiketler') }}" placeholder="Virgülle ayırın: internet, fiber, hız">
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-image me-2"></i>Kapak Görseli</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" class="form-control @error('kapak_gorseli') is-invalid @enderror" id="kapak_gorseli" name="kapak_gorseli" accept="image/*">
                            @error('kapak_gorseli')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Önerilen boyut: 1200x630 piksel</div>
                        </div>
                        <div id="gorselOnizleme" class="d-none">
                            <img id="onizlemeImg" src="#" alt="Önizleme" class="img-fluid rounded">
                        </div>
                    </div>
                </div>

                {{-- Kaydet --}}
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-1"></i> Yayınla
                    </button>
                    <a href="{{ route('blog.index') }}" class="btn btn-secondary">İptal</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Kapak görseli önizleme
    $('#kapak_gorseli').on('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#onizlemeImg').attr('src', e.target.result);
                $('#gorselOnizleme').removeClass('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            $('#gorselOnizleme').addClass('d-none');
        }
    });
});
</script>
@endpush
