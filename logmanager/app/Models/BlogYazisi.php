<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogYazisi extends Model
{
    use HasFactory;

    protected $table = 'blog_yazilari';

    protected $fillable = [
        'user_id',
        'baslik',
        'slug',
        'icerik',
        'kapak_resmi',
        'yayinda',
    ];

    protected $casts = [
        'yayinda' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
