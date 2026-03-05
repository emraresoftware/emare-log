<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basvuru extends Model
{
    use HasFactory;

    protected $table = 'basvurular';

    protected $fillable = [
        'musteri_id',
        'bayi_id',
        'tarife_id',
        'tip',
        'durum',
        'isim',
        'soyisim',
        'tc_no',
        'telefon',
        'email',
        'adres',
        'il',
        'ilce',
        'mahalle',
        'cadde_sokak',
        'not',
    ];

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }

    public function bayi()
    {
        return $this->belongsTo(User::class, 'bayi_id');
    }

    public function tarife()
    {
        return $this->belongsTo(Tarife::class, 'tarife_id');
    }
}
