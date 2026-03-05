<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelekomBasvuru extends Model
{
    use HasFactory;

    protected $table = 'telekom_basvurulari';

    protected $fillable = [
        'musteri_id',
        'basvuru_no',
        'tip',
        'durum',
        'aciklama',
    ];

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }
}
