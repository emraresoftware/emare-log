<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personel extends Model
{
    use HasFactory;

    protected $table = 'personeller';

    protected $fillable = [
        'user_id',
        'ad',
        'soyad',
        'tc_no',
        'telefon',
        'email',
        'adres',
        'ise_giris_tarihi',
        'maas',
        'pozisyon',
        'aktif',
    ];

    protected $casts = [
        'ise_giris_tarihi' => 'date',
        'maas' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hakedisler()
    {
        return $this->hasMany(Hakedis::class, 'personel_id');
    }
}
