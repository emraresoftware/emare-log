<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusteriNotu extends Model
{
    use HasFactory;

    protected $table = 'musteri_notlari';

    protected $fillable = [
        'musteri_id',
        'user_id',
        'not',
        'tip',
    ];

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
