# 📁 Emare Log — LogManager — Dosya Yapısı

> **Oluşturulma:** Otomatik  
> **Amaç:** Yapay zekalar kod yazmadan önce mevcut dosya yapısını incelemeli

---

## Proje Dosya Ağacı

```
/Users/emre/Desktop/Emare/Emare Log
├── EMARE_LOG_HAFIZA.md
├── EMARE_ORTAK_CALISMA -> /Users/emre/Desktop/Emare/EMARE_ORTAK_CALISMA
├── logmanager
│   ├── .editorconfig
│   ├── .env
│   ├── .env.example
│   ├── .gitattributes
│   ├── .gitignore
│   ├── DOSYA_YAPISI.md
│   ├── EMARE_AI_COLLECTIVE.md
│   ├── EMARE_ANAYASA.md
│   ├── EMARE_ORTAK_CALISMA
│   │   ├── EMARE_AI_COLLECTIVE.md
│   │   ├── EMARE_ANAYASA.md
│   │   ├── EMARE_ORTAK_HAFIZA.md
│   │   ├── README.md
│   │   └── projects.json
│   ├── EMARE_ORTAK_HAFIZA.md
│   ├── README.md
│   ├── app
│   │   ├── Http
│   │   │   └── Controllers
│   │   ├── Models
│   │   │   ├── AboneLogu.php
│   │   │   ├── ApiAnahtari.php
│   │   │   ├── Arac.php
│   │   │   ├── AramaEmri.php
│   │   │   ├── Ayar.php
│   │   │   ├── Basvuru.php
│   │   │   ├── BlogYazisi.php
│   │   │   ├── Bolge.php
│   │   │   ├── Cari.php
│   │   │   ├── CariFatura.php
│   │   │   ├── Depo.php
│   │   │   ├── Devre.php
│   │   │   ├── Duyuru.php
│   │   │   ├── Evrak.php
│   │   │   ├── Fatura.php
│   │   │   ├── GelirGider.php
│   │   │   ├── GenelAriza.php
│   │   │   ├── Hakedis.php
│   │   │   ├── Hat.php
│   │   │   ├── HavaleBildirimi.php
│   │   │   ├── Hizmet.php
│   │   │   ├── IpAdresi.php
│   │   │   ├── IsEmri.php
│   │   │   ├── IsTanimi.php
│   │   │   ├── Istasyon.php
│   │   │   ├── Kampanya.php
│   │   │   ├── Kasa.php
│   │   │   ├── KasaHareketi.php
│   │   │   ├── Mikrotik.php
│   │   │   ├── MikrotikLogu.php
│   │   │   ├── Musteri.php
│   │   │   ├── MusteriGrubu.php
│   │   │   ├── MusteriNotu.php
│   │   │   ├── Odeme.php
│   │   │   ├── OtomatikCekim.php
│   │   │   ├── OturumLogu.php
│   │   │   ├── PanelLogu.php
│   │   │   ├── Personel.php
│   │   │   ├── SmsAyari.php
│   │   │   ├── SmsGonderimi.php
│   │   │   ├── SmsSablonu.php
│   │   │   ├── Stok.php
│   │   │   ├── Tarife.php
│   │   │   ├── TeknikServis.php
│   │   │   ├── TelekomBasvuru.php
│   │   │   ├── Ticket.php
│   │   │   ├── TicketCevap.php
│   │   │   ├── Urun.php
│   │   │   ├── User.php
│   │   │   ├── Verici.php
│   │   │   ├── VpnKullanici.php
│   │   │   ├── WhatsappAyari.php
│   │   │   └── YasaklananTc.php
│   │   └── Providers
│   │       └── AppServiceProvider.php
│   ├── artisan
│   ├── bootstrap
│   │   ├── app.php
│   │   ├── cache
│   │   │   ├── .gitignore
│   │   │   ├── packages.php
│   │   │   └── services.php
│   │   └── providers.php
│   ├── composer.json
│   ├── composer.lock
│   ├── config
│   │   ├── app.php
│   │   ├── auth.php
│   │   ├── cache.php
│   │   ├── database.php
│   │   ├── filesystems.php
│   │   ├── logging.php
│   │   ├── mail.php
│   │   ├── queue.php
│   │   ├── services.php
│   │   └── session.php
│   ├── create_views.php
│   ├── database
│   │   ├── .gitignore
│   │   ├── database.sqlite
│   │   ├── factories
│   │   │   └── UserFactory.php
│   │   ├── migrations
│   │   │   └── 2024_01_01_000001_create_all_tables.php
│   │   └── seeders
│   │       └── DatabaseSeeder.php
│   ├── package-lock.json
│   ├── package.json
│   ├── phpunit.xml
│   ├── public
│   │   ├── .htaccess
│   │   ├── favicon.ico
│   │   ├── index.php
│   │   └── robots.txt
│   ├── resources
│   │   ├── css
│   │   │   └── app.css
│   │   ├── js
│   │   │   ├── app.js
│   │   │   └── bootstrap.js
│   │   ├── sass
│   │   │   ├── _variables.scss
│   │   │   └── app.scss
│   │   └── views
│   │       ├── api_sistem
│   │       ├── araclar
│   │       ├── arama_emirleri
│   │       ├── auth
│   │       ├── ayarlar
│   │       ├── basvurular
│   │       ├── bayi
│   │       ├── blog
│   │       ├── destek
│   │       ├── evrak
│   │       ├── faturalar
│   │       ├── genel_ariza
│   │       ├── guncelleme_listesi.blade.php
│   │       ├── hatlar
│   │       ├── home.blade.php
│   │       ├── ip
│   │       ├── istasyon
│   │       ├── kasa
│   │       ├── layouts
│   │       ├── loglar
│   │       ├── mikrotik
│   │       ├── musteriler
│   │       ├── partials
│   │       ├── personel
│   │       ├── raporlar
│   │       ├── sms
│   │       ├── stok
│   │       ├── tarifeler
│   │       ├── teknik_servis
│   │       ├── telekom
│   │       ├── welcome.blade.php
│   │       └── whatsapp
│   ├── routes
│   │   ├── console.php
│   │   └── web.php
│   ├── storage
│   │   ├── app
│   │   │   ├── .gitignore
│   │   │   ├── private
│   │   │   └── public
│   │   ├── framework
│   │   │   ├── .gitignore
│   │   │   ├── cache
│   │   │   ├── sessions
│   │   │   ├── testing
│   │   │   └── views
│   │   └── logs
│   │       ├── .gitignore
│   │       └── laravel.log
│   ├── test_mikrotik.php
│   ├── test_pages.php
│   ├── tests
│   │   ├── Feature
│   │   │   └── ExampleTest.php
│   │   ├── TestCase.php
│   │   └── Unit
│   │       └── ExampleTest.php
│   └── vite.config.js
├── package-lock.json
├── package.json
├── scrape.js
└── scrape2.js

65 directories, 125 files

```

---

## 📌 Kullanım Talimatları (AI İçin)

Bu dosya, kod üretmeden önce projenin mevcut yapısını kontrol etmek içindir:

1. **Yeni dosya oluşturmadan önce:** Bu ağaçta benzer bir dosya var mı kontrol et
2. **Yeni klasör oluşturmadan önce:** Mevcut klasör yapısına uygun mu kontrol et
3. **Import/require yapmadan önce:** Dosya yolu doğru mu kontrol et
4. **Kod kopyalamadan önce:** Aynı fonksiyon başka dosyada var mı kontrol et

**Örnek:**
- ❌ "Yeni bir auth.py oluşturalım" → ✅ Kontrol et, zaten `app/auth.py` var mı?
- ❌ "config/ klasörü oluşturalım" → ✅ Kontrol et, zaten `config/` var mı?
- ❌ `from utils import helper` → ✅ Kontrol et, `utils/helper.py` gerçekten var mı?

---

**Not:** Bu dosya otomatik oluşturulmuştur. Proje yapısı değiştikçe güncellenmelidir.

```bash
# Güncelleme komutu
python3 /Users/emre/Desktop/Emare/create_dosya_yapisi.py
```
