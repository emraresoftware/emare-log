<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

// Redirect root to login or home
Route::get('/', function () {
    return auth()->check() ? redirect('/home') : redirect('/login');
});

// ===================== AUTH REQUIRED =====================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/anasayfa', [App\Http\Controllers\HomeController::class, 'index'])->name('anasayfa');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    // ===================== MÜŞTERİ İŞLEMLERİ =====================
    Route::prefix('musteriler')->name('musteriler.')->group(function () {
        Route::get('/', [App\Http\Controllers\MusteriController::class, 'index'])->name('index');
        Route::get('/ekle', [App\Http\Controllers\MusteriController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\MusteriController::class, 'store'])->name('store');
        Route::get('/detay/{id}', [App\Http\Controllers\MusteriController::class, 'show'])->name('show');
        Route::get('/duzenle/{id}', [App\Http\Controllers\MusteriController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\MusteriController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\MusteriController::class, 'destroy'])->name('destroy');
        Route::get('/online_musteriler', [App\Http\Controllers\MusteriController::class, 'onlineMusteriler'])->name('online');
        Route::get('/offline_musteriler', [App\Http\Controllers\MusteriController::class, 'offlineMusteriler'])->name('offline');
        Route::get('/musteri_notlari', [App\Http\Controllers\MusteriController::class, 'musteriNotlari'])->name('notlar');
        Route::get('/musteri_tarife_gecis_istekleri', [App\Http\Controllers\MusteriController::class, 'tarifeGecisIstekleri'])->name('tarife_gecis');
        Route::get('/online_basvurular', [App\Http\Controllers\MusteriController::class, 'onlineBasvurular'])->name('online_basvurular');
        Route::get('/on_basvurular', [App\Http\Controllers\MusteriController::class, 'onBasvurular'])->name('on_basvurular');
        Route::get('/interneti_kesilenler', [App\Http\Controllers\MusteriController::class, 'internetiKesilenler'])->name('interneti_kesilenler');
        Route::get('/onaylanan_musteriler', [App\Http\Controllers\MusteriController::class, 'onayBekleyen'])->name('onay_bekleyen');
        Route::get('/yabanci_musteriler', [App\Http\Controllers\MusteriController::class, 'yabanciMusteriler'])->name('yabanci');
        Route::get('/tc-kimlik-ban', [App\Http\Controllers\MusteriController::class, 'yasaklananTcler'])->name('yasaklanan_tc');
        Route::get('/grup_listelesi', [App\Http\Controllers\MusteriController::class, 'grupListesi'])->name('gruplar');
        Route::get('/mac_arama', [App\Http\Controllers\MusteriController::class, 'macArama'])->name('mac_arama');
        Route::get('/e_devlet_basvurular', [App\Http\Controllers\MusteriController::class, 'eDevletBasvurular'])->name('e_devlet');
        Route::get('/vlan', [App\Http\Controllers\MusteriController::class, 'vlanMusteriler'])->name('vlan');
        Route::get('/log_odeme', [App\Http\Controllers\MusteriController::class, 'odemeLoglari'])->name('odeme_log');
        Route::get('/export/excel', [App\Http\Controllers\MusteriController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [App\Http\Controllers\MusteriController::class, 'exportPdf'])->name('export.pdf');
    });

    // ===================== MÜŞTERİ NOTLARI =====================
    Route::prefix('musteri-notlari')->name('musteri-notlari.')->group(function () {
        Route::get('/', [App\Http\Controllers\MusteriController::class, 'musteriNotlari'])->name('index');
        Route::post('/', [App\Http\Controllers\MusteriController::class, 'notKaydet'])->name('store');
        Route::delete('/{id}', [App\Http\Controllers\MusteriController::class, 'notSil'])->name('destroy');
    });

    // ===================== BAŞVURULAR =====================
    Route::prefix('basvurular')->name('basvurular.')->group(function () {
        Route::get('/bekleyen_basvurular', [App\Http\Controllers\BasvuruController::class, 'bekleyenBasvurular'])->name('bekleyen');
        Route::get('/ekle', [App\Http\Controllers\BasvuruController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\BasvuruController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\BasvuruController::class, 'show'])->name('show');
        Route::put('/{id}/onayla', [App\Http\Controllers\BasvuruController::class, 'onayla'])->name('onayla');
        Route::put('/{id}/reddet', [App\Http\Controllers\BasvuruController::class, 'reddet'])->name('reddet');
        Route::get('/', [App\Http\Controllers\BasvuruController::class, 'index'])->name('index');
        Route::get('/{id}/duzenle', [App\Http\Controllers\BasvuruController::class, 'edit'])->name('edit');
    });

    // ===================== ARAMA EMİRLERİ =====================
    Route::resource('arama_emirleri', App\Http\Controllers\AramaEmriController::class);

    // ===================== KASA İŞLEMLERİ =====================
    Route::prefix('kasa')->name('kasa.')->group(function () {
        Route::get('/', [App\Http\Controllers\KasaController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\KasaController::class, 'store'])->name('store');
        Route::get('/cariler', [App\Http\Controllers\CariController::class, 'index'])->name('cariler');
        Route::post('/cariler', [App\Http\Controllers\CariController::class, 'store'])->name('cariler.store');
        Route::get('/cari_faturalar', [App\Http\Controllers\CariController::class, 'faturalar'])->name('cari_faturalar');
        Route::get('/gider_gelir', [App\Http\Controllers\GelirGiderController::class, 'index'])->name('gelir_gider');
        Route::post('/gider_gelir', [App\Http\Controllers\GelirGiderController::class, 'store'])->name('gelir_gider.store');
        Route::get('/depolar', [App\Http\Controllers\DepoController::class, 'index'])->name('depolar');
        Route::post('/depolar', [App\Http\Controllers\DepoController::class, 'store'])->name('depolar.store');
        Route::get('/{id}', [App\Http\Controllers\KasaController::class, 'show'])->name('show');
        Route::delete('/{id}', [App\Http\Controllers\KasaController::class, 'destroy'])->name('destroy');
    });

    // Gelir/Gider alias routes
    Route::get('/gelir_gider', [App\Http\Controllers\GelirGiderController::class, 'index'])->name('gelir_gider.index');
    Route::post('/gelir_gider', [App\Http\Controllers\GelirGiderController::class, 'store'])->name('gelir_gider.store');
    Route::delete('/gelir_gider/{id}', [App\Http\Controllers\GelirGiderController::class, 'destroy'])->name('gelir_gider.destroy');

    // Cari alias routes
    Route::post('/cari', [App\Http\Controllers\CariController::class, 'store'])->name('cari.store');
    Route::get('/cari/{id}', [App\Http\Controllers\CariController::class, 'show'])->name('cari.show');
    Route::get('/cari/{id}/fatura', [App\Http\Controllers\CariController::class, 'faturalar'])->name('cari.fatura');
    Route::delete('/cari/{id}', [App\Http\Controllers\CariController::class, 'destroy'])->name('cari.destroy');

    // ===================== BAYİ İŞLEMLERİ =====================
    Route::prefix('bayi_islemleri')->name('bayi.')->group(function () {
        Route::get('/', [App\Http\Controllers\BayiController::class, 'index'])->name('index');
        Route::get('/ekle', [App\Http\Controllers\BayiController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\BayiController::class, 'store'])->name('store');
        Route::get('/kasakullanici', [App\Http\Controllers\BayiController::class, 'kasaKullanici'])->name('kasa_kullanici');
        Route::get('/kasakullanicihareket', [App\Http\Controllers\BayiController::class, 'kasaHareket'])->name('kasa_hareket');
        Route::get('/bayi_musteriler', [App\Http\Controllers\BayiController::class, 'bayiMusteriler'])->name('musteriler');
        Route::get('/musteri_tasima', [App\Http\Controllers\BayiController::class, 'musteriTasima'])->name('musteri_tasima');
        Route::get('/duyurular', [App\Http\Controllers\BayiController::class, 'duyurular'])->name('duyurular');
        Route::get('/tickets', [App\Http\Controllers\BayiController::class, 'tickets'])->name('tickets');
        Route::get('/bolgeler', [App\Http\Controllers\BayiController::class, 'bolgeler'])->name('bolgeler');
        Route::post('/bolgeler', [App\Http\Controllers\BayiController::class, 'bolgeStore'])->name('bolgeler.store');
        Route::get('/yetkilendirme/yetkiler/yetki-atama-yeri', [App\Http\Controllers\BayiController::class, 'yetkiAtama'])->name('yetki_atama');
        Route::get('/devre_listesi', [App\Http\Controllers\BayiController::class, 'devreListesi'])->name('devreler');
        Route::delete('/{id}', [App\Http\Controllers\BayiController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/duzenle', [App\Http\Controllers\BayiController::class, 'edit'])->name('edit');
        Route::get('/kasa', [App\Http\Controllers\BayiController::class, 'kasa'])->name('kasa');
        Route::get('/yetkiler', [App\Http\Controllers\BayiController::class, 'yetkiler'])->name('yetkiler');
    });

    // ===================== STOK İŞLEMLERİ =====================
    Route::prefix('stok')->name('stok.')->group(function () {
        Route::get('/', [App\Http\Controllers\StokController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\StokController::class, 'store'])->name('store');
        Route::prefix('urunler')->name('urunler.')->group(function () {
            Route::get('/', [App\Http\Controllers\UrunController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\UrunController::class, 'store'])->name('store');
            Route::get('/musterideki_urunler', [App\Http\Controllers\UrunController::class, 'musteridekiUrunler'])->name('musterideki');
            Route::get('/arizali_urunler', [App\Http\Controllers\UrunController::class, 'arizaliUrunler'])->name('arizali');
            Route::get('/sokum_listesi', [App\Http\Controllers\UrunController::class, 'sokumListesi'])->name('sokum');
            Route::get('/urun_gonder', [App\Http\Controllers\UrunController::class, 'urunGonder'])->name('gonder');
        });
    });

    // ===================== FATURA İŞLEMLERİ =====================
    Route::prefix('fatura_islemleri')->name('fatura.')->group(function () {
        Route::get('/', [App\Http\Controllers\FaturaController::class, 'index'])->name('index');
        Route::get('/ekle', [App\Http\Controllers\FaturaController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\FaturaController::class, 'store'])->name('store');
        Route::get('/odeme-al', [App\Http\Controllers\FaturaController::class, 'odemeAl'])->name('odeme_al');
        Route::post('/odeme-al', [App\Http\Controllers\FaturaController::class, 'odemeKaydet'])->name('odeme_kaydet');
        Route::get('/efatura', [App\Http\Controllers\FaturaController::class, 'eFaturalar'])->name('efatura');
        Route::get('/fatura_tahsilat', [App\Http\Controllers\FaturaController::class, 'faturaTahsilat'])->name('tahsilat');
        Route::get('/odenmis_faturalar', [App\Http\Controllers\FaturaController::class, 'odenmisFaturalar'])->name('odenmis');
        Route::get('/faturali_iptal', [App\Http\Controllers\FaturaController::class, 'faturaliIptal'])->name('iptal');
        Route::get('/taahhutlu_musteriler', [App\Http\Controllers\FaturaController::class, 'taahhutluMusteriler'])->name('taahhutlu');
        Route::get('/bekleyen_siparisler', [App\Http\Controllers\FaturaController::class, 'bekleyenSiparisler'])->name('bekleyen_siparis');
        Route::get('/havale_bildirimleri', [App\Http\Controllers\FaturaController::class, 'havaleBildirimleri'])->name('havale');
        Route::get('/efatura_hata', [App\Http\Controllers\FaturaController::class, 'eFaturaHata'])->name('efatura_hata');
        Route::get('/efatura/{id}/indir', [App\Http\Controllers\FaturaController::class, 'eFaturaIndir'])->name('efatura.indir');
        Route::get('/offline_dosyalar', [App\Http\Controllers\FaturaController::class, 'offlineTahsilatlar'])->name('offline');
        Route::get('/otomatik_cekimler', [App\Http\Controllers\FaturaController::class, 'otomatikCekimler'])->name('otomatik_cekim');
        Route::get('/otomatik_talimatlar', [App\Http\Controllers\FaturaController::class, 'otomatikTalimatlar'])->name('otomatik_talimat');
        Route::get('/paynkolay_rapor', [App\Http\Controllers\FaturaController::class, 'paynkolayRapor'])->name('paynkolay');
        // Wildcard routes last
        Route::get('/{id}', [App\Http\Controllers\FaturaController::class, 'show'])->name('show');
        Route::get('/{id}/yazdir', [App\Http\Controllers\FaturaController::class, 'yazdir'])->name('yazdir');
    });

    // Fatura alias routes for views using 'faturalar.' prefix
    Route::get('/faturalar/ekle', [App\Http\Controllers\FaturaController::class, 'create'])->name('faturalar.create');
    Route::get('/faturalar/{id}', [App\Http\Controllers\FaturaController::class, 'show'])->name('faturalar.show');

    // Ödeme alias routes
    Route::get('/odemeler/ekle', [App\Http\Controllers\FaturaController::class, 'odemeAl'])->name('odemeler.create');
    Route::get('/odemeler/{id}', [App\Http\Controllers\FaturaController::class, 'odemeShow'])->name('odemeler.show');

    // Fatura odeme alias
    Route::post('/fatura_odeme_al', [App\Http\Controllers\FaturaController::class, 'odemeKaydet'])->name('fatura.odeme_al.store');

    // ===================== PERSONEL =====================
    Route::get('/personel/hakedis', [App\Http\Controllers\PersonelController::class, 'hakedis'])->name('personel.hakedis');
    Route::resource('personel', App\Http\Controllers\PersonelController::class);

    // ===================== ARAÇ İŞLEMLERİ =====================
    Route::prefix('arac_islemleri')->name('arac.')->group(function () {
        Route::get('/', [App\Http\Controllers\AracController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\AracController::class, 'store'])->name('store');
        Route::delete('/{id}', [App\Http\Controllers\AracController::class, 'destroy'])->name('destroy');
        Route::get('/takip_ayar', [App\Http\Controllers\AracController::class, 'takipAyar'])->name('takip');
    });

    // ===================== SMS İŞLEMLERİ =====================
    Route::prefix('sms_islemleri')->name('sms.')->group(function () {
        Route::get('/', [App\Http\Controllers\SmsController::class, 'ayarlar'])->name('ayarlar');
        Route::post('/ayarlar', [App\Http\Controllers\SmsController::class, 'ayarKaydet'])->name('ayar_kaydet');
        Route::get('/rapor', [App\Http\Controllers\SmsController::class, 'rapor'])->name('rapor');
        Route::get('/sablonlar', [App\Http\Controllers\SmsController::class, 'sablonlar'])->name('sablonlar');
        Route::post('/sablonlar', [App\Http\Controllers\SmsController::class, 'sablonKaydet'])->name('sablon_kaydet');
        Route::get('/sms_eposta', [App\Http\Controllers\SmsController::class, 'smsGonder'])->name('gonder');
        Route::post('/sms_eposta', [App\Http\Controllers\SmsController::class, 'smsGonderKaydet'])->name('gonder_kaydet');
        Route::get('/ekle', [App\Http\Controllers\SmsController::class, 'smsGonder'])->name('create');
    });

    // SMS alias routes for views
    Route::post('/sms_gonder_post', [App\Http\Controllers\SmsController::class, 'smsGonderKaydet'])->name('sms.gonder.post');
    Route::post('/sms_sablon_store', [App\Http\Controllers\SmsController::class, 'sablonKaydet'])->name('sms.sablon.store');
    Route::delete('/sms_sablon/{id}', [App\Http\Controllers\SmsController::class, 'sablonSil'])->name('sms.sablon.destroy');

    // ===================== MİKROTİK İŞLEMLERİ =====================
    Route::prefix('mikrotik')->name('mikrotik.')->group(function () {
        Route::get('/', [App\Http\Controllers\MikrotikController::class, 'index'])->name('index');
        Route::get('/ekle', [App\Http\Controllers\MikrotikController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\MikrotikController::class, 'store'])->name('store');
        Route::get('/hata-raporu', [App\Http\Controllers\MikrotikController::class, 'hataRaporu'])->name('hata_raporu');
        Route::get('/ppp', [App\Http\Controllers\MikrotikController::class, 'pppListesi'])->name('ppp');
        Route::get('/{id}', [App\Http\Controllers\MikrotikController::class, 'show'])->name('show')->where('id', '[0-9]+');
        Route::put('/{id}', [App\Http\Controllers\MikrotikController::class, 'update'])->name('update')->where('id', '[0-9]+');
        Route::get('/{id}/duzenle', [App\Http\Controllers\MikrotikController::class, 'edit'])->name('edit')->where('id', '[0-9]+');

        Route::prefix('hat_islemleri')->name('hat.')->group(function () {
            Route::get('/ekle', [App\Http\Controllers\HatController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\HatController::class, 'store'])->name('store');
            Route::get('/hat_listesi', [App\Http\Controllers\HatController::class, 'index'])->name('index');
            Route::get('/kapasite', [App\Http\Controllers\HatController::class, 'kapasite'])->name('kapasite');
            Route::get('/hat_ip_hatali', [App\Http\Controllers\HatController::class, 'hatIpHatali'])->name('hatali');
            Route::get('/{id}/duzenle', [App\Http\Controllers\HatController::class, 'edit'])->name('edit');
        });

        Route::prefix('ip_islemleri')->name('ip.')->group(function () {
            Route::get('/', [App\Http\Controllers\IpController::class, 'index'])->name('index');
            Route::get('/borclu_ipler', [App\Http\Controllers\IpController::class, 'borcluIpler'])->name('borclu');
        });

        Route::get('/ip_yonetim', [App\Http\Controllers\IpController::class, 'ipYonetim'])->name('ip_yonetim');
        Route::get('/vpn_islemleri', [App\Http\Controllers\MikrotikController::class, 'vpnListesi'])->name('vpn');
    });

    // Hat/IP alias routes for views
    Route::get('/hat_index', [App\Http\Controllers\HatController::class, 'index'])->name('hat.index');
    Route::get('/hat_create', [App\Http\Controllers\HatController::class, 'create'])->name('hat.create');
    Route::post('/hat_store', [App\Http\Controllers\HatController::class, 'store'])->name('hat.store');
    Route::get('/hat/{id}/edit', [App\Http\Controllers\HatController::class, 'edit'])->name('hat.edit');
    Route::get('/ip_index', [App\Http\Controllers\IpController::class, 'index'])->name('ip.index');
    Route::get('/musteri/{id}', [App\Http\Controllers\MusteriController::class, 'show'])->name('musteri.show');

    // ===================== İSTASYON VE VERİCİLER =====================
    Route::prefix('istasyon_ve_vericiler')->name('istasyon.')->group(function () {
        Route::get('/istasyonlar', [App\Http\Controllers\IstasyonController::class, 'index'])->name('index');
        Route::post('/istasyonlar', [App\Http\Controllers\IstasyonController::class, 'store'])->name('store');
        Route::get('/vericiler', [App\Http\Controllers\IstasyonController::class, 'vericiler'])->name('vericiler');
        Route::post('/vericiler', [App\Http\Controllers\IstasyonController::class, 'vericiStore'])->name('vericiler.store');
        Route::get('/ag_haritasi', [App\Http\Controllers\IstasyonController::class, 'agHaritasi'])->name('harita');
        Route::get('/{id}', [App\Http\Controllers\IstasyonController::class, 'show'])->name('show');
        Route::delete('/{id}', [App\Http\Controllers\IstasyonController::class, 'destroy'])->name('destroy');
    });

    // ===================== GENEL ARIZA =====================
    Route::prefix('genelariza')->name('ariza.')->group(function () {
        Route::get('/liste', [App\Http\Controllers\GenelArizaController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\GenelArizaController::class, 'store'])->name('store');
        Route::put('/{id}', [App\Http\Controllers\GenelArizaController::class, 'update'])->name('update');
        Route::get('/{id}', [App\Http\Controllers\GenelArizaController::class, 'show'])->name('show');
        Route::put('/{id}/coz', [App\Http\Controllers\GenelArizaController::class, 'coz'])->name('coz');
        Route::delete('/{id}', [App\Http\Controllers\GenelArizaController::class, 'destroy'])->name('destroy');
    });

    // Genel arıza alias routes
    Route::post('/genel_ariza', [App\Http\Controllers\GenelArizaController::class, 'store'])->name('genel_ariza.store');
    Route::get('/genel_ariza/{id}', [App\Http\Controllers\GenelArizaController::class, 'show'])->name('genel_ariza.show');
    Route::put('/genel_ariza/{id}/coz', [App\Http\Controllers\GenelArizaController::class, 'coz'])->name('genel_ariza.coz');
    Route::delete('/genel_ariza/{id}', [App\Http\Controllers\GenelArizaController::class, 'destroy'])->name('genel_ariza.destroy');

    // ===================== TEKNİK SERVİS =====================
    Route::prefix('teknik_servis_islemleri')->name('teknik_servis.')->group(function () {
        Route::get('/', [App\Http\Controllers\TeknikServisController::class, 'index'])->name('index');
        Route::get('/ekle', [App\Http\Controllers\TeknikServisController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\TeknikServisController::class, 'store'])->name('store');
        Route::get('/is_tanimlari', [App\Http\Controllers\TeknikServisController::class, 'isTanimlari'])->name('is_tanimlari');
        Route::get('/rapor', [App\Http\Controllers\TeknikServisController::class, 'rapor'])->name('rapor');
        Route::get('/{id}', [App\Http\Controllers\TeknikServisController::class, 'show'])->name('show');
        Route::put('/{id}', [App\Http\Controllers\TeknikServisController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\TeknikServisController::class, 'destroy'])->name('destroy');
    });

    // İş tanımı alias routes
    Route::post('/is_tanimi', [App\Http\Controllers\TeknikServisController::class, 'isTanimiKaydet'])->name('is_tanimi.store');
    Route::delete('/is_tanimi/{id}', [App\Http\Controllers\TeknikServisController::class, 'isTanimiSil'])->name('is_tanimi.destroy');

    // ===================== TARİFELER =====================
    Route::prefix('tarifeler')->name('tarife.')->group(function () {
        Route::get('/', [App\Http\Controllers\TarifeController::class, 'index'])->name('index');
        Route::get('/ekle', [App\Http\Controllers\TarifeController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\TarifeController::class, 'store'])->name('store');
        Route::get('/detay', [App\Http\Controllers\TarifeController::class, 'istatistik'])->name('istatistik');
        Route::get('/{id}/duzenle', [App\Http\Controllers\TarifeController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\TarifeController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\TarifeController::class, 'destroy'])->name('destroy');
        Route::get('/toplu_tarife_degistir', [App\Http\Controllers\TarifeController::class, 'topluDegistir'])->name('toplu_degistir');
        Route::get('/hizmetler', [App\Http\Controllers\TarifeController::class, 'hizmetler'])->name('hizmetler');
        Route::get('/kampanyalar', [App\Http\Controllers\TarifeController::class, 'kampanyalar'])->name('kampanyalar');
        Route::post('/hizmetler', [App\Http\Controllers\TarifeController::class, 'hizmetStore'])->name('hizmetler.store');
        Route::post('/kampanyalar', [App\Http\Controllers\TarifeController::class, 'kampanyaStore'])->name('kampanyalar.store');
    });

    // Hizmet/Kampanya alias routes
    Route::post('/hizmet', [App\Http\Controllers\TarifeController::class, 'hizmetStore'])->name('hizmet.store');
    Route::post('/kampanya', [App\Http\Controllers\TarifeController::class, 'kampanyaStore'])->name('kampanya.store');

    // ===================== RAPORLAR =====================
    Route::prefix('raporlar')->name('rapor.')->group(function () {
        Route::get('/satis_raporlari', [App\Http\Controllers\RaporController::class, 'satisRaporlari'])->name('satis');
        Route::get('/kdv_raporlari', [App\Http\Controllers\RaporController::class, 'kdvRaporlari'])->name('kdv');
        Route::get('/trafik_raporlari', [App\Http\Controllers\RaporController::class, 'trafikRaporlari'])->name('trafik');
        Route::get('/genel_trafik_raporlari', [App\Http\Controllers\RaporController::class, 'genelTrafikRaporlari'])->name('genel_trafik');
        Route::get('/gun_sonu_raporlari', [App\Http\Controllers\RaporController::class, 'gunSonuRaporlari'])->name('gun_sonu');
        Route::get('/musteri_raporlari', [App\Http\Controllers\RaporController::class, 'musteriRaporlari'])->name('musteri');
        Route::get('/adres_rapor', [App\Http\Controllers\RaporController::class, 'adresRapor'])->name('adres');
        Route::get('/binadaki_musteriler', [App\Http\Controllers\RaporController::class, 'binadakiMusteriler'])->name('bina');
        Route::get('/bayiler_genel_raporlari', [App\Http\Controllers\RaporController::class, 'bayilerGenelRaporlari'])->name('bayiler');
        Route::get('/bayi_bakiye_raporlari', [App\Http\Controllers\RaporController::class, 'bayiBakiyeRaporlari'])->name('bayi_bakiye');
        Route::get('/veresiye_raporlari', [App\Http\Controllers\RaporController::class, 'veresiyeRaporlari'])->name('veresiye');
        Route::get('/tarife_raporlari', [App\Http\Controllers\RaporController::class, 'tarifeRaporlari'])->name('tarife');
        Route::get('/tahsilat_raporlari', [App\Http\Controllers\RaporController::class, 'tahsilatRaporlari'])->name('tahsilat');
        Route::get('/efatura_durum_raporu', [App\Http\Controllers\RaporController::class, 'eFaturaDurumRaporu'])->name('efatura');
        Route::get('/eksik_evrak_raporu', [App\Http\Controllers\RaporController::class, 'eksikEvrakRaporu'])->name('eksik_evrak');
        Route::get('/bayi_hakedis_raporu', [App\Http\Controllers\RaporController::class, 'bayiHakedisRaporu'])->name('bayi_hakedis');
    });

    // Rapor alias routes
    Route::get('/raporlar/satis', [App\Http\Controllers\RaporController::class, 'satisRaporlari'])->name('raporlar.satis');
    Route::get('/raporlar/tahsilat', [App\Http\Controllers\RaporController::class, 'tahsilatRaporlari'])->name('raporlar.tahsilat');

    // Log alias routes
    Route::get('/loglar_abone', [App\Http\Controllers\LogController::class, 'aboneLoglari'])->name('loglar.abone');
    Route::get('/loglar_panel', [App\Http\Controllers\LogController::class, 'panelLoglari'])->name('loglar.panel');

    // ===================== ÇAĞRI MERKEZİ =====================
    Route::get('/cagri_merkezi/istatistikler', [App\Http\Controllers\RaporController::class, 'cagriIstatistikleri'])->name('cagri.istatistik');

    // ===================== LOGLAR =====================
    Route::prefix('loglar')->name('log.')->group(function () {
        Route::get('/port_loglari', [App\Http\Controllers\LogController::class, 'portLoglari'])->name('port');
        Route::get('/oturum_loglari', [App\Http\Controllers\LogController::class, 'oturumLoglari'])->name('oturum');
        Route::get('/mikrotik_loglari', [App\Http\Controllers\LogController::class, 'mikrotikLoglari'])->name('mikrotik');
        Route::get('/5651_loglari', [App\Http\Controllers\LogController::class, 'log5651'])->name('5651');
        Route::get('/abone_loglari', [App\Http\Controllers\LogController::class, 'aboneLoglari'])->name('abone');
        Route::get('/abone_rehber_loglari', [App\Http\Controllers\LogController::class, 'aboneRehberLoglari'])->name('abone_rehber');
        Route::get('/abone_hareket_loglari', [App\Http\Controllers\LogController::class, 'aboneHareketLoglari'])->name('abone_hareket');
        Route::get('/panel_loglari', [App\Http\Controllers\LogController::class, 'panelLoglari'])->name('panel');
        Route::get('/log_sunucusu_durum', [App\Http\Controllers\LogController::class, 'sunucuDurum'])->name('sunucu_durum');
        Route::get('/log_hata_durumu', [App\Http\Controllers\LogController::class, 'logHataDurumu'])->name('hata_durum');
        Route::get('/veri_tarama', [App\Http\Controllers\LogController::class, 'veriTarama'])->name('veri_tarama');
        Route::get('/sas', [App\Http\Controllers\LogController::class, 'sasVeri'])->name('sas');
        Route::get('/rehber_hareket_hata', [App\Http\Controllers\LogController::class, 'btkHata'])->name('btk_hata');
    });

    // ===================== TELEKOM İŞLEMLERİ =====================
    Route::prefix('telekom')->name('telekom.')->group(function () {
        Route::get('/telekom_basvurular', [App\Http\Controllers\TelekomController::class, 'basvurular'])->name('basvurular');
        Route::get('/', [App\Http\Controllers\TelekomController::class, 'index'])->name('index');
        Route::get('/show/{id}', [App\Http\Controllers\TelekomController::class, 'show'])->name('show');
        Route::delete('/{id}', [App\Http\Controllers\TelekomController::class, 'destroy'])->name('destroy');
        Route::get('/tt_vae_faturalar', [App\Http\Controllers\TelekomController::class, 'vaeFaturalar'])->name('vae_faturalar');
        Route::get('/churn/sorgu', [App\Http\Controllers\TelekomController::class, 'churnSorgu'])->name('churn_sorgu');
        Route::get('/churn/sorgu/basvurular', [App\Http\Controllers\TelekomController::class, 'churnListesi'])->name('churn_listesi');
        Route::get('/olo/ariza_listesi', [App\Http\Controllers\TelekomController::class, 'oloArizaListesi'])->name('olo_ariza');
        Route::get('/olo/ariza_teyit', [App\Http\Controllers\TelekomController::class, 'oloArizaTeyit'])->name('olo_teyit');
        Route::get('/olo/genel_ariza', [App\Http\Controllers\TelekomController::class, 'genelAriza'])->name('genel_ariza');
        Route::get('/degisiklik_basvurular', [App\Http\Controllers\TelekomController::class, 'degisiklikBasvurulari'])->name('degisiklik');
        Route::get('/raporlar/durum_rapor', [App\Http\Controllers\TelekomController::class, 'durumRaporu'])->name('durum_rapor');
    });

    // ===================== AYARLAR =====================
    Route::prefix('ayarlar')->name('ayar.')->group(function () {
        Route::get('/genel_ayarlar', [App\Http\Controllers\AyarController::class, 'genelAyarlar'])->name('genel');
        Route::post('/genel_ayarlar', [App\Http\Controllers\AyarController::class, 'genelAyarlarKaydet'])->name('genel.kaydet');
        Route::put('/guncelle', [App\Http\Controllers\AyarController::class, 'genelAyarlarKaydet'])->name('guncelle');
    });

    // ===================== TEKNİK DESTEK =====================
    Route::prefix('teknik_destek')->name('destek.')->group(function () {
        Route::get('/', [App\Http\Controllers\TicketController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\TicketController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\TicketController::class, 'show'])->name('show');
        Route::post('/{id}/cevapla', [App\Http\Controllers\TicketController::class, 'cevapla'])->name('cevapla');
        Route::delete('/{id}', [App\Http\Controllers\TicketController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/kapat', [App\Http\Controllers\TicketController::class, 'kapat'])->name('kapat');
    });

    // ===================== BLOG =====================
    Route::resource('blog', App\Http\Controllers\BlogController::class);

    // ===================== EVRAK =====================
    Route::prefix('evrak')->name('evrak.')->group(function () {
        Route::get('/evraklar', [App\Http\Controllers\EvrakController::class, 'index'])->name('index');
        Route::post('/evraklar', [App\Http\Controllers\EvrakController::class, 'store'])->name('store');
        Route::get('/evrak_ayarlari', [App\Http\Controllers\EvrakController::class, 'ayarlar'])->name('ayarlar');
        Route::get('/{id}', [App\Http\Controllers\EvrakController::class, 'show'])->name('show')->where('id', '[0-9]+');
        Route::get('/{id}/indir', [App\Http\Controllers\EvrakController::class, 'download'])->name('download')->where('id', '[0-9]+');
        Route::delete('/{id}', [App\Http\Controllers\EvrakController::class, 'destroy'])->name('destroy')->where('id', '[0-9]+');
    });

    // ===================== API SİSTEM =====================
    Route::prefix('api-sistem')->name('api.')->group(function () {
        Route::get('/', [App\Http\Controllers\ApiSistemController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\ApiSistemController::class, 'store'])->name('store');
    });

    // ===================== WHATSAPP =====================
    Route::prefix('whatsapp')->name('whatsapp.')->group(function () {
        Route::get('/ayarlar', [App\Http\Controllers\WhatsappController::class, 'ayarlar'])->name('ayarlar');
        Route::post('/ayarlar', [App\Http\Controllers\WhatsappController::class, 'ayarKaydet'])->name('ayar_kaydet');
    });

    // Ürün alias routes
    Route::post('/urun', [App\Http\Controllers\UrunController::class, 'store'])->name('urun.store');
    Route::delete('/urun/{id}', [App\Http\Controllers\UrunController::class, 'destroy'])->name('urun.destroy');

    // ===================== GÜNCELLEME LİSTESİ =====================
    Route::get('/guncelleme-listesi', function () {
        return view('guncelleme_listesi');
    })->name('guncelleme_listesi');
});
