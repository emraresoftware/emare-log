<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ===================== BÖLGELER =====================
        Schema::create('bolgeler', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('aciklama')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== KULLANICILAR (Bayiler) =====================
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('kullanici_adi')->unique();
            $table->string('ad');
            $table->string('soyad');
            $table->string('email')->unique()->nullable();
            $table->string('telefon')->nullable();
            $table->string('password');
            $table->foreignId('bolge_id')->nullable()->constrained('bolgeler')->nullOnDelete();
            $table->enum('rol', ['admin', 'bayi', 'tekniker', 'muhasebe', 'operasyon'])->default('bayi');
            $table->boolean('aktif')->default(true);
            $table->text('yetkiler')->nullable(); // JSON
            $table->string('profil_foto')->nullable();
            $table->timestamp('son_giris')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // ===================== TARİFELER =====================
        Schema::create('tarifeler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bayi_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ad');
            $table->enum('tip', ['bireysel', 'kurumsal', 'fiber', 'vdsl', 'adsl', 'diger'])->default('bireysel');
            $table->string('hiz')->nullable(); // Örn: "50Mbps/5Mbps"
            $table->integer('download_hiz')->default(0); // Kbps
            $table->integer('upload_hiz')->default(0); // Kbps
            $table->decimal('fiyat', 10, 2)->default(0);
            $table->decimal('kdv_dahil_fiyat', 10, 2)->default(0);
            $table->integer('kdv_orani')->default(20);
            $table->integer('sure_gun')->default(30);
            $table->integer('taahhut_suresi')->default(0); // Ay
            $table->decimal('taahhut_cezasi', 10, 2)->default(0);
            $table->boolean('aktif')->default(true);
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });

        // ===================== HİZMETLER =====================
        Schema::create('hizmetler', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('kod')->nullable();
            $table->decimal('fiyat', 10, 2)->default(0);
            $table->text('aciklama')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== KAMPANYALAR =====================
        Schema::create('kampanyalar', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->text('aciklama')->nullable();
            $table->decimal('indirim_orani', 5, 2)->default(0);
            $table->decimal('indirim_tutar', 10, 2)->default(0);
            $table->date('baslangic_tarihi')->nullable();
            $table->date('bitis_tarihi')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== MÜŞTERİLER =====================
        Schema::create('musteriler', function (Blueprint $table) {
            $table->id();
            $table->string('abone_no')->unique();
            $table->string('xdsl_no')->nullable();
            $table->string('pppoe_kullanici')->nullable();
            $table->string('pppoe_sifre')->nullable();

            // Kimlik bilgileri
            $table->enum('kimlik_tipi', ['tc', 'pasaport', 'yabanci_kimlik', 'vergi_no'])->default('tc');
            $table->string('tc_kimlik', 20)->nullable();
            $table->string('ad');
            $table->string('soyad');
            $table->enum('cinsiyet', ['erkek', 'kadin'])->nullable();
            $table->date('dogum_tarihi')->nullable();
            $table->string('dogum_yeri')->nullable();
            $table->date('kimlik_verildigi_tarih')->nullable();
            $table->string('kimlik_verildigi_yer')->nullable();
            $table->string('kimlik_seri_no')->nullable();
            $table->string('anne_adi')->nullable();
            $table->string('baba_adi')->nullable();
            $table->string('kimlik_cilt_no')->nullable();
            $table->string('kimlik_kutuk_no')->nullable();
            $table->string('kimlik_sayfa_no')->nullable();
            $table->string('kimlik_il')->nullable();

            // İletişim
            $table->string('telefon')->nullable();
            $table->string('cep_telefon')->nullable();
            $table->string('email')->nullable();

            // Adres bilgileri
            $table->string('il')->nullable();
            $table->string('ilce')->nullable();
            $table->string('mahalle')->nullable();
            $table->string('cadde_sokak')->nullable();
            $table->string('bina_no')->nullable();
            $table->string('daire_no')->nullable();
            $table->string('posta_kodu')->nullable();
            $table->text('adres')->nullable();

            // Abonelik bilgileri
            $table->foreignId('tarife_id')->nullable()->constrained('tarifeler')->nullOnDelete();
            $table->foreignId('bayi_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('bolge_id')->nullable()->constrained('bolgeler')->nullOnDelete();
            $table->unsignedBigInteger('mikrotik_id')->nullable();
            $table->unsignedBigInteger('hat_id')->nullable();
            $table->enum('musteri_tipi', ['bireysel', 'kurumsal'])->default('bireysel');
            $table->enum('durum', ['aktif', 'pasif', 'potansiyel', 'iptal', 'dondurulmus', 'hukuki', 'sureden_pasif'])->default('potansiyel');
            $table->enum('hizmet_turu', ['fiber', 'vdsl', 'adsl', 'wireless', 'diger'])->default('fiber');
            $table->date('kayit_tarihi')->nullable();
            $table->date('bitis_tarihi')->nullable();
            $table->date('taahhut_bitis_tarihi')->nullable();
            $table->boolean('taahhutlu')->default(false);
            $table->boolean('admin_onayli')->default(false);

            // Teknik
            $table->string('ip_adresi')->nullable();
            $table->string('mac_adresi')->nullable();
            $table->string('clid')->nullable();
            $table->string('modem_marka')->nullable();
            $table->string('modem_model')->nullable();
            $table->string('modem_seri_no')->nullable();

            // Finansal
            $table->decimal('bakiye', 12, 2)->default(0);
            $table->decimal('borc', 12, 2)->default(0);
            $table->boolean('borctan_kapali')->default(false);

            // Evrak
            $table->boolean('kimlik_onayli')->default(false);
            $table->boolean('sozlesme_onayli')->default(false);

            // Notlar
            $table->text('not')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // ===================== MÜŞTERİ GRUPLARI =====================
        Schema::create('musteri_gruplari', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('renk')->nullable();
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });

        Schema::create('musteri_grup_pivot', function (Blueprint $table) {
            $table->foreignId('musteri_id')->constrained('musteriler')->cascadeOnDelete();
            $table->foreignId('grup_id')->constrained('musteri_gruplari')->cascadeOnDelete();
            $table->primary(['musteri_id', 'grup_id']);
        });

        // ===================== MÜŞTERİ NOTLARI =====================
        Schema::create('musteri_notlari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musteri_id')->constrained('musteriler')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('not');
            $table->enum('tip', ['genel', 'teknik', 'finansal', 'onemli'])->default('genel');
            $table->timestamps();
        });

        // ===================== BAŞVURULAR =====================
        Schema::create('basvurular', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musteri_id')->nullable()->constrained('musteriler')->nullOnDelete();
            $table->foreignId('bayi_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('tarife_id')->nullable()->constrained('tarifeler')->nullOnDelete();
            $table->enum('tip', ['yeni', 'tarife_gecis', 'churn', 'on_basvuru', 'online', 'vae', 'e_devlet'])->default('yeni');
            $table->enum('durum', ['bekliyor', 'onaylandi', 'reddedildi', 'iptal', 'tamamlandi'])->default('bekliyor');

            $table->string('isim')->nullable();
            $table->string('soyisim')->nullable();
            $table->string('tc_no')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
            $table->text('adres')->nullable();
            $table->string('il')->nullable();
            $table->string('ilce')->nullable();
            $table->string('mahalle')->nullable();
            $table->string('cadde_sokak')->nullable();
            $table->text('not')->nullable();

            $table->timestamps();
        });

        // ===================== MİKROTİKLER =====================
        Schema::create('mikrotikler', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('ip_adresi');
            $table->integer('api_port')->default(8728);
            $table->string('kullanici_adi');
            $table->string('sifre');
            $table->foreignId('bolge_id')->nullable()->constrained('bolgeler')->nullOnDelete();
            $table->enum('durum', ['aktif', 'pasif', 'hata'])->default('aktif');
            $table->boolean('aktif')->default(true);
            $table->string('mesaj')->nullable();
            $table->boolean('accept')->default(false);
            $table->boolean('radius')->default(false);
            $table->boolean('accounting')->default(false);
            $table->integer('interim')->default(0);
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });

        // ===================== HATLAR =====================
        Schema::create('hatlar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mikrotik_id')->constrained('mikrotikler')->cascadeOnDelete();
            $table->string('ad');
            $table->string('hat_tipi')->nullable();
            $table->integer('kapasite')->default(0);
            $table->integer('kullanilan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== IP ADRESLERİ =====================
        Schema::create('ip_adresleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mikrotik_id')->constrained('mikrotikler')->cascadeOnDelete();
            $table->foreignId('musteri_id')->nullable()->constrained('musteriler')->nullOnDelete();
            $table->string('ip_adresi');
            $table->string('subnet')->nullable();
            $table->enum('durum', ['bos', 'kullaniliyor', 'rezerve'])->default('bos');
            $table->boolean('statik')->default(false);
            $table->timestamps();
        });

        // ===================== VPN =====================
        Schema::create('vpn_kullanicilari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mikrotik_id')->constrained('mikrotikler')->cascadeOnDelete();
            $table->string('kullanici_adi');
            $table->string('sifre');
            $table->string('profil')->nullable();
            $table->string('remote_address')->nullable();
            $table->string('local_address')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== İSTASYONLAR =====================
        Schema::create('istasyonlar', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('konum')->nullable();
            $table->decimal('enlem', 10, 7)->nullable();
            $table->decimal('boylam', 10, 7)->nullable();
            $table->text('aciklama')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== VERİCİLER =====================
        Schema::create('vericiler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('istasyon_id')->constrained('istasyonlar')->cascadeOnDelete();
            $table->string('ad');
            $table->string('marka')->nullable();
            $table->string('model')->nullable();
            $table->string('ip_adresi')->nullable();
            $table->string('frekans')->nullable();
            $table->boolean('aktif')->default(true);
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });

        // ===================== FATURALAR =====================
        Schema::create('faturalar', function (Blueprint $table) {
            $table->id();
            $table->string('fatura_no')->unique();
            $table->foreignId('musteri_id')->constrained('musteriler')->cascadeOnDelete();
            $table->foreignId('bayi_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('tip', ['aylik', 'kurulum', 'taahhut_cezasi', 'ek_hizmet', 'diger'])->default('aylik');
            $table->decimal('tutar', 12, 2)->default(0);
            $table->decimal('kdv_tutar', 12, 2)->default(0);
            $table->decimal('toplam_tutar', 12, 2)->default(0);
            $table->integer('kdv_orani')->default(20);
            $table->date('fatura_tarihi');
            $table->date('son_odeme_tarihi');
            $table->date('odeme_tarihi')->nullable();
            $table->enum('durum', ['odenmedi', 'odendi', 'iptal', 'iade', 'kismi_odendi', 'kismi'])->default('odenmedi');
            $table->decimal('odenen_tutar', 12, 2)->default(0);
            $table->boolean('e_fatura')->default(false);
            $table->string('e_fatura_no')->nullable();
            $table->enum('e_fatura_durum', ['gonderilmedi', 'gonderildi', 'hata', 'onaylandi'])->nullable();
            $table->text('aciklama')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // ===================== ÖDEMELER =====================
        Schema::create('odemeler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fatura_id')->nullable()->constrained('faturalar')->nullOnDelete();
            $table->foreignId('musteri_id')->constrained('musteriler')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('tutar', 12, 2);
            $table->enum('odeme_yontemi', ['nakit', 'kredi_karti', 'havale', 'eft', 'sanal_pos', 'otomatik_cek', 'diger'])->default('nakit');
            $table->string('referans_no')->nullable();
            $table->date('odeme_tarihi');
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });

        // ===================== HAVALE BİLDİRİMLERİ =====================
        Schema::create('havale_bildirimleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musteri_id')->constrained('musteriler')->cascadeOnDelete();
            $table->decimal('tutar', 12, 2);
            $table->string('banka')->nullable();
            $table->string('referans_no')->nullable();
            $table->date('havale_tarihi');
            $table->enum('durum', ['bekliyor', 'onaylandi', 'reddedildi'])->default('bekliyor');
            $table->text('not')->nullable();
            $table->timestamps();
        });

        // ===================== OTOMATİK ÇEKİMLER =====================
        Schema::create('otomatik_cekimler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musteri_id')->constrained('musteriler')->cascadeOnDelete();
            $table->string('kart_no_son4')->nullable();
            $table->decimal('tutar', 12, 2);
            $table->date('cekim_tarihi');
            $table->enum('durum', ['basarili', 'basarisiz', 'bekliyor'])->default('bekliyor');
            $table->string('hata_mesaji')->nullable();
            $table->timestamps();
        });

        // ===================== KASALAR =====================
        Schema::create('kasalar', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('kod')->nullable();
            $table->decimal('bakiye', 12, 2)->default(0);
            $table->foreignId('sorumlu_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('aciklama')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== KASA HAREKETLERİ =====================
        Schema::create('kasa_hareketleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasa_id')->constrained('kasalar')->cascadeOnDelete();
            $table->foreignId('islem_yapan_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('musteri_id')->nullable()->constrained('musteriler')->nullOnDelete();
            $table->enum('islem_tipi', ['giris', 'cikis'])->default('giris');
            $table->decimal('tutar', 12, 2);
            $table->string('kategori')->nullable();
            $table->text('aciklama')->nullable();
            $table->date('islem_tarihi')->nullable();
            $table->timestamps();
        });

        // ===================== CARİLER =====================
        Schema::create('cariler', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('unvan')->nullable();
            $table->string('vergi_no')->nullable();
            $table->string('vergi_dairesi')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
            $table->text('adres')->nullable();
            $table->decimal('bakiye', 12, 2)->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== CARİ FATURALARI =====================
        Schema::create('cari_faturalari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cari_id')->constrained('cariler')->cascadeOnDelete();
            $table->string('fatura_no');
            $table->enum('tip', ['alis', 'satis'])->default('alis');
            $table->decimal('tutar', 12, 2);
            $table->decimal('kdv', 12, 2)->default(0);
            $table->decimal('toplam', 12, 2);
            $table->date('fatura_tarihi');
            $table->date('vade_tarihi')->nullable();
            $table->enum('durum', ['odenmedi', 'odendi', 'iptal'])->default('odenmedi');
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });

        // ===================== GELİR/GİDER =====================
        Schema::create('gelir_giderler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasa_id')->nullable()->constrained('kasalar')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('tip', ['gelir', 'gider']);
            $table->string('kategori');
            $table->decimal('tutar', 12, 2);
            $table->date('tarih');
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });

        // ===================== STOKLAR =====================
        Schema::create('stoklar', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('kod')->nullable();
            $table->string('barkod')->nullable();
            $table->string('kategori')->nullable();
            $table->integer('miktar')->default(0);
            $table->integer('minimum_miktar')->default(0);
            $table->decimal('alis_fiyati', 10, 2)->default(0);
            $table->decimal('satis_fiyati', 10, 2)->default(0);
            $table->text('aciklama')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== DEPOLAR =====================
        Schema::create('depolar', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('adres')->nullable();
            $table->foreignId('sorumlu_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('aciklama')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== ÜRÜNLER =====================
        Schema::create('urunler', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('marka')->nullable();
            $table->string('model')->nullable();
            $table->decimal('fiyat', 10, 2)->default(0);
            $table->string('kategori')->nullable();
            $table->integer('miktar')->default(0);
            $table->string('seri_no')->nullable();
            $table->string('barkod')->nullable();
            $table->boolean('aktif')->default(true);
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });

        // ===================== TEKNİK SERVİS =====================
        Schema::create('teknik_servisler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musteri_id')->nullable()->constrained('musteriler')->nullOnDelete();
            $table->foreignId('atanan_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('olusturan_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('baslik');
            $table->text('aciklama')->nullable();
            $table->enum('oncelik', ['dusuk', 'normal', 'yuksek', 'acil'])->default('normal');
            $table->enum('durum', ['acik', 'atandi', 'devam_ediyor', 'bekliyor', 'tamamlandi', 'iptal'])->default('acik');
            $table->text('cozum_notu')->nullable();
            $table->dateTime('planlanan_tarih')->nullable();
            $table->dateTime('tamamlanma_tarihi')->nullable();
            $table->timestamps();
        });

        // ===================== İŞ TANIMLARI =====================
        Schema::create('is_tanimlari', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->text('aciklama')->nullable();
            $table->integer('tahmini_sure')->nullable();
            $table->decimal('ucret', 10, 2)->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== İŞ EMİRLERİ =====================
        Schema::create('is_emirleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teknik_servis_id')->nullable()->constrained('teknik_servisler')->nullOnDelete();
            $table->foreignId('musteri_id')->nullable()->constrained('musteriler')->nullOnDelete();
            $table->foreignId('is_tanimi_id')->nullable()->constrained('is_tanimlari')->nullOnDelete();
            $table->foreignId('personel_id')->nullable()->constrained('personeller')->nullOnDelete();
            $table->foreignId('atayan_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('baslik')->nullable();
            $table->text('aciklama')->nullable();
            $table->enum('oncelik', ['dusuk', 'normal', 'yuksek', 'acil'])->default('normal');
            $table->enum('durum', ['acik', 'tamamlandi', 'bekliyor', 'beklemede', 'ertelendi', 'iptal'])->default('acik');
            $table->dateTime('planlanan_tarih')->nullable();
            $table->dateTime('tamamlanma_tarihi')->nullable();
            $table->timestamps();
        });

        // ===================== PERSONEL =====================
        Schema::create('personeller', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ad');
            $table->string('soyad');
            $table->string('tc_no')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
            $table->text('adres')->nullable();
            $table->date('ise_giris_tarihi')->nullable();
            $table->decimal('maas', 10, 2)->default(0);
            $table->string('departman')->nullable();
            $table->string('gorev')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== HAKEDİŞLER =====================
        Schema::create('hakedisler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personel_id')->constrained('personeller')->cascadeOnDelete();
            $table->string('donem'); // Örn: "2024-01"
            $table->decimal('tutar', 10, 2)->default(0);
            $table->decimal('prim', 10, 2)->default(0);
            $table->decimal('kesinti', 10, 2)->default(0);
            $table->decimal('net_tutar', 10, 2)->default(0);
            $table->text('aciklama')->nullable();
            $table->boolean('odendi')->default(false);
            $table->timestamps();
        });

        // ===================== ARAÇLAR =====================
        Schema::create('araclar', function (Blueprint $table) {
            $table->id();
            $table->string('plaka');
            $table->string('marka')->nullable();
            $table->string('model')->nullable();
            $table->integer('yil')->nullable();
            $table->string('renk')->nullable();
            $table->foreignId('sorumlu_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('muayene_tarihi')->nullable();
            $table->date('sigorta_tarihi')->nullable();
            $table->decimal('km', 10, 0)->default(0);
            $table->boolean('aktif')->default(true);
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });

        // ===================== SMS AYARLARI =====================
        Schema::create('sms_ayarlari', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // netgsm, iletimerkezi, etc.
            $table->string('kullanici_adi')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->string('sender_id')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== SMS ŞABLONLARI =====================
        Schema::create('sms_sablonlari', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->text('mesaj');
            $table->enum('tip', ['bilgilendirme', 'odeme', 'teknik', 'karaliste', 'diger'])->default('bilgilendirme');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== SMS GÖNDERİMLERİ =====================
        Schema::create('sms_gonderimleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('musteri_id')->nullable()->constrained('musteriler')->nullOnDelete();
            $table->string('telefon');
            $table->text('mesaj');
            $table->enum('durum', ['gonderildi', 'hata', 'bekliyor'])->default('bekliyor');
            $table->string('hata_mesaji')->nullable();
            $table->string('mesaj_id')->nullable();
            $table->timestamps();
        });

        // ===================== GENEL ARIZALAR =====================
        Schema::create('genel_arizalar', function (Blueprint $table) {
            $table->id();
            $table->string('baslik');
            $table->text('aciklama')->nullable();
            $table->foreignId('mikrotik_id')->nullable()->constrained('mikrotikler')->nullOnDelete();
            $table->foreignId('istasyon_id')->nullable()->constrained('istasyonlar')->nullOnDelete();
            $table->enum('durum', ['acik', 'devam_ediyor', 'cozuldu', 'iptal'])->default('acik');
            $table->integer('etkilenen_musteri_sayisi')->default(0);
            $table->dateTime('baslangic_zamani');
            $table->dateTime('bitis_zamani')->nullable();
            $table->text('cozum_notu')->nullable();
            $table->foreignId('olusturan_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // ===================== ARAMA EMİRLERİ =====================
        Schema::create('arama_emirleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musteri_id')->nullable()->constrained('musteriler')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('baslik');
            $table->text('aciklama')->nullable();
            $table->enum('durum', ['bekliyor', 'aranildi', 'ulaslamadi', 'tamamlandi'])->default('bekliyor');
            $table->text('sonuc_notu')->nullable();
            $table->timestamps();
        });

        // ===================== TİCKETLAR =====================
        Schema::create('ticketlar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('atanan_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('baslik');
            $table->text('aciklama');
            $table->enum('oncelik', ['dusuk', 'normal', 'yuksek', 'acil'])->default('normal');
            $table->enum('durum', ['acik', 'cevaplandi', 'bekliyor', 'cozuldu', 'kapandi'])->default('acik');
            $table->timestamps();
        });

        // ===================== TİCKET CEVAPLARI =====================
        Schema::create('ticket_cevaplari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('ticketlar')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('mesaj');
            $table->timestamps();
        });

        // ===================== DUYURULAR =====================
        Schema::create('duyurular', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('baslik');
            $table->text('icerik');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ===================== EVRAKLAR =====================
        Schema::create('evraklar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musteri_id')->nullable()->constrained('musteriler')->nullOnDelete();
            $table->string('ad');
            $table->string('tip');
            $table->string('dosya_yolu');
            $table->foreignId('yukleyen_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // ===================== TELEKOM BAŞVURULARI =====================
        Schema::create('telekom_basvurulari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musteri_id')->nullable()->constrained('musteriler')->nullOnDelete();
            $table->string('basvuru_no')->nullable();
            $table->enum('tip', ['yeni', 'degisiklik', 'iptal', 'ariza'])->default('yeni');
            $table->enum('durum', ['bekliyor', 'onaylandi', 'reddedildi', 'tamamlandi'])->default('bekliyor');
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });

        // ===================== LOGLAR =====================
        Schema::create('panel_loglari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('islem');
            $table->text('detay')->nullable();
            $table->string('ip_adresi')->nullable();
            $table->string('modul')->nullable();
            $table->timestamps();
        });

        Schema::create('abone_loglari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musteri_id')->nullable()->constrained('musteriler')->nullOnDelete();
            $table->string('islem');
            $table->text('detay')->nullable();
            $table->string('ip_adresi')->nullable();
            $table->timestamps();
        });

        Schema::create('mikrotik_loglari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mikrotik_id')->nullable()->constrained('mikrotikler')->nullOnDelete();
            $table->string('seviye')->nullable();
            $table->text('mesaj')->nullable();
            $table->timestamps();
        });

        Schema::create('oturum_loglari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musteri_id')->nullable()->constrained('musteriler')->nullOnDelete();
            $table->string('kullanici_adi')->nullable();
            $table->string('ip_adresi')->nullable();
            $table->string('mac_adresi')->nullable();
            $table->string('nas_ip')->nullable();
            $table->dateTime('baslangic')->nullable();
            $table->dateTime('bitis')->nullable();
            $table->bigInteger('download_bytes')->default(0);
            $table->bigInteger('upload_bytes')->default(0);
            $table->string('sonlanma_nedeni')->nullable();
            $table->timestamps();
        });

        // ===================== AYARLAR =====================
        Schema::create('ayarlar', function (Blueprint $table) {
            $table->id();
            $table->string('anahtar')->unique();
            $table->text('deger')->nullable();
            $table->string('grup')->default('genel');
            $table->string('tip')->default('text'); // text, number, boolean, json
            $table->timestamps();
        });

        // ===================== YASAKLANAN TC'LER =====================
        Schema::create('yasaklanan_tcler', function (Blueprint $table) {
            $table->id();
            $table->string('tc_no', 11);
            $table->string('neden')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // ===================== API SİSTEM =====================
        Schema::create('api_anahtarlari', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('api_key')->unique();
            $table->string('api_secret');
            $table->boolean('aktif')->default(true);
            $table->dateTime('son_kullanim')->nullable();
            $table->timestamps();
        });

        // ===================== BLOG =====================
        Schema::create('blog_yazilari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('baslik');
            $table->string('slug')->unique();
            $table->text('icerik');
            $table->string('kapak_resmi')->nullable();
            $table->boolean('yayinda')->default(false);
            $table->timestamps();
        });

        // ===================== WHATSAPP AYARLARI =====================
        Schema::create('whatsapp_ayarlari', function (Blueprint $table) {
            $table->id();
            $table->string('api_url')->nullable();
            $table->string('api_key')->nullable();
            $table->string('telefon_no')->nullable();
            $table->boolean('aktif')->default(false);
            $table->timestamps();
        });

        // ===================== OMURGA/DEVRE =====================
        Schema::create('devreler', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('devre_no')->nullable();
            $table->string('saglayici')->nullable();
            $table->string('kapasite')->nullable();
            $table->decimal('aylik_ucret', 10, 2)->default(0);
            $table->boolean('aktif')->default(true);
            $table->text('aciklama')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $tables = [
            'devreler', 'whatsapp_ayarlari', 'blog_yazilari', 'api_anahtarlari',
            'yasaklanan_tcler', 'ayarlar', 'oturum_loglari', 'mikrotik_loglari',
            'abone_loglari', 'panel_loglari', 'telekom_basvurulari', 'evraklar',
            'duyurular', 'ticket_cevaplari', 'ticketlar', 'arama_emirleri',
            'genel_arizalar', 'sms_gonderimleri', 'sms_sablonlari', 'sms_ayarlari',
            'araclar', 'hakedisler', 'personeller', 'is_emirleri', 'is_tanimlari',
            'teknik_servisler', 'urunler', 'depolar', 'stoklar', 'gelir_giderler',
            'cari_faturalari', 'cariler', 'kasa_hareketleri', 'kasalar',
            'otomatik_cekimler', 'havale_bildirimleri', 'odemeler', 'faturalar',
            'vericiler', 'istasyonlar', 'vpn_kullanicilari', 'ip_adresleri',
            'hatlar', 'mikrotikler', 'basvurular', 'musteri_notlari',
            'musteri_grup_pivot', 'musteri_gruplari', 'musteriler', 'kampanyalar',
            'hizmetler', 'tarifeler', 'users', 'bolgeler'
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
