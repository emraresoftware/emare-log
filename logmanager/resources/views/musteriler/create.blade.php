@extends('layouts.app')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Yeni Müşteri Ekle</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('anasayfa') }}">Ana Sayfa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('musteriler.index') }}">Müşteriler</a></li>
                <li class="breadcrumb-item active">Yeni Müşteri Ekle</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('musteriler.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Geri Dön
    </a>
</div>

<form action="{{ route('musteriler.store') }}" method="POST" id="musteriForm">
    @csrf

    {{-- Kimlik Bilgileri --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-id-card me-2"></i> Kimlik Bilgileri</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold">Müşteri Tipi</label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="musteri_tipi" id="tipBireysel" value="bireysel" {{ old('musteri_tipi', 'bireysel') === 'bireysel' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tipBireysel">Bireysel</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="musteri_tipi" id="tipKurumsal" value="kurumsal" {{ old('musteri_tipi') === 'kurumsal' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tipKurumsal">Kurumsal</label>
                        </div>
                    </div>
                    @error('musteri_tipi') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label for="tc_kimlik_no" class="form-label">TC Kimlik No</label>
                    <input type="text" class="form-control @error('tc_kimlik_no') is-invalid @enderror" id="tc_kimlik_no" name="tc_kimlik_no" value="{{ old('tc_kimlik_no') }}" maxlength="11" placeholder="11 haneli TC Kimlik No">
                    @error('tc_kimlik_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="ad" class="form-label">Ad</label>
                    <input type="text" class="form-control @error('ad') is-invalid @enderror" id="ad" name="ad" value="{{ old('ad') }}" required>
                    @error('ad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="soyad" class="form-label">Soyad</label>
                    <input type="text" class="form-control @error('soyad') is-invalid @enderror" id="soyad" name="soyad" value="{{ old('soyad') }}" required>
                    @error('soyad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Kurumsal Alanlar --}}
                <div class="col-md-4 kurumsal-alan" style="display:none;">
                    <label for="vergi_dairesi" class="form-label">Vergi Dairesi</label>
                    <input type="text" class="form-control @error('vergi_dairesi') is-invalid @enderror" id="vergi_dairesi" name="vergi_dairesi" value="{{ old('vergi_dairesi') }}">
                    @error('vergi_dairesi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 kurumsal-alan" style="display:none;">
                    <label for="vergi_no" class="form-label">Vergi No</label>
                    <input type="text" class="form-control @error('vergi_no') is-invalid @enderror" id="vergi_no" name="vergi_no" value="{{ old('vergi_no') }}">
                    @error('vergi_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 kurumsal-alan" style="display:none;">
                    <label for="firma_unvani" class="form-label">Firma Ünvanı</label>
                    <input type="text" class="form-control @error('firma_unvani') is-invalid @enderror" id="firma_unvani" name="firma_unvani" value="{{ old('firma_unvani') }}">
                    @error('firma_unvani') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label for="dogum_tarihi" class="form-label">Doğum Tarihi</label>
                    <input type="date" class="form-control @error('dogum_tarihi') is-invalid @enderror" id="dogum_tarihi" name="dogum_tarihi" value="{{ old('dogum_tarihi') }}">
                    @error('dogum_tarihi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label for="cinsiyet" class="form-label">Cinsiyet</label>
                    <select class="form-select @error('cinsiyet') is-invalid @enderror" id="cinsiyet" name="cinsiyet">
                        <option value="">Seçiniz</option>
                        <option value="erkek" {{ old('cinsiyet') === 'erkek' ? 'selected' : '' }}>Erkek</option>
                        <option value="kadin" {{ old('cinsiyet') === 'kadin' ? 'selected' : '' }}>Kadın</option>
                    </select>
                    @error('cinsiyet') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label for="telefon" class="form-label">Telefon</label>
                    <input type="tel" class="form-control @error('telefon') is-invalid @enderror" id="telefon" name="telefon" value="{{ old('telefon') }}" placeholder="05XX XXX XX XX" required>
                    @error('telefon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label for="eposta" class="form-label">E-Posta</label>
                    <input type="email" class="form-control @error('eposta') is-invalid @enderror" id="eposta" name="eposta" value="{{ old('eposta') }}">
                    @error('eposta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label for="uyruk" class="form-label">Uyruk</label>
                    <select class="form-select @error('uyruk') is-invalid @enderror" id="uyruk" name="uyruk">
                        <option value="tc" {{ old('uyruk', 'tc') === 'tc' ? 'selected' : '' }}>T.C.</option>
                        <option value="yabanci" {{ old('uyruk') === 'yabanci' ? 'selected' : '' }}>Yabancı</option>
                    </select>
                    @error('uyruk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Adres Bilgileri --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-map-marker-alt me-2"></i> Adres Bilgileri</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="il" class="form-label">İl</label>
                    <select class="form-select select2 @error('il') is-invalid @enderror" id="il" name="il" required>
                        <option value="">İl Seçiniz</option>
                        @if(isset($iller))
                            @foreach($iller as $il)
                                <option value="{{ $il->id }}" {{ old('il') == $il->id ? 'selected' : '' }}>{{ $il->ad }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('il') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="ilce" class="form-label">İlçe</label>
                    <select class="form-select select2 @error('ilce') is-invalid @enderror" id="ilce" name="ilce" required>
                        <option value="">Önce il seçiniz</option>
                    </select>
                    @error('ilce') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="mahalle" class="form-label">Mahalle</label>
                    <input type="text" class="form-control @error('mahalle') is-invalid @enderror" id="mahalle" name="mahalle" value="{{ old('mahalle') }}">
                    @error('mahalle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="cadde_sokak" class="form-label">Cadde / Sokak</label>
                    <input type="text" class="form-control @error('cadde_sokak') is-invalid @enderror" id="cadde_sokak" name="cadde_sokak" value="{{ old('cadde_sokak') }}">
                    @error('cadde_sokak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label for="bina_no" class="form-label">Bina No</label>
                    <input type="text" class="form-control @error('bina_no') is-invalid @enderror" id="bina_no" name="bina_no" value="{{ old('bina_no') }}">
                    @error('bina_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label for="daire_no" class="form-label">Daire No</label>
                    <input type="text" class="form-control @error('daire_no') is-invalid @enderror" id="daire_no" name="daire_no" value="{{ old('daire_no') }}">
                    @error('daire_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label for="posta_kodu" class="form-label">Posta Kodu</label>
                    <input type="text" class="form-control @error('posta_kodu') is-invalid @enderror" id="posta_kodu" name="posta_kodu" value="{{ old('posta_kodu') }}">
                    @error('posta_kodu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    {{-- Spacer --}}
                </div>
                <div class="col-md-12">
                    <label for="adres_aciklama" class="form-label">Adres Açıklama</label>
                    <textarea class="form-control @error('adres_aciklama') is-invalid @enderror" id="adres_aciklama" name="adres_aciklama" rows="2">{{ old('adres_aciklama') }}</textarea>
                    @error('adres_aciklama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Abonelik Bilgileri --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-wifi me-2"></i> Abonelik Bilgileri</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="tarife_id" class="form-label">Tarife</label>
                    <select class="form-select select2 @error('tarife_id') is-invalid @enderror" id="tarife_id" name="tarife_id" required>
                        <option value="">Tarife Seçiniz</option>
                        @foreach($tarifeler as $tarife)
                            <option value="{{ $tarife->id }}" {{ old('tarife_id') == $tarife->id ? 'selected' : '' }}>
                                {{ $tarife->ad }} - {{ number_format($tarife->fiyat, 2, ',', '.') }} ₺
                            </option>
                        @endforeach
                    </select>
                    @error('tarife_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="kampanya_id" class="form-label">Kampanya</label>
                    <select class="form-select select2 @error('kampanya_id') is-invalid @enderror" id="kampanya_id" name="kampanya_id">
                        <option value="">Kampanya Seçiniz (Opsiyonel)</option>
                        @foreach($kampanyalar ?? [] as $kampanya)
                            <option value="{{ $kampanya->id }}" {{ old('kampanya_id') == $kampanya->id ? 'selected' : '' }}>{{ $kampanya->ad }}</option>
                        @endforeach
                    </select>
                    @error('kampanya_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="bolge_id" class="form-label">Bölge</label>
                    <select class="form-select select2 @error('bolge_id') is-invalid @enderror" id="bolge_id" name="bolge_id">
                        <option value="">Bölge Seçiniz</option>
                        @foreach($bolgeler as $bolge)
                            <option value="{{ $bolge->id }}" {{ old('bolge_id') == $bolge->id ? 'selected' : '' }}>{{ $bolge->ad }}</option>
                        @endforeach
                    </select>
                    @error('bolge_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label for="hizmet_baslangic_tarihi" class="form-label">Hizmet Başlangıç Tarihi</label>
                    <input type="date" class="form-control @error('hizmet_baslangic_tarihi') is-invalid @enderror" id="hizmet_baslangic_tarihi" name="hizmet_baslangic_tarihi" value="{{ old('hizmet_baslangic_tarihi', date('Y-m-d')) }}">
                    @error('hizmet_baslangic_tarihi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label for="sozlesme_suresi" class="form-label">Sözleşme Süresi (Ay)</label>
                    <input type="number" class="form-control @error('sozlesme_suresi') is-invalid @enderror" id="sozlesme_suresi" name="sozlesme_suresi" value="{{ old('sozlesme_suresi', 12) }}" min="1">
                    @error('sozlesme_suresi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Taahhüt</label>
                    <div class="d-flex gap-3 mt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="taahhut" id="taahhutVar" value="1" {{ old('taahhut', '0') === '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="taahhutVar">Var</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="taahhut" id="taahhutYok" value="0" {{ old('taahhut', '0') === '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="taahhutYok">Yok</label>
                        </div>
                    </div>
                    @error('taahhut') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3" id="taahhutBitisAlani" style="display:none;">
                    <label for="taahhut_bitis_tarihi" class="form-label">Taahhüt Bitiş Tarihi</label>
                    <input type="date" class="form-control @error('taahhut_bitis_tarihi') is-invalid @enderror" id="taahhut_bitis_tarihi" name="taahhut_bitis_tarihi" value="{{ old('taahhut_bitis_tarihi') }}">
                    @error('taahhut_bitis_tarihi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="sanal_magaza_musterisi" id="sanal_magaza_musterisi" value="1" {{ old('sanal_magaza_musterisi') ? 'checked' : '' }}>
                        <label class="form-check-label" for="sanal_magaza_musterisi">Sanal Mağaza Müşterisi</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Teknik Bilgiler --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-server me-2"></i> Teknik Bilgiler</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="mikrotik_id" class="form-label">Mikrotik</label>
                    <select class="form-select select2 @error('mikrotik_id') is-invalid @enderror" id="mikrotik_id" name="mikrotik_id">
                        <option value="">Mikrotik Seçiniz</option>
                        @foreach($mikrotikler as $mikrotik)
                            <option value="{{ $mikrotik->id }}" {{ old('mikrotik_id') == $mikrotik->id ? 'selected' : '' }}>{{ $mikrotik->ad }}</option>
                        @endforeach
                    </select>
                    @error('mikrotik_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="hat_id" class="form-label">Hat</label>
                    <select class="form-select select2 @error('hat_id') is-invalid @enderror" id="hat_id" name="hat_id">
                        <option value="">Önce Mikrotik Seçiniz</option>
                    </select>
                    @error('hat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="ip_adresi" class="form-label">IP Adresi</label>
                    <select class="form-select select2 @error('ip_adresi') is-invalid @enderror" id="ip_adresi" name="ip_adresi">
                        <option value="">IP Adresi Seçiniz</option>
                        @if(isset($ipAdresleri))
                            @foreach($ipAdresleri as $ip)
                                <option value="{{ $ip->ip }}" {{ old('ip_adresi') == $ip->ip ? 'selected' : '' }}>{{ $ip->ip }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('ip_adresi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="mac_adresi" class="form-label">MAC Adresi</label>
                    <input type="text" class="form-control @error('mac_adresi') is-invalid @enderror" id="mac_adresi" name="mac_adresi" value="{{ old('mac_adresi') }}" placeholder="XX:XX:XX:XX:XX:XX">
                    @error('mac_adresi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="pppoe_kullanici" class="form-label">PPPoE Kullanıcı Adı</label>
                    <input type="text" class="form-control @error('pppoe_kullanici') is-invalid @enderror" id="pppoe_kullanici" name="pppoe_kullanici" value="{{ old('pppoe_kullanici') }}">
                    @error('pppoe_kullanici') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="pppoe_sifre" class="form-label">PPPoE Şifre</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('pppoe_sifre') is-invalid @enderror" id="pppoe_sifre" name="pppoe_sifre" value="{{ old('pppoe_sifre') }}">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('pppoe_sifre')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('pppoe_sifre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label for="download_hizi" class="form-label">Download Hızı (Mbps)</label>
                    <input type="number" class="form-control @error('download_hizi') is-invalid @enderror" id="download_hizi" name="download_hizi" value="{{ old('download_hizi') }}">
                    @error('download_hizi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label for="upload_hizi" class="form-label">Upload Hızı (Mbps)</label>
                    <input type="number" class="form-control @error('upload_hizi') is-invalid @enderror" id="upload_hizi" name="upload_hizi" value="{{ old('upload_hizi') }}">
                    @error('upload_hizi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label for="vlan_id" class="form-label">VLAN ID</label>
                    <input type="number" class="form-control @error('vlan_id') is-invalid @enderror" id="vlan_id" name="vlan_id" value="{{ old('vlan_id') }}">
                    @error('vlan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="modem_marka_model" class="form-label">Modem Marka / Model</label>
                    <input type="text" class="form-control @error('modem_marka_model') is-invalid @enderror" id="modem_marka_model" name="modem_marka_model" value="{{ old('modem_marka_model') }}">
                    @error('modem_marka_model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="modem_sn" class="form-label">Modem Seri No</label>
                    <input type="text" class="form-control @error('modem_sn') is-invalid @enderror" id="modem_sn" name="modem_sn" value="{{ old('modem_sn') }}">
                    @error('modem_sn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Finansal Bilgiler --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-money-bill-wave me-2"></i> Finansal Bilgiler</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="odeme_yontemi" class="form-label">Ödeme Yöntemi</label>
                    <select class="form-select @error('odeme_yontemi') is-invalid @enderror" id="odeme_yontemi" name="odeme_yontemi">
                        <option value="">Seçiniz</option>
                        <option value="nakit" {{ old('odeme_yontemi') === 'nakit' ? 'selected' : '' }}>Nakit</option>
                        <option value="havale" {{ old('odeme_yontemi') === 'havale' ? 'selected' : '' }}>Havale / EFT</option>
                        <option value="kredi_karti" {{ old('odeme_yontemi') === 'kredi_karti' ? 'selected' : '' }}>Kredi Kartı</option>
                        <option value="otomatik_cekim" {{ old('odeme_yontemi') === 'otomatik_cekim' ? 'selected' : '' }}>Otomatik Çekim</option>
                    </select>
                    @error('odeme_yontemi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="fatura_tipi" class="form-label">Fatura Tipi</label>
                    <select class="form-select @error('fatura_tipi') is-invalid @enderror" id="fatura_tipi" name="fatura_tipi">
                        <option value="">Seçiniz</option>
                        <option value="e-fatura" {{ old('fatura_tipi') === 'e-fatura' ? 'selected' : '' }}>E-Fatura</option>
                        <option value="e-arsiv" {{ old('fatura_tipi') === 'e-arsiv' ? 'selected' : '' }}>E-Arşiv</option>
                        <option value="matbu" {{ old('fatura_tipi') === 'matbu' ? 'selected' : '' }}>Matbu</option>
                    </select>
                    @error('fatura_tipi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Notlar --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-sticky-note me-2"></i> Notlar</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-12">
                    <label for="not" class="form-label">Not</label>
                    <textarea class="form-control @error('not') is-invalid @enderror" id="not" name="not" rows="3" placeholder="Müşteri ile ilgili notlarınız...">{{ old('not') }}</textarea>
                    @error('not') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Kaydet Butonu --}}
    <div class="d-flex justify-content-end mb-4">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-save me-1"></i> Müşteri Kaydet
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Select2 başlat
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        // Müşteri tipi değişimi
        $('input[name="musteri_tipi"]').on('change', function() {
            if ($(this).val() === 'kurumsal') {
                $('.kurumsal-alan').show();
            } else {
                $('.kurumsal-alan').hide();
            }
        });

        // Sayfa yüklendiğinde kontrol
        if ($('input[name="musteri_tipi"]:checked').val() === 'kurumsal') {
            $('.kurumsal-alan').show();
        }

        // Taahhüt değişimi
        $('input[name="taahhut"]').on('change', function() {
            if ($(this).val() === '1') {
                $('#taahhutBitisAlani').show();
            } else {
                $('#taahhutBitisAlani').hide();
            }
        });

        if ($('input[name="taahhut"]:checked').val() === '1') {
            $('#taahhutBitisAlani').show();
        }

        // İl - İlçe bağımlı seçim
        $('#il').on('change', function() {
            let ilId = $(this).val();
            $('#ilce').html('<option value="">Yükleniyor...</option>');
            if (ilId) {
                $.get('/api/iller/' + ilId + '/ilceler', function(data) {
                    let options = '<option value="">İlçe Seçiniz</option>';
                    data.forEach(function(ilce) {
                        options += '<option value="' + ilce.id + '">' + ilce.ad + '</option>';
                    });
                    $('#ilce').html(options);
                });
            } else {
                $('#ilce').html('<option value="">Önce il seçiniz</option>');
            }
        });

        // Mikrotik - Hat bağımlı seçim
        $('#mikrotik_id').on('change', function() {
            let mikrotikId = $(this).val();
            $('#hat_id').html('<option value="">Yükleniyor...</option>');
            if (mikrotikId) {
                $.get('/api/mikrotikler/' + mikrotikId + '/hatlar', function(data) {
                    let options = '<option value="">Hat Seçiniz</option>';
                    data.forEach(function(hat) {
                        options += '<option value="' + hat.id + '">' + hat.ad + '</option>';
                    });
                    $('#hat_id').html(options);
                });
            } else {
                $('#hat_id').html('<option value="">Önce Mikrotik Seçiniz</option>');
            }
        });
    });

    function togglePassword(fieldId) {
        let field = document.getElementById(fieldId);
        field.type = field.type === 'password' ? 'text' : 'password';
    }
</script>
@endpush
