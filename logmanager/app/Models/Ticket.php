<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticketlar';

    protected $fillable = [
        'user_id',
        'atanan_user_id',
        'baslik',
        'aciklama',
        'oncelik',
        'durum',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function atananUser()
    {
        return $this->belongsTo(User::class, 'atanan_user_id');
    }

    public function cevaplar()
    {
        return $this->hasMany(TicketCevap::class, 'ticket_id');
    }
}
