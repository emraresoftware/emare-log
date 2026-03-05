@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mikrotik.index') }}">Mikrotik</a></li>
            <li class="breadcrumb-item active">Mikrotik Ekle</li>
        </ol>
    </nav>

    <h1 class="h3 mb-4">Mikrotik Ekle</h1>

    <form method="POST" action="{{ route('mikrotik.store') }}">
        @csrf

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0"><i class="fas fa-server me-2"></i>Mikrotik Bilgileri</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Mikrotik Adı <span class="text-danger">*</span></label>
                        <input type="text" name="ad" class="form-control @error('ad') is-invalid @enderror" value="{{ old('ad') }}" required>
                        @error('ad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">IP Adresi <span class="text-danger">*</span></label>
                        <input type="text" name="ip_adresi" class="form-control @error('ip_adresi') is-invalid @enderror" value="{{ old('ip_adresi') }}" placeholder="192.168.1.1" required>
                        @error('ip_adresi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">API Port <span class="text-danger">*</span></label>
                        <input type="number" name="api_port" class="form-control @error('api_port') is-invalid @enderror" value="{{ old('api_port', 8728) }}" required>
                        @error('api_port')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kullanıcı Adı <span class="text-danger">*</span></label>
                        <input type="text" name="kullanici_adi" class="form-control @error('kullanici_adi') is-invalid @enderror" value="{{ old('kullanici_adi', 'admin') }}" required>
                        @error('kullanici_adi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Şifre <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="sifre" id="sifreInput" class="form-control @error('sifre') is-invalid @enderror" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="toggleSifre()">
                                <i class="fas fa-eye" id="sifreIcon"></i>
                            </button>
                        </div>
                        @error('sifre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bölge</label>
                        <select name="bolge_id" class="form-select">
                            <option value="">Seçiniz</option>
                            @foreach($bolgeler ?? [] as $bolge)
                                <option value="{{ $bolge->id }}" {{ old('bolge_id') == $bolge->id ? 'selected' : '' }}>{{ $bolge->ad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Açıklama</label>
                        <input type="text" name="aciklama" class="form-control" value="{{ old('aciklama') }}" placeholder="Mikrotik cihazı hakkında açıklama...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Durum <span class="text-danger">*</span></label>
                        <select name="durum" class="form-select" required>
                            <option value="aktif" {{ old('durum') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="pasif" {{ old('durum') == 'pasif' ? 'selected' : '' }}>Pasif</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bağlantı Test --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1">Bağlantı Testi</h6>
                        <p class="text-muted mb-0">Kaydetmeden önce bağlantıyı test edebilirsiniz.</p>
                    </div>
                    <button type="button" class="btn btn-outline-info" id="testBtn" onclick="baglantiTest()">
                        <i class="fas fa-plug me-1"></i> Bağlantı Test Et
                    </button>
                </div>
                <div id="testSonuc" class="mt-3" style="display: none;"></div>
            </div>
        </div>

        {{-- Butonlar --}}
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('mikrotik.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Geri Dön
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Mikrotik Kaydet
            </button>
        </div>

    </form>

</div>

@push('scripts')
<script>
    function toggleSifre() {
        let input = document.getElementById('sifreInput');
        let icon = document.getElementById('sifreIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function baglantiTest() {
        let ip = $('input[name="ip_adresi"]').val();
        let port = $('input[name="api_port"]').val();
        let kullanici = $('input[name="kullanici_adi"]').val();
        let sifre = $('#sifreInput').val();

        if (!ip || !port || !kullanici || !sifre) {
            toastr.warning('Lütfen tüm bağlantı bilgilerini doldurunuz.');
            return;
        }

        $('#testBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Test Ediliyor...');
        $('#testSonuc').hide();

        $.post('/mikrotik/baglanti-test', {
            _token: '{{ csrf_token() }}',
            ip_adresi: ip,
            api_port: port,
            kullanici_adi: kullanici,
            sifre: sifre
        }, function(response) {
            if (response.success) {
                $('#testSonuc').html(
                    '<div class="alert alert-success mb-0">' +
                    '<i class="fas fa-check-circle me-2"></i><strong>Bağlantı başarılı!</strong> ' +
                    (response.info ? '<br><small>Model: ' + response.info.model + ' | Versiyon: ' + response.info.version + '</small>' : '') +
                    '</div>'
                );
            } else {
                $('#testSonuc').html(
                    '<div class="alert alert-danger mb-0">' +
                    '<i class="fas fa-times-circle me-2"></i><strong>Bağlantı başarısız!</strong> ' +
                    (response.message ? '<br><small>' + response.message + '</small>' : '') +
                    '</div>'
                );
            }
            $('#testSonuc').show();
        }).fail(function() {
            $('#testSonuc').html(
                '<div class="alert alert-danger mb-0"><i class="fas fa-times-circle me-2"></i>Bağlantı testi sırasında bir hata oluştu.</div>'
            ).show();
        }).always(function() {
            $('#testBtn').prop('disabled', false).html('<i class="fas fa-plug me-1"></i> Bağlantı Test Et');
        });
    }
</script>
@endpush
@endsection
