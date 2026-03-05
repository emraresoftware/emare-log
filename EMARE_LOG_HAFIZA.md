# 🧠 EMARE LOG — YAZILIM HAFIZA DOSYASI

> 🔗 **Ortak Hafıza:** [`EMARE_ORTAK_HAFIZA.md`](/Users/emre/Desktop/Emare/EMARE_ORTAK_HAFIZA.md) — Tüm Emare ekosistemi, sunucu bilgileri, standartlar ve proje envanteri için bak.


> **Son güncelleme:** 3 Mart 2026  
> **Amaç:** Projeye ara verildiğinde ya da taşındığında hiçbir detayı unutmamak.  
> **Yer:** `/Users/emre/Desktop/Emare Log/` → bu dosyayı bulduğun yerde çalışmaya devam et.

---

## 1. PROJENİN ÖZETI

**Emare Log** çalışma alanı iki ana bileşenden oluşmaktadır:

| Bileşen | Klasör | Ne İşe Yarar |
|---|---|---|
| **LogManager** (Ana yazılım) | `logmanager/` | ISS (İnternet Servis Sağlayıcı) yönetim paneli — Laravel 12 PHP uygulaması |
| **Hiper Scraper** (Araştırma aracı) | `scrape.js`, `scrape2.js` | `hiper.isskontrol.com.tr` sitesinin yapısını anlamak için yazılmış Puppeteer scraper |

---

## 2. ANA YAZILIM: LOGMANAGER

### 2.1 Yazılımın Amacı
`logmanager/` klasörü, bir ISS şirketinin tüm operasyonlarını yönetmek için geliştirilen **tam kapsamlı CRM + ERP + NOC panelidir**. Müşteri kaydından faturalamaya, MikroTik yönetiminden SMS bildirimine kadar her şeyi kapsıyor.

### 2.2 Teknoloji Yığını

| Katman | Teknoloji | Versiyon |
|---|---|---|
| Backend dili | PHP | ^8.2 |
| Framework | Laravel | ^12.0 |
| Auth | Laravel UI | ^4.6 |
| Frontend bundler | Vite | ^7.0.7 |
| CSS Framework | Bootstrap | ^5.3.8 |
| CSS pre-işlemci | SASS | ^1.56.1 |
| Utility CSS | Tailwind CSS | ^4.0.0 |
| JS grafik | Chart.js | ^4.5.1 |
| JS tablo | DataTables (BS5) | ^2.3.7 |
| Dropdown | Select2 | ^4.1.0 |
| Alert | SweetAlert2 | ^11.26.21 |
| İkonlar | Font Awesome | ^7.2.0 |
| Varsayılan DB | SQLite → MySQL | — |
| HTTP Client | Guzzle (vendor) | — |
| Test | PHPUnit | ^11.5.3 |

### 2.3 Klasör Yapısı

```
logmanager/
├── app/
│   ├── Http/Controllers/     ← Tüm controller'lar burada
│   ├── Models/               ← Eloquent modeller
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
│   ├── app.php               ← Uygulama başlangıcı
│   └── providers.php
├── config/                   ← database, auth, mail, queue vb.
├── database/
│   ├── migrations/
│   │   └── 2024_01_01_000001_create_all_tables.php  ← TEK migration dosyası
│   ├── factories/
│   └── seeders/
├── public/index.php          ← Web giriş noktası
├── resources/
│   ├── views/                ← Blade şablonları
│   ├── js/app.js
│   └── sass/app.scss
├── routes/
│   └── web.php               ← Tüm URL rotaları
├── storage/
│   └── logs/                 ← Laravel logları
├── composer.json
├── package.json
└── vite.config.js
```

---

## 3. VERİTABANI YAPISI

Tüm tablolar **tek bir migration** dosyasında tanımlıdır:  
`database/migrations/2024_01_01_000001_create_all_tables.php`

### 3.1 Tablolar ve Amaçları

| Tablo | Model Dosyası | Açıklama |
|---|---|---|
| `bolgeler` | `Bolge.php` | Coğrafi bölge tanımları |
| `users` | `User.php` | Panel kullanıcıları (admin, bayi, tekniker, muhasebe, operasyon) |
| `tarifeler` | `Tarife.php` | İnternet paket tarifeleri (hız, fiyat, KDV, taahhüt) |
| `hizmetler` | `Hizmet.php` | Ek hizmet tanımları |
| `kampanyalar` | `Kampanya.php` | İndirim kampanyaları |
| `musteriler` | `Musteri.php` | Aboneler — en kapsamlı tablo (kimlik, iletişim, adres, teknik, finansal) |
| `musteri_gruplari` | `MusteriGrubu.php` | Müşteri segmentasyon grupları |
| `musteri_grup_pivot` | — | Müşteri ↔ Grup many-to-many |
| `musteri_notlari` | `MusteriNotu.php` | Müşteriye özel notlar |
| `basvurular` | `Basvuru.php` | Yeni abone başvuruları (online, e-devlet, ön başvuru vb.) |
| `mikrotikler` | `Mikrotik.php` | MikroTik router cihazları (IP, port, kullanıcı) |
| `hatlar` | `Hat.php` | Mikrotik'e bağlı hat/kanal tanımları |
| `ip_adresleri` | `IpAdresi.php` | IP havuzu yönetimi |
| `vpn_kullanicilari` | `VpnKullanici.php` | VPN hesapları |
| `istasyonlar` | `Istasyon.php` | Baz istasyonları (GPS koordinatlı) |
| `vericiler` | `Verici.php` | İstasyondaki verici/access point cihazlar |
| `faturalar` | `Fatura.php` | Müşteri faturaları (aylık, kurulum, ek hizmet, e-fatura) |
| `odemeler` | `Odeme.php` | Ödeme tahsilatları |
| `havale_bildirimleri` | `HavaleBildirimi.php` | Banka havalesi bildirimleri |
| `otomatik_cekimler` | `OtomatikCekim.php` | Kredi kartı otomatik çekim kayıtları |
| `kasalar` | `Kasa.php` | Nakit kasa tanımları |
| `kasa_hareketleri` | `KasaHareketi.php` | Kasa giriş/çıkış hareketleri |
| `cariler` | `Cari.php` | Tedarikçi/iş yeri cariler |
| `cari_faturalari` | `CariFatura.php` | Cari alış-satış faturaları |
| `gelir_giderler` | `GelirGider.php` | Genel gelir-gider kayıtları |
| `stoklar` | `Stok.php` | Malzeme/ekipman stok yönetimi |
| `depolar` | `Depo.php` | Depo lokasyonları |
| `urunler` | `Urun.php` | Ürün/cihaz tanımları |
| `teknik_servisler` | `TeknikServis.php` | Teknik servis iş emirleri |
| `is_tanimlari` | `IsTanimi.php` | Yapılabilecek iş türü tanımları |
| `is_emirleri` | `IsEmri.php` | Teknik personele atanan iş emirleri |
| `personeller` | `Personel.php` | Şirket personeli |
| `hakedisler` | `Hakedis.php` | Personel aylık hak ediş/prim kayıtları |
| `araclar` | `Arac.php` | Şirket araç parkı |
| `sms_ayarlari` | `SmsAyari.php` | SMS provider ayarları |
| `sms_sablonlari` | `SmsSablonu.php` | SMS mesaj şablonları |
| `sms_gonderimleri` | `SmsGonderimi.php` | Gönderilen SMS kayıtları |
| `genel_arizalar` | `GenelAriza.php` | Toplu/bölgesel arıza kayıtları |
| `arama_emirleri` | `AramaEmri.php` | Müşteri arama görevleri |
| `ticketlar` | `Ticket.php` | Teknik destek talepleri |
| `ticket_cevaplari` | `TicketCevap.php` | Ticket mesajlaşma |
| `duyurular` | `Duyuru.php` | Panel içi duyurular |
| `evraklar` | `Evrak.php` | Müşteri evrak/dosya yükleme |
| `telekom_basvurulari` | `TelekomBasvuru.php` | Telekom/OLO arıza ve başvuruları |
| `panel_loglari` | `PanelLogu.php` | Kullanıcı panel işlem logları |
| `abone_loglari` | `AboneLogu.php` | Abone bağlantı/işlem logları |
| `mikrotik_loglari` | `MikrotikLogu.php` | MikroTik cihaz logları |
| `oturum_loglari` | `OturumLogu.php` | RADIUS oturum logları (IP, MAC, download/upload) |
| `ayarlar` | `Ayar.php` | Anahtar-değer sistem ayarları |
| `yasaklanan_tcler` | `YasaklananTc.php` | Kara listedeki TC kimlik numaraları |
| `api_anahtarlari` | `ApiAnahtari.php` | Dış API erişim anahtarları |
| `blog_yazilari` | `BlogYazisi.php` | Blog/haberler modülü |
| `whatsapp_ayarlari` | `WhatsappAyari.php` | WhatsApp API entegrasyon ayarları |
| `devreler` | `Devre.php` | İnternet omurga/backbone devre tanımları |

---

## 4. CONTROLLER'LAR VE MODÜLLER

`app/Http/Controllers/` altındaki tüm controller'lar:

| Controller | Yönettiği Modül |
|---|---|
| `HomeController` | Dashboard (istatistikler, son işlemler) |
| `MusteriController` | Müşteri CRUD, online/offline, notlar, tarife geçiş, Excel/PDF export |
| `BasvuruController` | Yeni abonelik başvuruları |
| `AramaEmriController` | Müşteri arama görevleri |
| `FaturaController` | Fatura oluşturma, ödeme alma, e-fatura, havale bildirimi |
| `KasaController` | Kasa yönetimi |
| `CariController` | Cari hesap/fatura |
| `GelirGiderController` | Genel muhasebe gelir-gider |
| `DepoController` | Depo yönetimi |
| `BayiController` | Bayi/alt kullanıcı yönetimi |
| `StokController` | Stok hareketleri |
| `UrunController` | Ürün/cihaz yönetimi |
| `PersonelController` | Personel + hak ediş |
| `AracController` | Araç takip |
| `SmsController` | SMS gönderme, şablonlar, raporlar |
| `MikrotikController` | MikroTik cihaz yönetimi, PPP, VPN |
| `HatController` | Hat/kanal yönetimi |
| `IpController` | IP havuzu yönetimi |
| `IstasyonController` | İstasyon + verici + harita |
| `GenelArizaController` | Toplu arıza açma/çözme |
| `TeknikServisController` | Teknik servis iş emirleri |
| `TarifeController` | Tarife CRUD, toplu değiştirme, hizmetler, kampanyalar |
| `RaporController` | Satış, KDV, trafik, müşteri, bayi, tahsilat raporları |
| `LogController` | Port, oturum, mikrotik, 5651, abone, panel logları |
| `TelekomController` | OLO arıza, CHURN, VAE fatura, telekom başvurular |
| `AyarController` | Genel sistem ayarları |
| `TicketController` | Teknik destek ticket sistemi |
| `BlogController` | Blog yönetimi |
| `EvrakController` | Evrak yükleme/indirme |
| `ApiSistemController` | API anahtar yönetimi |
| `WhatsappController` | WhatsApp entegrasyon ayarları |

---

## 5. ROUTE YAPISI (URL HARİTASI)

`routes/web.php` dosyasından tüm ana URL grupları:

| URL Prefix | Açıklama |
|---|---|
| `/` | Login yoksa `/login`, varsa `/home` |
| `/home`, `/anasayfa`, `/dashboard` | Ana panel |
| `/musteriler` | Müşteri yönetimi |
| `/musteri-notlari` | Müşteri notları |
| `/basvurular` | Başvuru işlemleri |
| `/arama_emirleri` | Arama emirleri (resource route) |
| `/kasa` | Kasa + Cari + Gelir/Gider + Depolar |
| `/bayi_islemleri` | Bayi kullanıcılar, kasa, müşteri taşıma, bölgeler |
| `/stok` ve `/stok/urunler` | Stok ve ürün yönetimi |
| `/fatura_islemleri` | Fatura, ödeme, e-fatura, otomatik çekim, havale |
| `/personel` | Personel (resource) + hakedişler |
| `/arac_islemleri` | Araç takip |
| `/sms_islemleri` | SMS ayar, şablon, gönder, rapor |
| `/mikrotik` | MikroTik cihazlar, hatlar, IP'ler, VPN, PPP |
| `/istasyon_ve_vericiler` | İstasyon, verici, ağ haritası |
| `/genelariza` | Genel arıza yönetimi |
| `/teknik_servis_islemleri` | Teknik servis + iş tanımları |
| `/tarifeler` | Tarife CRUD + hizmetler + kampanyalar |
| `/raporlar` | Tüm raporlar |
| `/loglar` | Tüm log ekranları (port, oturum, mikrotik, 5651, abone, panel, SAS, BTK) |
| `/telekom` | Telekom başvuruları, CHURN, OLO arıza |
| `/ayarlar` | Genel ayarlar |
| `/teknik_destek` | Ticket sistemi |
| `/blog` | Blog (resource route) |
| `/evrak` | Evrak yönetimi |
| `/api-sistem` | API anahtar yönetimi |
| `/whatsapp` | WhatsApp ayarları |
| `/guncelleme-listesi` | Güncelleme geçmişi sayfası |

---

## 6. KULLANICI ROLLERİ

`users` tablosundaki `rol` alanı 5 değer alabilir:

| Rol | Açıklama |
|---|---|
| `admin` | Tam yetki |
| `bayi` | Kendi müşterilerini görebilir |
| `tekniker` | Teknik servis işlemleri |
| `muhasebe` | Fatura, kasa, muhasebe ekranları |
| `operasyon` | Operasyonel işlemler |

Ayrıca `yetkiler` alanı JSON olarak detaylı yetki tanımı saklar.

---

## 7. MÜŞTERİ DURUMLARI

`musteriler.durum` alanı şu değerleri alabilir:

| Değer | Anlamı |
|---|---|
| `aktif` | Aktif abone |
| `pasif` | Pasif abone |
| `potansiyel` | Henüz aktif edilmemiş |
| `iptal` | Abonelik iptal |
| `dondurulmus` | Geçici askıya alınmış |
| `hukuki` | Hukuki süreçte |
| `sureden_pasif` | Süre dolduğu için pasif |

---

## 8. DASHBOARD İSTATİSTİKLERİ

`HomeController` her açılışta şunları hesaplar:

- Aktif / Pasif / Askıda / Toplam müşteri sayısı
- Ödenmemiş fatura adet ve toplam tutarı
- Ödenmiş fatura adet ve tutarı
- Aylık fatura toplamı
- Açık / Tamamlanan / Bekleyen iş emirleri
- Açık teknik servis sayısı
- Bekleyen başvuru sayısı
- Açık ticket sayısı
- Aktif arıza sayısı
- Bugünkü ve aylık tahsilat toplamı
- Son 10 müşteri, ödeme ve iş emri

---

## 9. HIPER SCRAPER (Araştırma Araçları)

Kök dizindeki `scrape.js` ve `scrape2.js` dosyaları **Puppeteer** kullanarak referans alınan sistemi analiz etmek için yazılmıştır.

### 9.1 Hedef Site
```
https://hiper.isskontrol.com.tr/login
```

### 9.2 Kullanılan Kimlik Bilgileri (Scraper İçin)
```
Kullanıcı adı: elmsravyödeme
Şifre: 123456
```

### 9.3 scrape.js Ne Yapar?
- Siteye giriş yapar
- Login formunun HTML yapısını çıkarır
- Giriş sonrası menü linklerini ve sayfa içeriğini loglar

### 9.4 scrape2.js Ne Yapar?
- Giriş yapar
- Sidebar'daki tüm navigasyon linklerini çeker
- `/musteriler`, `/faturalar`, `/raporlar`, `/loglar` vb. sayfalara giderek tablo başlıklarını ve form alanlarını çıkarır
- Referans sistemin tüm yapısını anlamak için yazılmıştır

### 9.5 Çalıştırmak İçin
```bash
cd "/Users/emre/Desktop/Emare Log"
node scrape.js
node scrape2.js
```
> **Not:** Node bağımlılıkları kurulu olmalı: `npm install`

---

## 10. GELİŞTİRME ORTAMI

### 10.1 Kurulum Adımları
```bash
cd /Users/emre/Desktop/Emare\ Log/logmanager

# PHP bağımlılıkları
composer install

# .env dosyasını oluştur
cp .env.example .env
php artisan key:generate

# Veritabanı migration
php artisan migrate

# Frontend bağımlılıkları
npm install
npm run build
```

### 10.2 Geliştirme Sunucusu (Hepsi Aynı Anda)
```bash
composer run dev
```
Bu komut şunları eş zamanlı başlatır:
- `php artisan serve` — PHP sunucusu
- `php artisan queue:listen` — Kuyruk işçisi
- `php artisan pail` — Log izleyici
- `npm run dev` — Vite hot-reload

### 10.3 Veritabanı Ayarı
`.env` dosyasında varsayılan SQLite kullanılıyor. MySQL'e geçmek için:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=logmanager
DB_USERNAME=root
DB_PASSWORD=
```

### 10.4 Test
```bash
composer run test
# veya
php artisan test
```

---

## 11. GÖRÜNÜMLER (VIEWS)

`resources/views/` klasörü henüz doldurulma aşamasında.  
Her modül için bir Blade view dosyası gerekiyor.  
`create_views.php` adlı bir yardımcı script mevcut — view iskeletlerini oluşturmak için muhtemelen kullanılıyor.

---

## 12. MİKROTİK ENTEGRASYONU

- `mikrotikler` tablosu cihazın IP, port ve kimlik bilgilerini saklar
- `radius`, `accounting`, `interim` alanları RADIUS protokol desteğini gösterir
- `test_mikrotik.php` dosyası MikroTik API bağlantısını test etmek için hazır
- PPP kullanıcı listesi, hat kapasite yönetimi ve VPN panel üzerinden yönetilir

---

## 13. LOGLAMA SİSTEMİ

Sistem 8 farklı log türü tutar:

| Log Türü | Tablo | Açıklama |
|---|---|---|
| Panel Logları | `panel_loglari` | Kimin ne yaptığı |
| Abone Logları | `abone_loglari` | Aboneye yapılan işlemler |
| MikroTik Logları | `mikrotik_loglari` | Router mesajları |
| Oturum Logları | `oturum_loglari` | RADIUS bağlantı/sonlanma |
| Port Logları | (route mevcut) | Port bazlı loglar |
| 5651 Logları | (route mevcut) | 5651 sayılı kanun logları |
| SAS Verisi | (route mevcut) | SAS entegrasyon verileri |
| BTK Hataları | (route mevcut) | BTK rehber hata kayıtları |

---

## 14. NEREDE KALDIK / YAPILACAKLAR

> Bu bölümü çalışmaya devam ederken güncelle.

### ✅ Tamamlananlar
- [x] Veritabanı migration dosyası (tüm tablolar tek dosyada)
- [x] Tüm Eloquent modeller oluşturuldu (`app/Models/`)
- [x] Tüm Controller'lar oluşturuldu (`app/Http/Controllers/`)
- [x] `routes/web.php` tüm URL rotaları tanımlandı
- [x] Frontend bağımlılıkları belirlendi (Bootstrap 5, Chart.js, DataTables, Select2, SweetAlert2)
- [x] Vite build sistemi kuruldu
- [x] Dashboard istatistikleri (`HomeController`)
- [x] Auth sistemi (Laravel UI)

### 🔲 Yapılacaklar (Sıradaki Adımlar)
- [ ] **Blade view şablonları** — Her controller için view dosyası yazılmalı
  - Öncelikli: `home.blade.php` (dashboard), `musteriler/index.blade.php`, `musteriler/create.blade.php`
- [ ] **Ana layout** — `resources/views/layouts/app.blade.php` (sidebar, navbar)
- [ ] **Controller metotları** — Her controller'ın tüm metodları kodlanmalı (şu an stub durumda olabilir)
- [ ] **Validasyon kuralları** — Form Request sınıfları
- [ ] **MikroTik API bağlantısı** — Gerçek cihaz entegrasyonu
- [ ] **SMS entegrasyonu** — Provider bağlantısı (netgsm vb.)
- [ ] **E-fatura entegrasyonu** — GİB bağlantısı
- [ ] **WhatsApp entegrasyonu** — API bağlantısı
- [ ] **RADIUS entegrasyonu** — PPPoE oturum yönetimi
- [ ] **Raporlar** — Chart.js grafikleri
- [ ] **Test yazımı** — Feature testler

---

## 15. ÖNEMLİ DOSYALAR VE YOLLARI

| Dosya | Yol |
|---|---|
| Bu hafıza dosyası | `/Users/emre/Desktop/Emare Log/EMARE_LOG_HAFIZA.md` |
| Migration (veritabanı) | `logmanager/database/migrations/2024_01_01_000001_create_all_tables.php` |
| Tüm rotalar | `logmanager/routes/web.php` |
| Dashboard | `logmanager/app/Http/Controllers/HomeController.php` |
| Modeller klasörü | `logmanager/app/Models/` |
| Controller'lar | `logmanager/app/Http/Controllers/` |
| Frontend giriş | `logmanager/resources/js/app.js` |
| SCSS giriş | `logmanager/resources/sass/app.scss` |
| Vite config | `logmanager/vite.config.js` |
| Composer bağımlılıklar | `logmanager/composer.json` |
| NPM bağımlılıklar (logmanager) | `logmanager/package.json` |
| NPM bağımlılıklar (scraper) | `/Users/emre/Desktop/Emare Log/package.json` |
| MikroTik test | `logmanager/test_mikrotik.php` |
| View oluşturucu | `logmanager/create_views.php` |

---

## 16. NOTLAR ve HATIRLATMALAR

1. **Tek migration dosyası:** Tüm tablolar `2024_01_01_000001_create_all_tables.php` içinde. Yeni tablo eklerken bu dosyaya ekleme yapmak yerine yeni bir migration dosyası oluştur.

2. **Soft delete:** `musteriler` ve `faturalar` tablolarında `softDeletes()` var — silinen kayıtlar gerçekten silinmiyor.

3. **Müşteri abone_no:** `musteriler.abone_no` unique. Oluşturma sırasında otomatik üretilmeli.

4. **Yetki sistemi:** `users.yetkiler` alanı JSON saklıyor — detaylı yetki yapısı henüz tanımlanmadı.

5. **Scraper kimlik bilgileri** (`elmsravyödeme` / `123456`) sadece araştırma amaçlıdır — production'a taşıma.

6. **Veritabanı:** Varsayılan SQLite, canlı ortamda MySQL kullanılacak.

7. **Laravel 12:** `bootstrap/app.php` ile middleware kayıtları yapılıyor (artık `Kernel.php` yok).

---

*Bu dosya projeyle birlikte taşınabilir. VS Code'da açık bırak, çalışmaya devam et.*
