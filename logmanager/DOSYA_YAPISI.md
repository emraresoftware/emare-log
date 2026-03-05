# 📁 Emare Log — LogManager — Dosya Yapısı

> **Oluşturulma:** Otomatik  
> **Amaç:** Yapay zekalar kod yazmadan önce mevcut dosya yapısını incelemeli

---

## Proje Dosya Ağacı

```
/Users/emre/Desktop/Emare/Emare Log/logmanager
├── .editorconfig
├── .env
├── .env.example
├── .gitattributes
├── .gitignore
├── EMARE_AI_COLLECTIVE.md
├── EMARE_ORTAK_HAFIZA.md
├── README.md
├── app
│   ├── Http
│   │   └── Controllers
│   │       ├── ApiSistemController.php
│   │       ├── AracController.php
│   │       ├── AramaEmriController.php
│   │       ├── Auth
│   │       ├── AyarController.php
│   │       ├── BasvuruController.php
│   │       ├── BayiController.php
│   │       ├── BlogController.php
│   │       ├── CariController.php
│   │       ├── Controller.php
│   │       ├── DepoController.php
│   │       ├── EvrakController.php
│   │       ├── FaturaController.php
│   │       ├── GelirGiderController.php
│   │       ├── GenelArizaController.php
│   │       ├── HatController.php
│   │       ├── HomeController.php
│   │       ├── IpController.php
│   │       ├── IstasyonController.php
│   │       ├── KasaController.php
│   │       ├── LogController.php
│   │       ├── MikrotikController.php
│   │       ├── MusteriController.php
│   │       ├── PersonelController.php
│   │       ├── RaporController.php
│   │       ├── SmsController.php
│   │       ├── StokController.php
│   │       ├── TarifeController.php
│   │       ├── TeknikServisController.php
│   │       ├── TelekomController.php
│   │       ├── TicketController.php
│   │       ├── UrunController.php
│   │       └── WhatsappController.php
│   ├── Models
│   │   ├── AboneLogu.php
│   │   ├── ApiAnahtari.php
│   │   ├── Arac.php
│   │   ├── AramaEmri.php
│   │   ├── Ayar.php
│   │   ├── Basvuru.php
│   │   ├── BlogYazisi.php
│   │   ├── Bolge.php
│   │   ├── Cari.php
│   │   ├── CariFatura.php
│   │   ├── Depo.php
│   │   ├── Devre.php
│   │   ├── Duyuru.php
│   │   ├── Evrak.php
│   │   ├── Fatura.php
│   │   ├── GelirGider.php
│   │   ├── GenelAriza.php
│   │   ├── Hakedis.php
│   │   ├── Hat.php
│   │   ├── HavaleBildirimi.php
│   │   ├── Hizmet.php
│   │   ├── IpAdresi.php
│   │   ├── IsEmri.php
│   │   ├── IsTanimi.php
│   │   ├── Istasyon.php
│   │   ├── Kampanya.php
│   │   ├── Kasa.php
│   │   ├── KasaHareketi.php
│   │   ├── Mikrotik.php
│   │   ├── MikrotikLogu.php
│   │   ├── Musteri.php
│   │   ├── MusteriGrubu.php
│   │   ├── MusteriNotu.php
│   │   ├── Odeme.php
│   │   ├── OtomatikCekim.php
│   │   ├── OturumLogu.php
│   │   ├── PanelLogu.php
│   │   ├── Personel.php
│   │   ├── SmsAyari.php
│   │   ├── SmsGonderimi.php
│   │   ├── SmsSablonu.php
│   │   ├── Stok.php
│   │   ├── Tarife.php
│   │   ├── TeknikServis.php
│   │   ├── TelekomBasvuru.php
│   │   ├── Ticket.php
│   │   ├── TicketCevap.php
│   │   ├── Urun.php
│   │   ├── User.php
│   │   ├── Verici.php
│   │   ├── VpnKullanici.php
│   │   ├── WhatsappAyari.php
│   │   └── YasaklananTc.php
│   └── Providers
│       └── AppServiceProvider.php
├── artisan
├── bootstrap
│   ├── app.php
│   ├── cache
│   │   ├── .gitignore
│   │   ├── packages.php
│   │   └── services.php
│   └── providers.php
├── composer.json
├── composer.lock
├── config
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── create_views.php
├── database
│   ├── .gitignore
│   ├── database.sqlite
│   ├── factories
│   │   └── UserFactory.php
│   ├── migrations
│   │   └── 2024_01_01_000001_create_all_tables.php
│   └── seeders
│       └── DatabaseSeeder.php
├── package-lock.json
├── package.json
├── phpunit.xml
├── public
│   ├── .htaccess
│   ├── favicon.ico
│   ├── index.php
│   └── robots.txt
├── resources
│   ├── css
│   │   └── app.css
│   ├── js
│   │   ├── app.js
│   │   └── bootstrap.js
│   ├── sass
│   │   ├── _variables.scss
│   │   └── app.scss
│   └── views
│       ├── api_sistem
│       ├── araclar
│       │   ├── index.blade.php
│       │   └── takip_ayar.blade.php
│       ├── arama_emirleri
│       │   ├── create.blade.php
│       │   └── index.blade.php
│       ├── auth
│       │   ├── login.blade.php
│       │   ├── passwords
│       │   ├── register.blade.php
│       │   └── verify.blade.php
│       ├── ayarlar
│       │   └── genel.blade.php
│       ├── basvurular
│       │   ├── create.blade.php
│       │   └── index.blade.php
│       ├── bayi
│       │   ├── bolgeler.blade.php
│       │   ├── create.blade.php
│       │   ├── devreler.blade.php
│       │   ├── duyurular.blade.php
│       │   ├── index.blade.php
│       │   ├── kasa.blade.php
│       │   ├── kasa_hareket.blade.php
│       │   ├── kasa_kullanici.blade.php
│       │   ├── musteri_tasima.blade.php
│       │   ├── musteriler.blade.php
│       │   ├── tickets.blade.php
│       │   ├── yetki_atama.blade.php
│       │   └── yetkiler.blade.php
│       ├── blog
│       │   ├── create.blade.php
│       │   └── index.blade.php
│       ├── destek
│       │   └── index.blade.php
│       ├── evrak
│       │   ├── ayarlar.blade.php
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── faturalar
│       │   ├── bekleyen_siparisler.blade.php
│       │   ├── e_fatura_hata.blade.php
│       │   ├── efatura.blade.php
│       │   ├── ekle.blade.php
│       │   ├── havale.blade.php
│       │   ├── havale_bildirimleri.blade.php
│       │   ├── index.blade.php
│       │   ├── iptal.blade.php
│       │   ├── odeme_al.blade.php
│       │   ├── odenmis.blade.php
│       │   ├── offline_tahsilatlar.blade.php
│       │   ├── otomatik_cekimler.blade.php
│       │   ├── otomatik_talimatlar.blade.php
│       │   ├── paynkolay_rapor.blade.php
│       │   ├── taahhutlu.blade.php
│       │   └── tahsilat.blade.php
│       ├── genel_ariza
│       │   └── index.blade.php
│       ├── guncelleme_listesi.blade.php
│       ├── hatlar
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   ├── index.blade.php
│       │   ├── ip_hatali.blade.php
│       │   └── kapasite.blade.php
│       ├── home.blade.php
│       ├── ip
│       │   ├── borclu.blade.php
│       │   └── index.blade.php
│       ├── istasyon
│       │   ├── ag_haritasi.blade.php
│       │   ├── index.blade.php
│       │   └── vericiler.blade.php
│       ├── kasa
│       │   ├── cari_faturalar.blade.php
│       │   ├── cariler.blade.php
│       │   ├── gelir_gider.blade.php
│       │   └── index.blade.php
│       ├── layouts
│       │   └── app.blade.php
│       ├── loglar
│       │   ├── abone.blade.php
│       │   ├── abone_hareket.blade.php
│       │   ├── abone_rehber.blade.php
│       │   ├── btk_hata.blade.php
│       │   ├── hata_durum.blade.php
│       │   ├── log5651.blade.php
│       │   ├── mikrotik.blade.php
│       │   ├── oturum.blade.php
│       │   ├── panel.blade.php
│       │   ├── port.blade.php
│       │   ├── sas_veri.blade.php
│       │   ├── sunucu_durum.blade.php
│       │   └── veri_tarama.blade.php
│       ├── mikrotik
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   ├── hata_raporu.blade.php
│       │   ├── index.blade.php
│       │   ├── ip_yonetim.blade.php
│       │   ├── ppp_listesi.blade.php
│       │   ├── show.blade.php
│       │   └── vpn_listesi.blade.php
│       ├── musteriler
│       │   ├── create.blade.php
│       │   ├── e_devlet_basvurular.blade.php
│       │   ├── edit.blade.php
│       │   ├── gruplar.blade.php
│       │   ├── index.blade.php
│       │   ├── interneti_kesilenler.blade.php
│       │   ├── mac_arama.blade.php
│       │   ├── notlar.blade.php
│       │   ├── odeme_loglari.blade.php
│       │   ├── offline.blade.php
│       │   ├── on_basvurular.blade.php
│       │   ├── onay_bekleyen.blade.php
│       │   ├── online.blade.php
│       │   ├── online_basvurular.blade.php
│       │   ├── show.blade.php
│       │   ├── tarife_gecis_istekleri.blade.php
│       │   ├── vlan.blade.php
│       │   ├── yabanci.blade.php
│       │   └── yasaklanan_tcler.blade.php
│       ├── partials
│       │   └── musteri_filters.blade.php
│       ├── personel
│       │   ├── create.blade.php
│       │   ├── hakedis.blade.php
│       │   └── index.blade.php
│       ├── raporlar
│       │   ├── adres.blade.php
│       │   ├── bayi_bakiye.blade.php
│       │   ├── bayi_hakedis.blade.php
│       │   ├── bayiler_genel.blade.php
│       │   ├── binadaki_musteriler.blade.php
│       │   ├── cagri_istatistikleri.blade.php
│       │   ├── e_fatura_durum.blade.php
│       │   ├── eksik_evrak.blade.php
│       │   ├── genel_trafik.blade.php
│       │   ├── gun_sonu.blade.php
│       │   ├── kdv.blade.php
│       │   ├── musteri.blade.php
│       │   ├── satis.blade.php
│       │   ├── tahsilat.blade.php
│       │   ├── tarife.blade.php
│       │   ├── trafik.blade.php
│       │   └── veresiye.blade.php
│       ├── sms
│       │   ├── ayarlar.blade.php
│       │   ├── gonder.blade.php
│       │   ├── rapor.blade.php
│       │   └── sablonlar.blade.php
│       ├── stok
│       │   ├── arizali_urunler.blade.php
│       │   ├── depolar.blade.php
│       │   ├── index.blade.php
│       │   ├── musterideki_urunler.blade.php
│       │   ├── sokum_listesi.blade.php
│       │   ├── urun_gonder.blade.php
│       │   └── urunler.blade.php
│       ├── tarifeler
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   ├── hizmetler.blade.php
│       │   ├── index.blade.php
│       │   ├── istatistik.blade.php
│       │   ├── kampanyalar.blade.php
│       │   └── toplu_degistir.blade.php
│       ├── teknik_servis
│       │   ├── create.blade.php
│       │   ├── index.blade.php
│       │   ├── is_tanimlari.blade.php
│       │   └── rapor.blade.php
│       ├── telekom
│       │   ├── churn_listesi.blade.php
│       │   ├── churn_sorgu.blade.php
│       │   ├── degisiklik_basvurulari.blade.php
│       │   ├── durum_raporu.blade.php
│       │   ├── genel_ariza.blade.php
│       │   ├── index.blade.php
│       │   ├── olo_ariza_listesi.blade.php
│       │   ├── olo_ariza_teyit.blade.php
│       │   └── vae_faturalar.blade.php
│       ├── welcome.blade.php
│       └── whatsapp
│           └── ayarlar.blade.php
├── routes
│   ├── console.php
│   └── web.php
├── storage
│   ├── app
│   │   ├── .gitignore
│   │   ├── private
│   │   │   └── .gitignore
│   │   └── public
│   │       └── .gitignore
│   ├── framework
│   │   ├── .gitignore
│   │   ├── cache
│   │   │   ├── .gitignore
│   │   │   └── data
│   │   ├── sessions
│   │   │   ├── .gitignore
│   │   │   ├── 5XzbQLJprclyDoTHhPMJI4vTFkqa7m5aKNl700vX
│   │   │   ├── 79sjQyaChMbg4xnabvbQBX8I8Bnkr8w81oiT3lJn
│   │   │   ├── 7klMRoRcKItuJyPzwWY0TpNtWSq6U6Upj6Frjir9
│   │   │   ├── DQA7rd38qROoMCkgpzx7g2wtjOD3eRYCkyvS8uhB
│   │   │   ├── E7Xyf4xio0ylBTaX0JGSPipyMMcvcVwPfopquKH2
│   │   │   ├── IrsX2eCzKF9NmeiktTs2kFKC2XFzDB8snmC9UDG1
│   │   │   ├── KpFRFBEzuYzogsFMs8fx8Y7shVpRFzBhg0llUyf5
│   │   │   ├── MSKfq4cWPbGLTw1ZnAjNU3V6tqkyuq6Qy0OJg1cq
│   │   │   ├── PyeHBA4du36YIKlgkWH0ZkmPW67L0gcq9IttWfyj
│   │   │   ├── Q44MTdOmRLsJ6B5oLe1EmzESJqY0ETpGpZaXfA2W
│   │   │   ├── QqmmMldNCwJlbgbsodU2dYEW3Q0L18w3p3kC6xUd
│   │   │   ├── TJzqj84m6ErujNM1Vq93rG0n3vj3RvnwyVOrwYAt
│   │   │   ├── TqI5H83yEwqgOut0uUhn6lttmS3D8nuNcvulaDLE
│   │   │   ├── WI9wP72C3eeU7MnuRyN5CKcFGqgkr0M07lHHnmRB
│   │   │   ├── a7Ne7kjIoQovDG181FZ23tHTAT3FD6u1FnfKfPde
│   │   │   ├── f4oYCag08VdBYDsPPKAnPJKjorbty3gflnNbTPmY
│   │   │   ├── lkLm6smGWz2gP0aqVWko1ylyNbfpBLo1LqF5JjIP
│   │   │   ├── mQpEsGOWhKfMO3WM6zmqwTwB56dDFaqVwbUxBEkP
│   │   │   ├── oU8NfCYZDQzW2PHKabioSZmubrg46ld8fCvx4rnw
│   │   │   ├── qE0npirgySlvZmlki3i1vwT3mSG0jjvVgnfRsdkc
│   │   │   ├── scOxugW51wICKSwec4XmhyfUGmCY6Velz0E8tDOM
│   │   │   ├── tZAAqpQXwvB9nt6kXzhx2J6juKoeOlDBzlSLVPGJ
│   │   │   ├── ub2p1CaDSqA9pB0dNvV8voqaDzyUSgetaH9WkqCo
│   │   │   ├── ueiiLFR4M9v1Zc5iwwlPPCghJpqpHyVuS5WMXPhz
│   │   │   └── w5Hv8FreNq7hCTx8y2ElJGu7iEggPnANS1Sg79ni
│   │   ├── testing
│   │   │   └── .gitignore
│   │   └── views
│   │       ├── .gitignore
│   │       ├── 0126ebce33f74ddfbe4e74161d011542.php
│   │       ├── 01d073fe4b45c3fb4a5827b59896d91e.php
│   │       ├── 063b2fe0573297fb11caf1818338b35e.php
│   │       ├── 07ac9e6ff4868a67be5733b23579a2c3.php
│   │       ├── 08e111e7bbf5cf0280948df45d0b91de.php
│   │       ├── 0ac4a2397910f12c832d79f7512bcf51.php
│   │       ├── 0d0c1f2ef7f2d27d5f804ee39afd8227.php
│   │       ├── 0dee22f13a5f83771a50f6567d77fec5.php
│   │       ├── 118b969be27e027fed88ca1568b94e52.php
│   │       ├── 128b51f69c830ddc80ba30c0528c25c7.php
│   │       ├── 136edd5e6f1a807af109dc7ed20aa1c9.php
│   │       ├── 14cc33ec87b50b62b0f9053826f0ee83.php
│   │       ├── 16ad684a36cee1809060833377ee2242.php
│   │       ├── 16b2555a86cebbca4258fcfd2cef2d04.php
│   │       ├── 183dc708f632d6bb05c16a93453f3f72.php
│   │       ├── 1ba6c1f78478be68de96c7a19b707231.php
│   │       ├── 1bd1e18b29f4b74eafe91db0c895e9b2.php
│   │       ├── 1c9f3f3b0da07ee45dbedb6df8bd322f.php
│   │       ├── 1e57632e0eaf11a68ed7e8262ede5319.php
│   │       ├── 23d65def91d7eedf88688a7ecc174b39.php
│   │       ├── 2418b715350e40aecf0cf12f1bc94def.php
│   │       ├── 2431f03f2d4de12aec1a5cc7045525d6.php
│   │       ├── 24415557da5123b32ab9cf39fbe336aa.php
│   │       ├── 26000952f7d9fe8eb4dc346257d27ec4.php
│   │       ├── 265f8803faae14f1c22e20c6b68b002c.php
│   │       ├── 268edf7a447a74930cacb5a1812f1016.php
│   │       ├── 27074f1530a53d7bbde4bfe4735a0b71.php
│   │       ├── 271b5b6df96425232f2ef71bf4e43c6a.php
│   │       ├── 2777b46529f13bfae36474b77fbda8d3.php
│   │       ├── 294fe4d09633f7efd85fdff48bf1c5f1.php
│   │       ├── 2c2d498c4208dccb8f336e400ead6985.php
│   │       ├── 2d69d6e67ddffe68adf301783cf4d80d.php
│   │       ├── 2df8c00fc7049074db5e9a64464c2b22.php
│   │       ├── 2feffad149c3fc8455f57416f48e95e3.php
│   │       ├── 315f6b1dca356761fb2a8e45098d353a.php
│   │       ├── 3213041e5077148f0c3c6b9f3b343297.php
│   │       ├── 335d8dfc4d7345e867db219fbff63760.php
│   │       ├── 340793cf4d1d6b0b857542b7772b56bd.php
│   │       ├── 353cceb457638ac7728da651c1344d1a.php
│   │       ├── 367594eca865bfd03d2ba12a4bbf1745.php
│   │       ├── 369f08e937bba90e1010e79e58083148.php
│   │       ├── 36d716309d995ecf3e4517005e0b0847.php
│   │       ├── 39ec84318e815e915570fb7e5155e1b9.php
│   │       ├── 3bf2f3ac0eb380d0a7b03ade06ecada9.php
│   │       ├── 3fabdc43b14e5ed92c447f0a704a8501.php
│   │       ├── 42ce9650c6ca821bd62e2ab6591ba8f4.php
│   │       ├── 44001b06004abc92ab6354d1783a4912.php
│   │       ├── 4412d708e445be07bcecaf45810dc1af.php
│   │       ├── 44671b2eb6160242401ef5d94c0a4672.php
│   │       ├── 446b9c068e50725a4d02df8e37fd06dd.php
│   │       ├── 4688e56c6459b4a62cb418bce631b12d.php
│   │       ├── 4af53ba960a4165bc961716f277ab74b.php
│   │       ├── 4b4146ddaf6315a5f9339c7cf3f37c2e.php
│   │       ├── 4c20bdc8533ad8136ddd2c822efe1932.php
│   │       ├── 4c4fde45c902c7e717ed1718f134a997.php
│   │       ├── 4e298590826b5382845695f5ecaec98c.php
│   │       ├── 4fce11e618044f4a5e2c452b333ac520.php
│   │       ├── 502f7192beba7155efe908300d453985.php
│   │       ├── 507c0fb8140cd56c0d72d4c3afb2ce82.php
│   │       ├── 529d598d53c5506ca4f71554e831cc15.php
│   │       ├── 534d0637c9512da36ac8d2cf5be5e24a.php
│   │       ├── 551af4fa87a3145aae8767a2cccd347a.php
│   │       ├── 55855289b6b08541e8633e616c9de1b8.php
│   │       ├── 563614d51673880333f6e3259bc070f4.php
│   │       ├── 56c3fb1778effa64cf4edf6da8de15fb.php
│   │       ├── 571e09d0e527dc0ef867c22a50ead485.php
│   │       ├── 598733acae5af3c3f5c15d25c4670802.php
│   │       ├── 59a01844b444e3ed672ddc16e51bd089.php
│   │       ├── 5a45f61864d3b4f122b1f78111104d9a.php
│   │       ├── 5d4185cb37aac3e6f4e7dad1530dbe11.php
│   │       ├── 5d56271623093cd6d579971c1eab3b2b.php
│   │       ├── 602e24ecc7241ec7e1804ea28a1d571e.php
│   │       ├── 60a9f46ec9ffef41a0dec7a09aa72098.php
│   │       ├── 631ce5dabc5af72eb75ab2384576d423.php
│   │       ├── 63acd0264fd07520c749a0289cde36e7.php
│   │       ├── 644af8bc3cc568c62984e33daa6ffdae.php
│   │       ├── 655ec0cc9c0c5627e3eaa4982fb33756.php
│   │       ├── 6609cdcef1c593a668cb233b8e60bfe2.php
│   │       ├── 667d861c3865b29b69599bbeb255a138.php
│   │       ├── 67701110e2e485627af9a4eb0ab0212d.php
│   │       ├── 689d645002247e883fc5a8f035dc5369.php
│   │       ├── 68dd85ab249bffcff74f66281a0ca3ff.php
│   │       ├── 68fd754a4bb90432efd9d4bae91e4a98.php
│   │       ├── 6921c52b57749a608c442c036859c182.php
│   │       ├── 696052da5d73549b93bd14a7a816c9d1.php
│   │       ├── 6c8154504cef0624a0be426a2e4ee7d5.php
│   │       ├── 6c9286160d4965d0dba1103e138055ac.php
│   │       ├── 6d13bf4489c4b612c98649fe6fe15af9.php
│   │       ├── 70448ea00f09daf990b20153682b5699.php
│   │       ├── 70845067bc6edc24b494944eedefef69.php
│   │       ├── 75d387fc0f2d22afe7c796810b7137ac.php
│   │       ├── 75f1b4f96ae8e7d92e6df8e82efcd590.php
│   │       ├── 791d3e121e8b53aa21a9f2901bf60057.php
│   │       ├── 7a6199c3449f3c576338ce19db6d463c.php
│   │       ├── 80586a6a0ebacda08d5e3a0d3abd33f2.php
│   │       ├── 80ba5e3b67b3666e3d9ddd805112a5f6.php
│   │       ├── 82858743b7cd2d669da26c21e1366d7c.php
│   │       ├── 82fefa2eab7943e047bed08e8a80d274.php
│   │       ├── 8521db9e2c97c0d4bdfad3562cca30fe.php
│   │       ├── 855d9bc8c8b3e1df8d942cfedfd52f88.php
│   │       ├── 856a644979fcca40a07ad8c6dde9a74e.php
│   │       ├── 85d3b75d2d017a89f1974534d3f2a30e.php
│   │       ├── 86e609f5b63b269a85dc3f2ae91ea6ce.php
│   │       ├── 8777a52c2e0154bbc51d5ef232859b54.php
│   │       ├── 88bd04c1a5579e18023f0e1e06c3bb6e.php
│   │       ├── 8ac1aad042cf828e76706a2384ba8dc4.php
│   │       ├── 8b01bbd0c619aa4a5529a0f2d2c0f3c2.php
│   │       ├── 8b1d27e8158badbc69202b1756bde772.php
│   │       ├── 8b2fa4ad3241ed13228928ecda5d01ff.php
│   │       ├── 8f765862ac6b2d0f3aee014739a16e52.php
│   │       ├── 8f90b9bd3abaa77964a91371d289826a.php
│   │       ├── 8ff0446d550a3ab3cd53824b45d6dc11.php
│   │       ├── 906beee87eb21f6c0c71ed1ecc5642fd.php
│   │       ├── 928b8b80b3b02c2ce1aaa78bfcf88c86.php
│   │       ├── 948888d11c33b951915eccc575ccc03b.php
│   │       ├── 951f1f7c096ef29c847ca96fe0514a8e.php
│   │       ├── 96a4a29d35ae9475591c61df762bcc91.php
│   │       ├── 9a0f30cee42cf6993a76f5a26119cd3e.php
│   │       ├── 9acb5a4331229fe9479c47c856d0f7d1.php
│   │       ├── 9ba21c82907a7515aaccaac70e42c925.php
│   │       ├── 9d5fdb2a3ef3d46eb7001c033450b271.php
│   │       ├── 9eb06138791b83f4548387cb739f5e72.php
│   │       ├── 9edbbe2af0146dd0e02cd79000883be7.php
│   │       ├── a00388ff1e5478572c4a4053cf06330b.php
│   │       ├── a13755de8ddd5bac8db47f0588a3bbe4.php
│   │       ├── a1fc8a30c933eae3ac972f453a7d668d.php
│   │       ├── a364e021e456219f34ed41d02c939361.php
│   │       ├── a3aa3c4333664a0b762d2c5143748517.php
│   │       ├── a50e5ea6dadff06f7294d0eee93aee13.php
│   │       ├── a5ba8a12891ddc1e9479872cfb3f6a3f.php
│   │       ├── a8fb182130bc0fdca8bbc751fe0e3d04.php
│   │       ├── a95aaacb596dd502c678c5b6871a299e.php
│   │       ├── a9e84ba019ce1038fa92a9085ae95ab0.php
│   │       ├── aa73869a1eb7480afb3023d203fc6325.php
│   │       ├── aa7e74102ffb8028afc40284643a1cb8.php
│   │       ├── ab00a3ef53729b9bbab50fbb156ef0d6.php
│   │       ├── abb87ad13f5151c33a3861b21a24e1db.php
│   │       ├── ad3e894c24939e69447f158a2464dc75.php
│   │       ├── af5ac81a7778d73ccff3c1ae89ed32e7.php
│   │       ├── b044e3946f1a1fb702221f79e5a00f1e.php
│   │       ├── b3a6c7af2e281b918ab65de3c149b0e7.php
│   │       ├── b47c0051abcc89e259f1d33a352f0caa.php
│   │       ├── b69daccdd5a02fb6b6acba1ffda19231.php
│   │       ├── b9a0ea8b5a1588e69ca1bb4841bf7675.php
│   │       ├── bc60e992782622565f7eee1645bf9a3a.php
│   │       ├── bcd8e39db5144e0ba25a003a0f6ebd13.php
│   │       ├── be3ab5492189bae988ff685a6f3e1eeb.php
│   │       ├── bfdb5213e1b3fce3f1476663e054a286.php
│   │       ├── c35ff40ca14d2855a0b97593ab5dac66.php
│   │       ├── c3847f4de4d1989af2c575b708fa97cb.php
│   │       ├── c3afab1ab22bbd5f410916d34b12ad31.php
│   │       ├── c8a3abdb6c76992716f3830e7925296f.php
│   │       ├── c9386a567ccfabb15b990fdb8fad025e.php
│   │       ├── c93aca6440c07a5c540124e6dfa84283.php
│   │       ├── c97f28d81a1d659a2a27a4c27f2fc3bb.php
│   │       ├── ca4a79ce6f2785475cfc5ba42ffee2f8.php
│   │       ├── cba83260213da05793ae62db17f4e0b3.php
│   │       ├── cbfb42c6352d2e4b94f2ecbe92261f2b.php
│   │       ├── cdbaadd25971e53c775545f57ae8b7d8.php
│   │       ├── ce10a886e4db16f3c47a6d0449636255.php
│   │       ├── ce23af261434ba7dc7ccca944db4742b.php
│   │       ├── ceb8fa4a7862cfedc9ba627417dbc862.php
│   │       ├── cf022be0ac7b33efd7fc6b5d6f21fd5d.php
│   │       ├── cf09d0c9d9d5ee250dabd70b7a52928a.php
│   │       ├── d1500a611f092ee7a1d3e31bf5d0ce1b.php
│   │       ├── d274c8bc353930cc9f2c77dec235636f.php
│   │       ├── d3eefbf9b3a98848e3cd47c791843ce3.php
│   │       ├── d56795fc59d5a2666e1e7ddc12de4f75.php
│   │       ├── d98951e363f17d9a69e90ca28f0e0666.php
│   │       ├── db049e17d13452fb8bea962c4112653e.php
│   │       ├── db1068e665d3638f12c0ff10ce5db404.php
│   │       ├── dfade69918af987cd1b1f75448168145.php
│   │       ├── dfed18b4bbff9070bcc0c7b3babea9dd.php
│   │       ├── e11de16135f79b2eaffc25a22fa28648.php
│   │       ├── e45aa96f3d58120683a4a0861fb6d7f4.php
│   │       ├── e56dc5e988195ac67dc20816f09e7e6f.php
│   │       ├── e5793475e0d67dbacb421ca7c0ac8be0.php
│   │       ├── e65eb0fc2578278810f04554069defc5.php
│   │       ├── e73bbe414c3e3115d900f4ebca82d9cd.php
│   │       ├── e944b0d69efc40c3fe2e60d868fec593.php
│   │       ├── eaf46ed557eeaf1a59e5387a8688bae8.php
│   │       ├── ed470c550b7d62bb9d2b4afd0eccd6a2.php
│   │       ├── f1663c97cde1c37704c7f6e07294ddc9.php
│   │       ├── f1aaa6e2418299e3ba473e51dadbc712.php
│   │       ├── f41698ab81e47b1a883321b53fc70190.php
│   │       ├── f7f27112426c690f67079d8c8ff1c956.php
│   │       ├── f80fef4354cb22b6a5b275510a96d89c.php
│   │       ├── fc1dd50dde3ac31ee285f5b3d3bd79fd.php
│   │       └── fd850c4aa6c0c47afc6e064a2f942922.php
│   └── logs
│       ├── .gitignore
│       └── laravel.log
├── test_mikrotik.php
├── test_pages.php
├── tests
│   ├── Feature
│   │   └── ExampleTest.php
│   ├── TestCase.php
│   └── Unit
│       └── ExampleTest.php
└── vite.config.js

65 directories, 519 files

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
