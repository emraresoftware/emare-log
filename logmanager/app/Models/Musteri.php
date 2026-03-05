<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Musteri extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'musteriler';

    protected $fillable = [
        'abone_no',
        'xdsl_no',
        'kullanici_adi',
        'kullanici_sifre',
        'kimlik_tipi',
        'tc_no',
        'isim',
        'soyisim',
        'dogum_tarihi',
        'dogum_yeri',
        'kimlik_verildigi_tarih',
        'kimlik_verildigi_yer',
        'kimlik_seri_no',
        'anne_adi',
        'baba_adi',
        'kimlik_cilt_no',
        'kimlik_kutuk_no',
        'kimlik_sayfa_no',
        'kimlik_il',
        'telefon',
        'cep_telefon',
        'email',
        'il',
        'ilce',
        'mahalle',
        'cadde_sokak',
        'bina_no',
        'daire_no',
        'posta_kodu',
        'adres',
        'tarife_id',
        'bayi_id',
        'bolge_id',
        'tip',
        'durum',
        'hizmet_turu',
        'uyelik_tarihi',
        'bitis_tarihi',
        'taahhut_bitis_tarihi',
        'taahhutlu',
        'admin_onayli',
        'static_ip',
        'mac_adresi',
        'clid',
        'modem_marka',
        'modem_model',
        'modem_seri_no',
        'bakiye',
        'borc',
        'borctan_kapali',
        'kimlik_onayli',
        'sozlesme_onayli',
        'not',
    ];

    protected $casts = [
        'dogum_tarihi' => 'date',
        'kimlik_verildigi_tarih' => 'date',
        'uyelik_tarihi' => 'date',
        'bitis_tarihi' => 'date',
        'taahhut_bitis_tarihi' => 'date',
        'taahhutlu' => 'boolean',
        'admin_onayli' => 'boolean',
        'borctan_kapali' => 'boolean',
        'kimlik_onayli' => 'boolean',
        'sozlesme_onayli' => 'boolean',
        'bakiye' => 'decimal:2',
        'borc' => 'decimal:2',
    ];

    public function tarife()
    {
        return $this->belongsTo(Tarife::class, 'tarife_id');
    }

    public function bayi()
    {
        return $this->belongsTo(User::class, 'bayi_id');
    }

    public function bolge()
    {
        return $this->belongsTo(Bolge::class, 'bolge_id');
    }

    public function gruplari()
    {
        return $this->belongsToMany(MusteriGrubu::class, 'musteri_grup_pivot', 'musteri_id', 'grup_id');
    }

    public function notlari()
    {
        return $this->hasMany(MusteriNotu::class, 'musteri_id');
    }

    public function faturalar()
    {
        return $this->hasMany(Fatura::class, 'musteri_id');
    }

    public function odemeler()
    {
        return $this->hasMany(Odeme::class, 'musteri_id');
    }

    public function basvurular()
    {
        return $this->hasMany(Basvuru::class, 'musteri_id');
    }

    public function ipAdresleri()
    {
        return $this->hasMany(IpAdresi::class, 'musteri_id');
    }

    public function teknikServisler()
    {
        return $this->hasMany(TeknikServis::class, 'musteri_id');
    }

    public function isEmirleri()
    {
        return $this->hasMany(IsEmri::class, 'musteri_id');
    }

    public function havaleBildirimleri()
    {
        return $this->hasMany(HavaleBildirimi::class, 'musteri_id');
    }

    public function otomatikCekimler()
    {
        return $this->hasMany(OtomatikCekim::class, 'musteri_id');
    }

    public function kasaHareketleri()
    {
        return $this->hasMany(KasaHareketi::class, 'musteri_id');
    }

    public function urunler()
    {
        return $this->hasMany(Urun::class, 'musteri_id');
    }

    public function smsGonderimleri()
    {
        return $this->hasMany(SmsGonderimi::class, 'musteri_id');
    }

    public function aramaEmirleri()
    {
        return $this->hasMany(AramaEmri::class, 'musteri_id');
    }

    public function evraklar()
    {
        return $this->hasMany(Evrak::class, 'musteri_id');
    }

    public function telekomBasvurulari()
    {
        return $this->hasMany(TelekomBasvuru::class, 'musteri_id');
    }

    public function aboneLoglari()
    {
        return $this->hasMany(AboneLogu::class, 'musteri_id');
    }

    public function oturumLoglari()
    {
        return $this->hasMany(OturumLogu::class, 'musteri_id');
    }
}
