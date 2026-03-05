<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YasaklananTc extends Model
{
    use HasFactory;

    protected $table = 'yasaklanan_tcler';

    protected $fillable = [
        'tc_no',
        'neden',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
