<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evrak extends Model
{
    use HasFactory;

    protected $table = 'evraklar';

    protected $fillable = [
        'musteri_id',
        'ad',
        'tip',
        'dosya_yolu',
        'yukleyen_user_id',
    ];

    public function musteri()
    {
        return $this->belongsTo(Musteri::class, 'musteri_id');
    }

    public function yukleyenUser()
    {
        return $this->belongsTo(User::class, 'yukleyen_user_id');
    }
}
