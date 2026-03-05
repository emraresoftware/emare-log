<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mikrotik extends Model
{
    use HasFactory;

    protected $table = 'mikrotikler';

    protected $fillable = [
        'ad',
        'ip',
        'port',
        'kullanici_adi',
        'sifre',
        'durum',
        'mesaj',
        'accept',
        'radius',
        'accounting',
        'interim',
        'aciklama',
    ];

    protected $casts = [
        'accept' => 'boolean',
        'radius' => 'boolean',
        'accounting' => 'boolean',
    ];

    protected $hidden = [
        'sifre',
    ];

    public function hatlar()
    {
        return $this->hasMany(Hat::class, 'mikrotik_id');
    }

    public function ipAdresleri()
    {
        return $this->hasMany(IpAdresi::class, 'mikrotik_id');
    }

    public function vpnKullanicilari()
    {
        return $this->hasMany(VpnKullanici::class, 'mikrotik_id');
    }

    public function genelArizalar()
    {
        return $this->hasMany(GenelAriza::class, 'mikrotik_id');
    }

    public function mikrotikLoglari()
    {
        return $this->hasMany(MikrotikLogu::class, 'mikrotik_id');
    }
}
