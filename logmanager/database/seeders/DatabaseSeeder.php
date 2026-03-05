<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===================== BÖLGELER =====================
        $bolgeler = [];
        foreach (['Merkez', 'Kuzey', 'Güney', 'Doğu', 'Batı'] as $bolge) {
            $bolgeler[] = DB::table('bolgeler')->insertGetId([
                'ad' => $bolge,
                'aciklama' => $bolge . ' Bölgesi',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ===================== ADMIN KULLANICI =====================
        $adminId = DB::table('users')->insertGetId([
            'kullanici_adi' => 'admin',
            'ad' => 'Sistem',
            'soyad' => 'Yöneticisi',
            'email' => 'admin@hiperlog.com',
            'telefon' => '05551234567',
            'password' => Hash::make('123456'),
            'bolge_id' => $bolgeler[0],
            'rol' => 'admin',
            'aktif' => true,
            'yetkiler' => json_encode(['*']),
            'son_giris' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // İkinci kullanıcı (Bayi)
        $bayiId = DB::table('users')->insertGetId([
            'kullanici_adi' => 'bayi1',
            'ad' => 'Ahmet',
            'soyad' => 'Yılmaz',
            'email' => 'bayi1@hiperlog.com',
            'telefon' => '05559876543',
            'password' => Hash::make('123456'),
            'bolge_id' => $bolgeler[1],
            'rol' => 'bayi',
            'aktif' => true,
            'yetkiler' => json_encode(['musteri_goruntule', 'musteri_ekle', 'musteri_duzenle', 'odeme_al', 'fatura_kes']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ===================== TARİFELER =====================
        $tarifeler = [];
        $tarifeBilgileri = [
            ['ad' => 'Fiber 25 Mbps', 'tip' => 'fiber', 'download_hiz' => 25000, 'upload_hiz' => 5000, 'fiyat' => 199.00],
            ['ad' => 'Fiber 50 Mbps', 'tip' => 'fiber', 'download_hiz' => 50000, 'upload_hiz' => 10000, 'fiyat' => 299.00],
            ['ad' => 'Fiber 100 Mbps', 'tip' => 'fiber', 'download_hiz' => 100000, 'upload_hiz' => 20000, 'fiyat' => 449.00],
            ['ad' => 'VDSL 25 Mbps', 'tip' => 'vdsl', 'download_hiz' => 25000, 'upload_hiz' => 5000, 'fiyat' => 179.00],
            ['ad' => 'VDSL 50 Mbps', 'tip' => 'vdsl', 'download_hiz' => 50000, 'upload_hiz' => 10000, 'fiyat' => 249.00],
            ['ad' => 'Kurumsal 100 Mbps', 'tip' => 'kurumsal', 'download_hiz' => 100000, 'upload_hiz' => 100000, 'fiyat' => 999.00],
        ];

        foreach ($tarifeBilgileri as $t) {
            $kdvDahil = $t['fiyat'] * 1.20;
            $tarifeler[] = DB::table('tarifeler')->insertGetId([
                'ad' => $t['ad'],
                'bayi_id' => $adminId,
                'tip' => $t['tip'],
                'hiz' => ($t['download_hiz'] / 1000) . 'Mbps/' . ($t['upload_hiz'] / 1000) . 'Mbps',
                'download_hiz' => $t['download_hiz'],
                'upload_hiz' => $t['upload_hiz'],
                'fiyat' => $t['fiyat'],
                'kdv_dahil_fiyat' => round($kdvDahil, 2),
                'kdv_orani' => 20,
                'sure_gun' => 30,
                'taahhut_suresi' => 24,
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ===================== HİZMETLER =====================
        foreach (['Kurulum Hizmeti', 'Modem Satışı', 'IP Adresi (Statik)', 'Taşıma Hizmeti'] as $hizmet) {
            DB::table('hizmetler')->insert([
                'ad' => $hizmet,
                'fiyat' => rand(50, 200),
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ===================== KAMPANYALAR =====================
        DB::table('kampanyalar')->insert([
            'ad' => 'Yılbaşı Kampanyası',
            'aciklama' => '3 ay %50 indirim',
            'indirim_orani' => 50,
            'baslangic_tarihi' => now()->startOfMonth(),
            'bitis_tarihi' => now()->addMonths(3),
            'aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ===================== MİKROTİKLER =====================
        $mikrotikler = [];
        $mikrotikBilgileri = [
            ['ad' => 'MK-MERKEZ-01', 'ip' => '192.168.1.1', 'port' => 8728],
            ['ad' => 'MK-KUZEY-01', 'ip' => '192.168.2.1', 'port' => 8728],
            ['ad' => 'MK-GUNEY-01', 'ip' => '192.168.3.1', 'port' => 8728],
        ];

        foreach ($mikrotikBilgileri as $mk) {
            $mikrotikler[] = DB::table('mikrotikler')->insertGetId([
                'ad' => $mk['ad'],
                'ip_adresi' => $mk['ip'],
                'api_port' => $mk['port'],
                'kullanici_adi' => 'admin',
                'sifre' => 'mikrotik123',
                'bolge_id' => $bolgeler[array_rand($bolgeler)],
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ===================== HATLAR =====================
        $hatlar = [];
        foreach ($mikrotikler as $mkId) {
            for ($i = 1; $i <= 3; $i++) {
                $hatlar[] = DB::table('hatlar')->insertGetId([
                    'ad' => 'Hat-' . $mkId . '-' . $i,
                    'mikrotik_id' => $mkId,
                    'kapasite' => 100,
                    'aktif' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ===================== İSTASYONLAR =====================
        foreach (['Merkez İstasyon', 'Kuzey İstasyon', 'Güney İstasyon'] as $idx => $ist) {
            DB::table('istasyonlar')->insertGetId([
                'ad' => $ist,
                'konum' => 'Ankara / Çankaya',
                'enlem' => 39.925533 + ($idx * 0.01),
                'boylam' => 32.866287 + ($idx * 0.01),
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ===================== KASALAR =====================
        $kasaId = DB::table('kasalar')->insertGetId([
            'ad' => 'Ana Kasa',
            'aciklama' => 'Merkez Şube Kasa',
            'bakiye' => 15000.00,
            'sorumlu_id' => $adminId,
            'aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ===================== DEPOLAR =====================
        DB::table('depolar')->insertGetId([
            'ad' => 'Merkez Depo',
            'adres' => 'Merkez Şube',
            'sorumlu_id' => $adminId,
            'aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ===================== ÜRÜNLER =====================
        $urunBilgileri = [
            ['ad' => 'ZTE F660 Modem', 'marka' => 'ZTE', 'model' => 'F660', 'fiyat' => 350],
            ['ad' => 'Huawei HG8245 Modem', 'marka' => 'Huawei', 'model' => 'HG8245', 'fiyat' => 400],
            ['ad' => 'TP-Link Archer C6', 'marka' => 'TP-Link', 'model' => 'Archer C6', 'fiyat' => 500],
            ['ad' => 'CAT6 Kablo (100m)', 'marka' => 'Generic', 'model' => 'CAT6', 'fiyat' => 150],
        ];

        foreach ($urunBilgileri as $urun) {
            DB::table('urunler')->insertGetId([
                'ad' => $urun['ad'],
                'marka' => $urun['marka'],
                'model' => $urun['model'],
                'fiyat' => $urun['fiyat'],
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ===================== İŞ TANIMLARI =====================
        $isTanimlari = [];
        foreach (['Kurulum', 'Arıza Giderme', 'Modem Değişimi', 'Hat Taşıma', 'IP Değişikliği'] as $is) {
            $isTanimlari[] = DB::table('is_tanimlari')->insertGetId([
                'ad' => $is,
                'aciklama' => $is . ' işlemi',
                'tahmini_sure' => rand(30, 120),
                'ucret' => rand(0, 150),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ===================== PERSONELLER =====================
        $personeller = [];
        $personelBilgileri = [
            ['ad' => 'Mehmet', 'soyad' => 'Kaya', 'departman' => 'Teknik', 'gorev' => 'Tekniker'],
            ['ad' => 'Ali', 'soyad' => 'Demir', 'departman' => 'Teknik', 'gorev' => 'Tekniker'],
            ['ad' => 'Fatma', 'soyad' => 'Yıldız', 'departman' => 'Muhasebe', 'gorev' => 'Muhasebeci'],
        ];

        foreach ($personelBilgileri as $p) {
            $personeller[] = DB::table('personeller')->insertGetId([
                'ad' => $p['ad'],
                'soyad' => $p['soyad'],
                'telefon' => '0555' . rand(1000000, 9999999),
                'email' => strtolower($p['ad']) . '@firma.com',
                'departman' => $p['departman'],
                'gorev' => $p['gorev'],
                'maas' => rand(8000, 15000),
                'ise_giris_tarihi' => now()->subMonths(rand(1, 36)),
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ===================== SMS AYARLARI =====================
        DB::table('sms_ayarlari')->insert([
            'provider' => 'netgsm',
            'api_key' => 'demo_api_key',
            'api_secret' => 'demo_secret',
            'sender_id' => 'HIPERLOG',
            'aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ===================== SMS ŞABLONLARI =====================
        DB::table('sms_sablonlari')->insert([
            ['ad' => 'Hoşgeldin', 'mesaj' => 'Sayın {AD} {SOYAD}, hizmetimize hoşgeldiniz. Abone No: {ABONE_NO}', 'created_at' => now(), 'updated_at' => now()],
            ['ad' => 'Fatura Hatırlatma', 'mesaj' => 'Sayın {AD} {SOYAD}, {TUTAR} TL faturanızın son ödeme tarihi yaklaşmaktadır.', 'created_at' => now(), 'updated_at' => now()],
            ['ad' => 'Borç Bildirimi', 'mesaj' => 'Sayın {AD} {SOYAD}, {BAKIYE} TL bakiyeniz bulunmaktadır.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ===================== GENEL AYARLAR =====================
        $ayarlar = [
            ['anahtar' => 'firma_adi', 'deger' => 'Hiper Log'],
            ['anahtar' => 'firma_adres', 'deger' => 'Ankara, Türkiye'],
            ['anahtar' => 'firma_telefon', 'deger' => '0312 XXX XX XX'],
            ['anahtar' => 'firma_email', 'deger' => 'info@hiperlog.com'],
            ['anahtar' => 'firma_vergi_dairesi', 'deger' => 'Çankaya VD'],
            ['anahtar' => 'firma_vergi_no', 'deger' => '1234567890'],
            ['anahtar' => 'fatura_prefix', 'deger' => 'INV'],
            ['anahtar' => 'fatura_sonraki_no', 'deger' => '10001'],
            ['anahtar' => 'kdv_orani', 'deger' => '20'],
            ['anahtar' => 'son_odeme_gun', 'deger' => '15'],
        ];

        foreach ($ayarlar as $ayar) {
            DB::table('ayarlar')->insert([
                'anahtar' => $ayar['anahtar'],
                'deger' => $ayar['deger'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ===================== MÜŞTERİLER (Örnek) =====================
        $musteriAdlari = [
            ['ad' => 'Ahmet', 'soyad' => 'Yılmaz', 'tc' => '11111111111'],
            ['ad' => 'Mehmet', 'soyad' => 'Kara', 'tc' => '22222222222'],
            ['ad' => 'Ayşe', 'soyad' => 'Demir', 'tc' => '33333333333'],
            ['ad' => 'Fatma', 'soyad' => 'Çelik', 'tc' => '44444444444'],
            ['ad' => 'Hüseyin', 'soyad' => 'Şahin', 'tc' => '55555555555'],
            ['ad' => 'Ali', 'soyad' => 'Öztürk', 'tc' => '66666666666'],
            ['ad' => 'Zeynep', 'soyad' => 'Arslan', 'tc' => '77777777777'],
            ['ad' => 'Mustafa', 'soyad' => 'Doğan', 'tc' => '88888888888'],
            ['ad' => 'Elif', 'soyad' => 'Kılıç', 'tc' => '99999999999'],
            ['ad' => 'Emre', 'soyad' => 'Aydın', 'tc' => '10101010101'],
            ['ad' => 'Selin', 'soyad' => 'Koç', 'tc' => '12121212121'],
            ['ad' => 'Burak', 'soyad' => 'Erdoğan', 'tc' => '13131313131'],
            ['ad' => 'Cemile', 'soyad' => 'Güneş', 'tc' => '14141414141'],
            ['ad' => 'Deniz', 'soyad' => 'Kurt', 'tc' => '15151515151'],
            ['ad' => 'Gökhan', 'soyad' => 'Yıldız', 'tc' => '16161616161'],
        ];

        $durumlar = ['aktif', 'aktif', 'aktif', 'aktif', 'aktif', 'aktif', 'aktif', 'aktif', 'pasif', 'pasif', 'iptal', 'dondurulmus', 'aktif', 'aktif', 'aktif'];

        $musteriIds = [];
        foreach ($musteriAdlari as $idx => $m) {
            $hatId = $hatlar[array_rand($hatlar)];
            $musteriIds[] = DB::table('musteriler')->insertGetId([
                'abone_no' => 'AB' . str_pad($idx + 1, 6, '0', STR_PAD_LEFT),
                'ad' => $m['ad'],
                'soyad' => $m['soyad'],
                'tc_kimlik' => $m['tc'],
                'musteri_tipi' => 'bireysel',
                'cinsiyet' => $idx % 2 == 0 ? 'erkek' : 'kadin',
                'telefon' => '0555' . rand(1000000, 9999999),
                'email' => strtolower($m['ad']) . '@gmail.com',
                'il' => 'Ankara',
                'ilce' => 'Çankaya',
                'mahalle' => 'Bahçelievler Mah.',
                'adres' => 'Cadde No:' . rand(1, 100) . ' Daire:' . rand(1, 20),
                'tarife_id' => $tarifeler[array_rand($tarifeler)],
                'bayi_id' => rand(0, 1) ? $adminId : $bayiId,
                'bolge_id' => $bolgeler[array_rand($bolgeler)],
                'mikrotik_id' => $mikrotikler[array_rand($mikrotikler)],
                'hat_id' => $hatId,
                'ip_adresi' => '10.0.' . rand(1, 254) . '.' . rand(1, 254),
                'mac_adresi' => implode(':', array_map(fn() => sprintf('%02X', rand(0, 255)), range(1, 6))),
                'pppoe_kullanici' => strtolower($m['ad']) . $idx,
                'pppoe_sifre' => 'pass' . rand(1000, 9999),
                'durum' => $durumlar[$idx],
                'kayit_tarihi' => now()->subDays(rand(30, 365)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ===================== FATURALAR =====================
        foreach ($musteriIds as $idx => $musteriId) {
            for ($ay = 0; $ay < 3; $ay++) {
                $tutar = rand(150, 500);
                $odenen = ($idx % 3 == 0) ? $tutar : (($idx % 3 == 1) ? 0 : rand(50, $tutar));
                $durum = $odenen >= $tutar ? 'odendi' : ($odenen > 0 ? 'kismi' : 'odenmedi');

                DB::table('faturalar')->insert([
                    'musteri_id' => $musteriId,
                    'fatura_no' => 'INV' . str_pad(($idx * 3 + $ay + 1), 6, '0', STR_PAD_LEFT),
                    'tutar' => $tutar,
                    'kdv_tutar' => round($tutar * 0.20, 2),
                    'toplam_tutar' => round($tutar * 1.20, 2),
                    'odenen_tutar' => $odenen,
                    'durum' => $durum,
                    'fatura_tarihi' => now()->subMonths($ay)->startOfMonth(),
                    'son_odeme_tarihi' => now()->subMonths($ay)->startOfMonth()->addDays(15),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ===================== İŞ EMİRLERİ =====================
        $isEmirDurumlari = ['acik', 'tamamlandi', 'beklemede', 'ertelendi', 'iptal'];
        foreach (range(1, 10) as $i) {
            DB::table('is_emirleri')->insert([
                'musteri_id' => $musteriIds[array_rand($musteriIds)],
                'is_tanimi_id' => $isTanimlari[array_rand($isTanimlari)],
                'personel_id' => $personeller[array_rand($personeller)],
                'atayan_id' => $adminId,
                'aciklama' => 'Örnek iş emri açıklaması #' . $i,
                'oncelik' => ['dusuk', 'normal', 'yuksek', 'acil'][rand(0, 3)],
                'durum' => $isEmirDurumlari[array_rand($isEmirDurumlari)],
                'planlanan_tarih' => now()->addDays(rand(-10, 30)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ===================== KASA HAREKETLERİ =====================
        foreach (range(1, 10) as $i) {
            DB::table('kasa_hareketleri')->insert([
                'kasa_id' => $kasaId,
                'islem_tipi' => $i % 2 == 0 ? 'giris' : 'cikis',
                'tutar' => rand(100, 5000),
                'aciklama' => 'Örnek kasa hareketi #' . $i,
                'islem_yapan_id' => $adminId,
                'created_at' => now()->subDays(rand(0, 30)),
                'updated_at' => now(),
            ]);
        }

        // ===================== PANEL LOGLARI =====================
        $logIslemleri = ['Giriş yapıldı', 'Müşteri eklendi', 'Fatura kesildi', 'Ödeme alındı', 'Tarife güncellendi'];
        foreach (range(1, 20) as $i) {
            DB::table('panel_loglari')->insert([
                'user_id' => rand(0, 1) ? $adminId : $bayiId,
                'islem' => $logIslemleri[array_rand($logIslemleri)],
                'detay' => 'Log detayı #' . $i,
                'ip_adresi' => '192.168.1.' . rand(1, 254),
                'modul' => ['musteri', 'fatura', 'mikrotik', 'tarife', 'sistem'][rand(0, 4)],
                'created_at' => now()->subHours(rand(0, 720)),
                'updated_at' => now(),
            ]);
        }
    }
}
