#!/usr/bin/env php
<?php
// Test all pages by making HTTP requests with a logged-in session

$base = 'http://127.0.0.1:8000';

// Step 1: Get login page and extract CSRF token
$ch = curl_init();
$cookieFile = '/tmp/laravel_test_cookies.txt';
@unlink($cookieFile);

curl_setopt_array($ch, [
    CURLOPT_URL => "$base/login",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEJAR => $cookieFile,
    CURLOPT_COOKIEFILE => $cookieFile,
    CURLOPT_FOLLOWLOCATION => true,
]);
$html = curl_exec($ch);

preg_match('/name="_token".*?value="([^"]+)"/', $html, $m);
$token = $m[1] ?? '';

if (!$token) {
    echo "Could not get CSRF token\n";
    exit(1);
}

// Step 2: Login
curl_setopt_array($ch, [
    CURLOPT_URL => "$base/login",
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        '_token' => $token,
        'kullanici_adi' => 'admin',
        'password' => '123456',
    ]),
    CURLOPT_FOLLOWLOCATION => true,
]);
curl_exec($ch);

// Step 3: Test pages
$pages = [
    'home', 'dashboard',
    'musteriler', 'musteriler/ekle', 'musteriler/online_musteriler', 'musteriler/offline_musteriler',
    'musteriler/interneti_kesilenler', 'musteriler/onaylanan_musteriler', 'musteriler/on_basvurular',
    'musteriler/online_basvurular', 'musteriler/e_devlet_basvurular', 'musteriler/grup_listelesi',
    'musteriler/musteri_notlari', 'musteriler/musteri_tarife_gecis_istekleri', 'musteriler/mac_arama',
    'musteriler/yabanci_musteriler', 'musteriler/vlan', 'musteriler/tc-kimlik-ban', 'musteriler/log_odeme',
    'fatura_islemleri', 'fatura_islemleri/ekle', 'fatura_islemleri/odenmis_faturalar',
    'fatura_islemleri/bekleyen_siparisler', 'fatura_islemleri/faturali_iptal', 'fatura_islemleri/fatura_tahsilat',
    'fatura_islemleri/havale_bildirimleri', 'fatura_islemleri/taahhutlu_musteriler',
    'fatura_islemleri/otomatik_cekimler', 'fatura_islemleri/otomatik_talimatlar',
    'fatura_islemleri/paynkolay_rapor', 'fatura_islemleri/offline_dosyalar',
    'fatura_islemleri/efatura', 'fatura_islemleri/efatura_hata', 'fatura_islemleri/odeme-al',
    'tarifeler', 'tarifeler/ekle', 'tarifeler/detay', 'tarifeler/hizmetler', 'tarifeler/kampanyalar', 'tarifeler/toplu_tarife_degistir',
    'basvurular', 'basvurular/bekleyen_basvurular', 'basvurular/ekle',
    'kasa', 'kasa/cariler', 'kasa/depolar', 'kasa/gider_gelir', 'kasa/cari_faturalar',
    'teknik_destek',
    'teknik_servis_islemleri', 'teknik_servis_islemleri/ekle', 'teknik_servis_islemleri/is_tanimlari', 'teknik_servis_islemleri/rapor',
    'arama_emirleri', 'arama_emirleri/create',
    'bayi_islemleri', 'bayi_islemleri/ekle', 'bayi_islemleri/bayi_musteriler', 'bayi_islemleri/bolgeler',
    'bayi_islemleri/devre_listesi', 'bayi_islemleri/duyurular', 'bayi_islemleri/kasa',
    'bayi_islemleri/kasakullanici', 'bayi_islemleri/kasakullanicihareket', 'bayi_islemleri/musteri_tasima',
    'bayi_islemleri/tickets', 'bayi_islemleri/yetkiler',
    'mikrotik', 'mikrotik/ekle', 'mikrotik/ppp', 'mikrotik/vpn_islemleri', 'mikrotik/ip_islemleri',
    'mikrotik/ip_yonetim', 'mikrotik/hata-raporu',
    'mikrotik/hat_islemleri/hat_listesi', 'mikrotik/hat_islemleri/ekle', 'mikrotik/hat_islemleri/kapasite',
    'mikrotik/hat_islemleri/hat_ip_hatali',
    'ip_index', 'hat_index', 'hat_create',
    'istasyon_ve_vericiler/istasyonlar', 'istasyon_ve_vericiler/vericiler', 'istasyon_ve_vericiler/ag_haritasi',
    'sms_islemleri', 'sms_islemleri/ekle', 'sms_islemleri/sablonlar', 'sms_islemleri/rapor', 'sms_islemleri/sms_eposta',
    'telekom', 'telekom/telekom_basvurular', 'telekom/degisiklik_basvurular',
    'telekom/olo/ariza_listesi', 'telekom/olo/ariza_teyit', 'telekom/olo/genel_ariza',
    'telekom/churn/sorgu', 'telekom/churn/sorgu/basvurular',
    'telekom/raporlar/durum_rapor', 'telekom/tt_vae_faturalar',
    'personel', 'personel/create', 'personel/hakedis',
    'stok', 'stok/urunler', 'stok/urunler/arizali_urunler', 'stok/urunler/musterideki_urunler',
    'stok/urunler/sokum_listesi', 'stok/urunler/urun_gonder',
    'arac_islemleri', 'arac_islemleri/takip_ayar',
    'evrak/evraklar', 'evrak/evrak_ayarlari',
    'blog', 'blog/create',
    'cagri_merkezi/istatistikler',
    'genelariza/liste',
    'gelir_gider', 'musteri-notlari',
    'loglar/panel_loglari', 'loglar/oturum_loglari', 'loglar/abone_loglari', 'loglar/abone_hareket_loglari',
    'loglar/mikrotik_loglari', 'loglar/port_loglari', 'loglar/5651_loglari',
    'loglar/log_sunucusu_durum', 'loglar/log_hata_durumu', 'loglar/sas', 'loglar/veri_tarama',
    'loglar/abone_rehber_loglari', 'loglar/rehber_hareket_hata',
    'raporlar/musteri_raporlari', 'raporlar/satis_raporlari', 'raporlar/tahsilat_raporlari',
    'raporlar/tarife_raporlari', 'raporlar/trafik_raporlari', 'raporlar/veresiye_raporlari',
    'raporlar/bayi_bakiye_raporlari', 'raporlar/bayi_hakedis_raporu', 'raporlar/bayiler_genel_raporlari',
    'raporlar/kdv_raporlari', 'raporlar/efatura_durum_raporu', 'raporlar/eksik_evrak_raporu',
    'raporlar/adres_rapor', 'raporlar/binadaki_musteriler', 'raporlar/genel_trafik_raporlari',
    'raporlar/gun_sonu_raporlari', 'raporlar/satis', 'raporlar/tahsilat',
    'ayarlar/genel_ayarlar',
    'whatsapp/ayarlar',
    'guncelleme-listesi',
];

$failed = [];
$ok = 0;

foreach ($pages as $page) {
    curl_setopt_array($ch, [
        CURLOPT_URL => "$base/$page",
        CURLOPT_POST => false,
        CURLOPT_HTTPGET => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,
    ]);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

    if ($code == 200 && !str_contains($finalUrl, '/login')) {
        $ok++;
    } else {
        // Check for error message in body
        $errorMsg = '';
        if (preg_match('/<title[^>]*>([^<]+)</', $body, $tm)) {
            $errorMsg = trim($tm[1]);
        }
        if (preg_match('/class="exception-message[^"]*"[^>]*>([^<]+)</', $body, $em)) {
            $errorMsg = trim($em[1]);
        }
        if (preg_match('/Undefined variable \$\w+|View \[.*?\] not found|Call to undefined|Class.*not found|Column not found|SQLSTATE/i', $body, $em)) {
            $errorMsg = trim($em[0]);
        }
        $failed[] = [
            'page' => $page,
            'code' => $code,
            'error' => $errorMsg,
            'redirect' => str_contains($finalUrl, '/login') ? 'REDIRECT_TO_LOGIN' : '',
        ];
    }
}

curl_close($ch);

echo "=== Results ===\n";
echo "OK: $ok pages\n";
echo "FAILED: " . count($failed) . " pages\n\n";

foreach ($failed as $f) {
    echo "FAIL [{$f['code']}] {$f['page']}";
    if ($f['redirect']) echo " ({$f['redirect']})";
    if ($f['error']) echo " => {$f['error']}";
    echo "\n";
}
