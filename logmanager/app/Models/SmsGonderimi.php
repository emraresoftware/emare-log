<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsGonderimi extends Model
{
    use HasFactory;

    protected $table = 'sms_gonderimleri';

    protected $fillable = [
        'user_id',
        'musteri_id',
        'telefon',
        'mesaj',
        'durum',
        'hata_mesaji',
        'mesaj_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }
}
