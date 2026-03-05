<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'kullanici_adi',
        'ad',
        'soyad',
        'email',
        'telefon',
        'password',
        'bolge_id',
        'rol',
        'aktif',
        'yetkiler',
        'profil_foto',
        'son_giris',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'son_giris' => 'datetime',
            'aktif' => 'boolean',
            'yetkiler' => 'array',
        ];
    }

    // ==================== İlişkiler ====================

    public function bolge()
    {
        return $this->belongsTo(Bolge::class, 'bolge_id');
    }

    public function musteriler()
    {
        return $this->hasMany(Musteri::class, 'bayi_id');
    }

    public function tarifeler()
    {
        return $this->hasMany(Tarife::class, 'bayi_id');
    }

    public function basvurular()
    {
        return $this->hasMany(Basvuru::class, 'bayi_id');
    }

    public function faturalar()
    {
        return $this->hasMany(Fatura::class, 'bayi_id');
    }

    public function odemeler()
    {
        return $this->hasMany(Odeme::class, 'user_id');
    }

    public function musteriNotlari()
    {
        return $this->hasMany(MusteriNotu::class, 'user_id');
    }

    public function kasaHareketleri()
    {
        return $this->hasMany(KasaHareketi::class, 'user_id');
    }

    public function gelirGiderler()
    {
        return $this->hasMany(GelirGider::class, 'user_id');
    }

    public function atananTeknikServisler()
    {
        return $this->hasMany(TeknikServis::class, 'atanan_user_id');
    }

    public function olusturduguTeknikServisler()
    {
        return $this->hasMany(TeknikServis::class, 'olusturan_user_id');
    }

    public function atananIsEmirleri()
    {
        return $this->hasMany(IsEmri::class, 'atanan_user_id');
    }

    public function personel()
    {
        return $this->hasOne(Personel::class, 'user_id');
    }

    public function araclar()
    {
        return $this->hasMany(Arac::class, 'sorumlu_user_id');
    }

    public function smsGonderimleri()
    {
        return $this->hasMany(SmsGonderimi::class, 'user_id');
    }

    public function genelArizalar()
    {
        return $this->hasMany(GenelAriza::class, 'olusturan_user_id');
    }

    public function aramaEmirleri()
    {
        return $this->hasMany(AramaEmri::class, 'user_id');
    }

    public function ticketlar()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function atananTicketlar()
    {
        return $this->hasMany(Ticket::class, 'atanan_user_id');
    }

    public function ticketCevaplari()
    {
        return $this->hasMany(TicketCevap::class, 'user_id');
    }

    public function duyurular()
    {
        return $this->hasMany(Duyuru::class, 'user_id');
    }

    public function evraklar()
    {
        return $this->hasMany(Evrak::class, 'yukleyen_user_id');
    }

    public function panelLoglari()
    {
        return $this->hasMany(PanelLogu::class, 'user_id');
    }

    public function yasaklananTcler()
    {
        return $this->hasMany(YasaklananTc::class, 'user_id');
    }

    public function blogYazilari()
    {
        return $this->hasMany(BlogYazisi::class, 'user_id');
    }
}
