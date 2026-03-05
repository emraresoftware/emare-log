<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VpnKullanici extends Model
{
    use HasFactory;

    protected $table = 'vpn_kullanicilari';

    protected $fillable = [
        'mikrotik_id',
        'kullanici_adi',
        'sifre',
        'profil',
        'remote_address',
        'local_address',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    protected $hidden = [
        'sifre',
    ];

    public function mikrotik()
    {
        return $this->belongsTo(Mikrotik::class, 'mikrotik_id');
    }
}
