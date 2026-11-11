<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $table = 'support_tickets';

    protected $fillable = [
        'user_id',
        'subject',
        'status',
        'priority',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function supportMessages()
    {
        return $this->hasMany(SupportMessage::class, 'support_ticket_id');
    }
}
