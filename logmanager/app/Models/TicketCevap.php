<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCevap extends Model
{
    use HasFactory;

    protected $table = 'ticket_cevaplari';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'mesaj',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
