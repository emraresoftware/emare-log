#!/usr/bin/env php
<?php
/**
 * Bulk create all missing blade views for Hiper Log ISP Management System
 */

$basePath = __DIR__ . '/resources/views';

// Helper function to create a standard list page
function listPage($title, $tableHeaders, $emptyMsg = 'Kayıt bulunamadı.', $extraContent = '') {
    $headerRows = '';
    foreach ($tableHeaders as $h) {
        $headerRows .= "                                <th>{$h}</th>\n";
    }
    return <<<BLADE
@extends('layouts.app')
@section('title', '{$title}')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-list me-2"></i>{$title}</h1>
    </div>
{$extraContent}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="dataTable">
                    <thead class="table-dark">
                        <tr>
{$headerRows}                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="100%" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                {$emptyMsg}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
BLADE;
}

// Helper for simple info/settings page
function infoPage($title, $icon, $content = '') {
    if (!$content) {
        $content = <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="text-center text-muted py-5">
                <i class="fas fa-{$icon} fa-3x mb-3 d-block"></i>
                <h5>Bu bölüm henüz yapılandırılmamış.</h5>
                <p>Ayarları düzenlemek için gerekli bilgileri girin.</p>
            </div>
        </div>
    </div>
HTML;
    }
    return <<<BLADE
@extends('layouts.app')
@section('title', '{$title}')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-{$icon} me-2"></i>{$title}</h1>
    </div>
{$content}
</div>
@endsection
BLADE;
}

// All views to create: [path => [title, icon/type, headers/content]]
$views = [
    // ===================== MÜŞTERİLER =====================
    'musteriler/interneti_kesilenler' => listPage('İnterneti Kesilenler', ['#', 'Müşteri', 'Tarife', 'Bölge', 'Son Kesinti', 'Durum', 'İşlem']),
    'musteriler/onay_bekleyen' => listPage('Onay Bekleyen Müşteriler', ['#', 'Ad Soyad', 'TC Kimlik', 'Tarife', 'Başvuru Tarihi', 'Durum', 'İşlem']),
    'musteriler/on_basvurular' => listPage('Ön Başvurular', ['#', 'Ad Soyad', 'Telefon', 'Adres', 'Tarih', 'Durum', 'İşlem']),
    'musteriler/online_basvurular' => listPage('Online Başvurular', ['#', 'Ad Soyad', 'E-posta', 'Telefon', 'Tarife', 'Tarih', 'Durum']),
    'musteriler/e_devlet_basvurular' => listPage('E-Devlet Başvuruları', ['#', 'TC Kimlik', 'Ad Soyad', 'Başvuru No', 'Tarih', 'Durum', 'İşlem']),
    'musteriler/gruplar' => listPage('Müşteri Grupları', ['#', 'Grup Adı', 'Müşteri Sayısı', 'Açıklama', 'İşlem']),
    'musteriler/tarife_gecis_istekleri' => listPage('Tarife Geçiş İstekleri', ['#', 'Müşteri', 'Mevcut Tarife', 'İstenen Tarife', 'Tarih', 'Durum', 'İşlem']),
    'musteriler/mac_arama' => infoPage('MAC Arama', 'search', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">MAC Adresi</label>
                    <input type="text" name="mac" class="form-control" placeholder="AA:BB:CC:DD:EE:FF" value="{{ request('mac') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Ara</button>
                </div>
            </form>
            <div class="text-center text-muted py-4">
                <i class="fas fa-ethernet fa-2x mb-2 d-block"></i>
                MAC adresi girerek müşteri arayabilirsiniz.
            </div>
        </div>
    </div>
HTML),
    'musteriler/yabanci' => listPage('Yabancı Müşteriler', ['#', 'Ad Soyad', 'Pasaport No', 'Uyruk', 'Tarife', 'Durum', 'İşlem']),
    'musteriler/vlan' => listPage('VLAN Müşterileri', ['#', 'Müşteri', 'VLAN ID', 'IP Adresi', 'Port', 'Durum']),
    'musteriler/yasaklanan_tcler' => listPage('Yasaklanan TC Kimlik Numaraları', ['#', 'TC Kimlik', 'Sebep', 'Ekleyen', 'Tarih', 'İşlem']),
    'musteriler/odeme_loglari' => listPage('Ödeme Logları', ['#', 'Müşteri', 'Tutar', 'Ödeme Tipi', 'Tarih', 'Durum', 'Detay']),

    // ===================== FATURALAR =====================
    'faturalar/odenmis' => listPage('Ödenmiş Faturalar', ['#', 'Fatura No', 'Müşteri', 'Tutar', 'Ödeme Tarihi', 'Ödeme Tipi', 'Detay']),
    'faturalar/bekleyen_siparisler' => listPage('Bekleyen Siparişler', ['#', 'Sipariş No', 'Müşteri', 'Tutar', 'Tarih', 'Durum', 'İşlem']),
    'faturalar/iptal' => listPage('İptal Edilen Faturalar', ['#', 'Fatura No', 'Müşteri', 'Tutar', 'İptal Tarihi', 'Sebep', 'Detay']),
    'faturalar/havale_bildirimleri' => listPage('Havale Bildirimleri', ['#', 'Müşteri', 'Banka', 'Tutar', 'Tarih', 'Durum', 'İşlem']),
    'faturalar/taahhutlu' => listPage('Taahhütlü Müşteriler', ['#', 'Müşteri', 'Tarife', 'Taahhüt Başlangıç', 'Taahhüt Bitiş', 'Durum', 'İşlem']),
    'faturalar/otomatik_cekimler' => listPage('Otomatik Çekimler', ['#', 'Müşteri', 'Kart Bilgisi', 'Tutar', 'Son Çekim', 'Durum', 'İşlem']),
    'faturalar/otomatik_talimatlar' => listPage('Otomatik Ödeme Talimatları', ['#', 'Müşteri', 'Banka', 'Hesap No', 'Tutar', 'Durum', 'İşlem']),
    'faturalar/paynkolay_rapor' => listPage('PaynKolay Raporu', ['#', 'İşlem No', 'Müşteri', 'Tutar', 'Tarih', 'Durum']),
    'faturalar/offline_tahsilatlar' => listPage('Offline Tahsilat Dosyaları', ['#', 'Dosya Adı', 'Yükleme Tarihi', 'Kayıt Sayısı', 'Durum', 'İşlem']),
    'faturalar/e_fatura_hata' => listPage('E-Fatura Hataları', ['#', 'Fatura No', 'Müşteri', 'Hata Kodu', 'Hata Mesajı', 'Tarih', 'İşlem']),

    // ===================== TARİFELER =====================
    'tarifeler/toplu_degistir' => infoPage('Toplu Tarife Değiştir', 'exchange-alt', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="#">
                @csrf
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Mevcut Tarife</label>
                        <select name="mevcut_tarife_id" class="form-select">
                            <option value="">Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Yeni Tarife</label>
                        <select name="yeni_tarife_id" class="form-select">
                            <option value="">Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-warning w-100"><i class="fas fa-sync me-1"></i> Değiştir</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
HTML),

    // ===================== KASA =====================
    'kasa/cari_faturalar' => listPage('Cari Faturalar', ['#', 'Cari Hesap', 'Fatura No', 'Tutar', 'Tarih', 'Durum', 'İşlem']),
    'stok/depolar' => listPage('Depolar', ['#', 'Depo Adı', 'Konum', 'Ürün Sayısı', 'Durum', 'İşlem']),

    // ===================== TEKNİK SERVİS =====================
    'teknik_servis/create' => infoPage('Yeni Teknik Servis Kaydı', 'tools', <<<HTML
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
HTML),
    'teknik_servis/rapor' => listPage('Teknik Servis Raporu', ['#', 'Tarih', 'Müşteri', 'Servis Tipi', 'Teknisyen', 'Durum', 'Süre']),

    // ===================== ARAMA EMİRLERİ =====================
    'arama_emirleri/index' => listPage('Arama Emirleri', ['#', 'Müşteri', 'Sebep', 'Aranacak Tarih', 'Atanan Personel', 'Durum', 'İşlem']),
    'arama_emirleri/create' => infoPage('Yeni Arama Emri', 'phone', <<<HTML
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
HTML),

    // ===================== BAYİ =====================
    'bayi/musteriler' => listPage('Bayi Müşterileri', ['#', 'Ad Soyad', 'Tarife', 'Durum', 'Kayıt Tarihi', 'İşlem']),
    'bayi/bolgeler' => listPage('Bölgeler', ['#', 'Bölge Adı', 'Müşteri Sayısı', 'Açıklama', 'İşlem']),
    'bayi/devreler' => listPage('Devre Listesi', ['#', 'Devre No', 'Müşteri', 'Bayi', 'Durum', 'Tarih', 'İşlem']),
    'bayi/duyurular' => listPage('Bayi Duyuruları', ['#', 'Başlık', 'İçerik', 'Tarih', 'Durum', 'İşlem']),
    'bayi/kasa' => listPage('Bayi Kasa', ['#', 'Kasa Adı', 'Bakiye', 'Son İşlem', 'Durum', 'İşlem']),
    'bayi/kasa_kullanici' => listPage('Bayi Kasa Kullanıcıları', ['#', 'Kullanıcı', 'Kasa', 'Yetki', 'Son Giriş', 'İşlem']),
    'bayi/kasa_hareket' => listPage('Bayi Kasa Hareketleri', ['#', 'Tarih', 'İşlem Tipi', 'Tutar', 'Açıklama', 'Yapan']),
    'bayi/musteri_tasima' => infoPage('Müşteri Taşıma', 'exchange-alt', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Kaynak Bayi</label>
                        <select name="kaynak_bayi_id" class="form-select">
                            <option value="">Bayi Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Hedef Bayi</label>
                        <select name="hedef_bayi_id" class="form-select">
                            <option value="">Bayi Seçiniz...</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-warning w-100"><i class="fas fa-sync me-1"></i> Taşı</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
HTML),
    'bayi/tickets' => listPage('Bayi Destek Talepleri', ['#', 'Konu', 'Öncelik', 'Durum', 'Tarih', 'Son Güncelleme', 'İşlem']),
    'bayi/yetkiler' => listPage('Bayi Yetkileri', ['#', 'Bayi', 'Yetkiler', 'Son Güncelleme', 'İşlem']),
    'bayi/yetki_atama' => infoPage('Yetki Atama', 'user-shield', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Bayi Seç</label>
                        <select name="user_id" class="form-select">
                            <option value="">Bayi Seçiniz...</option>
                            @foreach(\$bayiler ?? [] as \$bayi)
                            <option value="{{ \$bayi->id }}">{{ \$bayi->ad }} {{ \$bayi->soyad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Yetkiler</label>
                        <div class="row">
                            @foreach(['musteri_goruntule','musteri_ekle','musteri_duzenle','fatura_goruntule','fatura_ekle','tahsilat','rapor_goruntule'] as \$yetki)
                            <div class="col-md-3 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="yetkiler[]" value="{{ \$yetki }}" id="yetki_{{ \$yetki }}">
                                    <label class="form-check-label" for="yetki_{{ \$yetki }}">{{ ucfirst(str_replace('_', ' ', \$yetki)) }}</label>
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
HTML),

    // ===================== MİKROTİK =====================
    'mikrotik/hata_raporu' => listPage('Mikrotik Hata Raporu', ['#', 'Cihaz', 'Hata Tipi', 'Mesaj', 'Tarih', 'Çözüm Durumu']),
    'mikrotik/vpn_listesi' => listPage('VPN Kullanıcıları', ['#', 'Kullanıcı', 'Müşteri', 'Mikrotik', 'IP', 'Durum', 'İşlem']),
    'mikrotik/ppp_listesi' => listPage('PPP Kullanıcıları', ['#', 'Kullanıcı', 'Servis', 'Profil', 'IP', 'Durum', 'İşlem']),
    'mikrotik/ip_yonetim' => listPage('IP Yönetimi', ['#', 'IP Adresi', 'Subnet', 'Mikrotik', 'Atanan Müşteri', 'Durum', 'İşlem']),

    // ===================== HATLAR =====================
    'hatlar/kapasite' => listPage('Hat Kapasite Raporu', ['#', 'Hat Adı', 'Kapasite', 'Kullanım', 'Kullanım %', 'Durum']),
    'hatlar/ip_hatali' => listPage('IP Hatalı Hatlar', ['#', 'Hat Adı', 'IP Adresi', 'Hata', 'Tarih', 'İşlem']),

    // ===================== İSTASYON =====================
    'istasyon/vericiler' => listPage('Vericiler', ['#', 'Verici Adı', 'İstasyon', 'Frekans', 'Güç', 'Bağlı Müşteri', 'Durum', 'İşlem']),
    'istasyon/ag_haritasi' => infoPage('Ağ Haritası', 'map-marked-alt', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body" style="height:600px;">
            <div class="text-center text-muted py-5">
                <i class="fas fa-map-marked-alt fa-3x mb-3 d-block"></i>
                <h5>Ağ Haritası</h5>
                <p>İstasyon ve verici konumlarını harita üzerinde görüntüleyin.</p>
                <div id="map" style="height:400px; background:#e9ecef; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                    <span class="text-muted">Harita yükleniyor...</span>
                </div>
            </div>
        </div>
    </div>
HTML),

    // ===================== TELEKOM =====================
    'telekom/degisiklik_basvurulari' => listPage('Değişiklik Başvuruları', ['#', 'Müşteri', 'Değişiklik Tipi', 'Mevcut', 'İstenen', 'Tarih', 'Durum', 'İşlem']),
    'telekom/olo_ariza_listesi' => listPage('OLO Arıza Listesi', ['#', 'Arıza No', 'Müşteri', 'Devre', 'Açıklama', 'Tarih', 'Durum', 'İşlem']),
    'telekom/olo_ariza_teyit' => listPage('OLO Arıza Teyit', ['#', 'Arıza No', 'Müşteri', 'Teyit Durumu', 'Tarih', 'İşlem']),
    'telekom/genel_ariza' => listPage('Genel Arıza', ['#', 'Arıza No', 'Bölge', 'Açıklama', 'Başlangıç', 'Bitiş', 'Durum']),
    'telekom/churn_sorgu' => infoPage('Churn Sorgu', 'search', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">TC Kimlik / Abone No</label>
                    <input type="text" name="sorgu" class="form-control" placeholder="TC Kimlik veya Abone No" value="{{ request('sorgu') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Sorgula</button>
                </div>
            </form>
            <div class="text-center text-muted py-4">
                <i class="fas fa-user-slash fa-2x mb-2 d-block"></i>
                Churn durumunu sorgulamak için TC Kimlik veya Abone No girin.
            </div>
        </div>
    </div>
HTML),
    'telekom/churn_listesi' => listPage('Churn Başvuruları', ['#', 'Müşteri', 'TC Kimlik', 'Tarife', 'Başvuru Tarihi', 'Durum', 'İşlem']),
    'telekom/durum_raporu' => listPage('Telekom Durum Raporu', ['#', 'Başvuru Tipi', 'Toplam', 'Bekleyen', 'Onaylanan', 'Reddedilen']),
    'telekom/vae_faturalar' => listPage('TT VAE Faturalar', ['#', 'Fatura No', 'Müşteri', 'Tutar', 'Dönem', 'Durum', 'İşlem']),

    // ===================== PERSONEL =====================
    'personel/create' => infoPage('Yeni Personel', 'user-plus', <<<HTML
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
HTML),
    'personel/hakedis' => listPage('Personel Hakediş', ['#', 'Personel', 'Dönem', 'Maaş', 'Prim', 'Kesinti', 'Net Ödeme', 'Durum']),

    // ===================== STOK =====================
    'stok/arizali_urunler' => listPage('Arızalı Ürünler', ['#', 'Ürün', 'Seri No', 'Arıza Açıklaması', 'Müşteri', 'Tarih', 'Durum']),
    'stok/musterideki_urunler' => listPage('Müşterideki Ürünler', ['#', 'Ürün', 'Seri No', 'Müşteri', 'Teslim Tarihi', 'Durum', 'İşlem']),
    'stok/sokum_listesi' => listPage('Söküm Listesi', ['#', 'Ürün', 'Seri No', 'Müşteri', 'Söküm Tarihi', 'Teknisyen', 'İşlem']),
    'stok/urun_gonder' => infoPage('Ürün Gönder', 'shipping-fast', <<<HTML
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
HTML),

    // ===================== ARAÇLAR =====================
    'araclar/takip_ayar' => infoPage('Araç Takip Ayarları', 'car', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">GPS API Anahtarı</label>
                        <input type="text" name="gps_api_key" class="form-control" placeholder="API Key">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Güncelleme Sıklığı (dakika)</label>
                        <input type="number" name="guncelleme_sikligi" class="form-control" value="5" min="1">
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="aktif" id="takipAktif" checked>
                            <label class="form-check-label" for="takipAktif">Takip Aktif</label>
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Kaydet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
HTML),

    // ===================== EVRAK =====================
    'evrak/ayarlar' => infoPage('Evrak Ayarları', 'file-alt', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('evrak.ayarlar') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Zorunlu Evraklar</label>
                        <textarea name="zorunlu_evraklar" class="form-control" rows="3" placeholder="Her satıra bir evrak tipi yazın">{{ \$ayarlar['evrak_zorunlu_evraklar'] ?? '' }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Maksimum Dosya Boyutu (MB)</label>
                        <input type="number" name="maksimum_dosya_boyutu" class="form-control" value="{{ \$ayarlar['evrak_maksimum_dosya_boyutu'] ?? 10 }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">İzin Verilen Uzantılar</label>
                        <input type="text" name="izin_verilen_uzantilar" class="form-control" value="{{ \$ayarlar['evrak_izin_verilen_uzantilar'] ?? 'pdf,jpg,png,doc,docx' }}">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Kaydet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
HTML),
    'evrak/show' => infoPage('Evrak Detayı', 'file-alt', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="text-center py-4">
                <i class="fas fa-file-alt fa-3x mb-3 text-primary"></i>
                <h5>Evrak bilgileri yükleniyor...</h5>
            </div>
        </div>
    </div>
HTML),

    // ===================== RAPORLAR =====================
    'raporlar/musteri' => infoPage('Müşteri Raporları', 'chart-bar', <<<HTML
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white"><i class="fas fa-chart-pie me-2"></i>Durum Dağılımı</div>
                <div class="card-body">
                    <canvas id="durumChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white"><i class="fas fa-chart-pie me-2"></i>Tip Dağılımı</div>
                <div class="card-body">
                    <canvas id="tipChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white"><i class="fas fa-chart-line me-2"></i>Aylık Yeni Müşteri</div>
                <div class="card-body">
                    <canvas id="aylikChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var durumData = @json(\$durumDagilimi ?? []);
        var tipData = @json(\$tipDagilimi ?? []);
        var aylikData = @json(\$aylikYeniMusteri ?? []);

        if(document.getElementById('durumChart')) {
            new Chart(document.getElementById('durumChart'), {
                type: 'doughnut',
                data: {
                    labels: durumData.map(i => i.durum || 'Bilinmiyor'),
                    datasets: [{data: durumData.map(i => i.adet), backgroundColor: ['#28a745','#dc3545','#ffc107','#17a2b8','#6c757d']}]
                }
            });
        }
        if(document.getElementById('tipChart')) {
            new Chart(document.getElementById('tipChart'), {
                type: 'doughnut',
                data: {
                    labels: tipData.map(i => i.tip || 'Bilinmiyor'),
                    datasets: [{data: tipData.map(i => i.adet), backgroundColor: ['#007bff','#28a745','#ffc107','#dc3545','#6c757d']}]
                }
            });
        }
        if(document.getElementById('aylikChart')) {
            new Chart(document.getElementById('aylikChart'), {
                type: 'bar',
                data: {
                    labels: aylikData.map(i => i.yil + '/' + String(i.ay).padStart(2,'0')),
                    datasets: [{label: 'Yeni Müşteri', data: aylikData.map(i => i.adet), backgroundColor: '#17a2b8'}]
                }
            });
        }
    });
    </script>
HTML),
    'raporlar/cagri_istatistikleri' => infoPage('Çağrı Merkezi İstatistikleri', 'headset', <<<HTML
    <div class="row g-4">
        <div class="col-md-3"><div class="card bg-primary text-white text-center p-3"><h3>0</h3><small>Toplam Çağrı</small></div></div>
        <div class="col-md-3"><div class="card bg-success text-white text-center p-3"><h3>0</h3><small>Cevaplanan</small></div></div>
        <div class="col-md-3"><div class="card bg-warning text-white text-center p-3"><h3>0</h3><small>Bekleyen</small></div></div>
        <div class="col-md-3"><div class="card bg-danger text-white text-center p-3"><h3>0</h3><small>Cevapsız</small></div></div>
    </div>
HTML),
    'raporlar/tarife' => listPage('Tarife Raporları', ['Tarife', 'Müşteri Sayısı', 'Aylık Gelir', 'Aktif', 'Pasif']),
    'raporlar/trafik' => infoPage('Trafik Raporları', 'tachometer-alt', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="text-center text-muted py-5">
                <i class="fas fa-tachometer-alt fa-3x mb-3 d-block"></i>
                <h5>Trafik Raporları</h5>
                <p>Bant genişliği kullanım raporlarını görüntüleyin.</p>
            </div>
        </div>
    </div>
HTML),
    'raporlar/veresiye' => listPage('Veresiye Raporları', ['#', 'Müşteri', 'Toplam Borç', 'Son Ödeme', 'Gecikme (Gün)', 'İşlem']),
    'raporlar/bayi_bakiye' => listPage('Bayi Bakiye Raporları', ['#', 'Bayi', 'Bakiye', 'Son İşlem', 'Müşteri Sayısı']),
    'raporlar/bayi_hakedis' => listPage('Bayi Hakediş Raporu', ['#', 'Bayi', 'Dönem', 'Tahsilat', 'Komisyon %', 'Hakediş', 'Ödeme Durumu']),
    'raporlar/bayiler_genel' => listPage('Bayiler Genel Rapor', ['#', 'Bayi', 'Müşteri Sayısı', 'Aylık Tahsilat', 'Bakiye', 'Durum']),
    'raporlar/kdv' => listPage('KDV Raporları', ['Dönem', 'Hesaplanan KDV', 'İndirilecek KDV', 'Ödenecek KDV']),
    'raporlar/e_fatura_durum' => listPage('E-Fatura Durum Raporu', ['#', 'Fatura No', 'Müşteri', 'Tutar', 'GİB Durumu', 'Tarih']),
    'raporlar/eksik_evrak' => listPage('Eksik Evrak Raporu', ['#', 'Müşteri', 'Eksik Evraklar', 'Tamamlanma %', 'İşlem']),
    'raporlar/adres' => listPage('Adres Raporu', ['#', 'İl', 'İlçe', 'Mahalle', 'Müşteri Sayısı']),
    'raporlar/binadaki_musteriler' => infoPage('Binadaki Müşteriler', 'building', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Adres / Bina</label>
                    <input type="text" name="adres" class="form-control" placeholder="Adres ara..." value="{{ request('adres') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Ara</button>
                </div>
            </form>
            <div class="text-center text-muted py-4">
                <i class="fas fa-building fa-2x mb-2 d-block"></i>
                Bir bina adresi girerek o binadaki müşterileri görüntüleyin.
            </div>
        </div>
    </div>
HTML),
    'raporlar/genel_trafik' => infoPage('Genel Trafik Raporları', 'signal', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <canvas id="trafikChart" height="300"></canvas>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if(document.getElementById('trafikChart')) {
            new Chart(document.getElementById('trafikChart'), {
                type: 'line',
                data: {
                    labels: ['00:00','04:00','08:00','12:00','16:00','20:00','23:59'],
                    datasets: [
                        {label: 'Download (Mbps)', data: [0,0,0,0,0,0,0], borderColor: '#28a745', fill: false},
                        {label: 'Upload (Mbps)', data: [0,0,0,0,0,0,0], borderColor: '#007bff', fill: false}
                    ]
                }
            });
        }
    });
    </script>
HTML),
    'raporlar/gun_sonu' => listPage('Gün Sonu Raporları', ['Tarih', 'Toplam Tahsilat', 'Nakit', 'Havale/EFT', 'Kredi Kartı', 'Diğer']),

    // ===================== LOGLAR =====================
    'loglar/oturum' => listPage('Oturum Logları', ['#', 'Kullanıcı', 'IP Adresi', 'Tarayıcı', 'Giriş Zamanı', 'Çıkış Zamanı']),
    'loglar/abone_hareket' => listPage('Abone Hareket Logları', ['#', 'Abone', 'İşlem', 'Detay', 'Yapan', 'Tarih']),
    'loglar/mikrotik' => listPage('Mikrotik Logları', ['#', 'Cihaz', 'Log Tipi', 'Mesaj', 'Tarih']),
    'loglar/port' => listPage('Port Logları', ['#', 'Cihaz', 'Port', 'Durum', 'Müşteri', 'Tarih']),
    'loglar/log5651' => listPage('5651 Logları', ['#', 'IP Adresi', 'MAC', 'Başlangıç', 'Bitiş', 'Kullanıcı']),
    'loglar/sunucu_durum' => infoPage('Log Sunucusu Durum', 'server', <<<HTML
    <div class="row g-4">
        <div class="col-md-4"><div class="card bg-success text-white text-center p-3"><i class="fas fa-check-circle fa-2x mb-2"></i><h5>Aktif</h5><small>Log Sunucusu</small></div></div>
        <div class="col-md-4"><div class="card bg-info text-white text-center p-3"><i class="fas fa-database fa-2x mb-2"></i><h5>0 GB</h5><small>Disk Kullanımı</small></div></div>
        <div class="col-md-4"><div class="card bg-warning text-white text-center p-3"><i class="fas fa-clock fa-2x mb-2"></i><h5>0 gün</h5><small>Uptime</small></div></div>
    </div>
HTML),
    'loglar/hata_durum' => listPage('Log Hata Durumu', ['#', 'Hata Tipi', 'Mesaj', 'Kaynak', 'Tarih', 'Çözüm']),
    'loglar/sas_veri' => listPage('SAS Veri Logları', ['#', 'Veri Tipi', 'Kaynak', 'Boyut', 'Tarih', 'Durum']),
    'loglar/veri_tarama' => listPage('Veri Tarama', ['#', 'Sorgu', 'Sonuç', 'Tarih', 'Kullanıcı']),
    'loglar/abone_rehber' => listPage('Abone Rehber Logları', ['#', 'Abone', 'İşlem', 'Detay', 'Tarih']),
    'loglar/btk_hata' => listPage('BTK Rehber Hareket Hata', ['#', 'Hata Kodu', 'Mesaj', 'Abone', 'Tarih', 'Durum']),

    // ===================== WHATSAPP =====================
    'whatsapp/ayarlar' => infoPage('WhatsApp Ayarları', 'fab fa-whatsapp', <<<HTML
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
HTML),

    // ===================== GÜNCELLEME LİSTESİ =====================
    'guncelleme_listesi' => infoPage('Güncelleme Listesi', 'sync-alt', <<<HTML
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="timeline">
                <div class="border-start border-3 border-primary ps-3 mb-4">
                    <h5 class="text-primary">v1.0.0 <small class="text-muted">- 2 Mart 2026</small></h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-plus text-success me-2"></i>Sistem ilk kurulumu tamamlandı</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Müşteri yönetimi modülü</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Fatura işlemleri modülü</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Bayi yönetimi modülü</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Mikrotik entegrasyonu</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Raporlama sistemi</li>
                        <li><i class="fas fa-plus text-success me-2"></i>SMS ve E-posta yönetimi</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Telekom modülü</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Teknik servis yönetimi</li>
                        <li><i class="fas fa-plus text-success me-2"></i>Stok ve envanter yönetimi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
HTML),
];

// Create all views
$created = 0;
$skipped = 0;

foreach ($views as $path => $content) {
    $fullPath = $basePath . '/' . $path . '.blade.php';
    $dir = dirname($fullPath);

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "📁 Created directory: $dir\n";
    }

    if (file_exists($fullPath)) {
        echo "⏭️  Skipped (exists): $path\n";
        $skipped++;
        continue;
    }

    file_put_contents($fullPath, $content);
    echo "✅ Created: $path\n";
    $created++;
}

echo "\n=== Summary ===\n";
echo "Created: $created views\n";
echo "Skipped: $skipped views (already exist)\n";
echo "Total: " . ($created + $skipped) . " views processed\n";
