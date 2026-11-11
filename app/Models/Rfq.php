<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    protected $fillable = ['user_id', 'product_name', 'requirements', 'attachments', 'quantity', 'unit', 'status', 'share_business_card'];
    protected $casts = ['attachments' => 'array', 'quantity' => 'integer', 'share_business_card' => 'boolean'];

    public function user() { return $this->belongsTo(User::class); }
    public function quotes() { return $this->hasMany(RfqQuote::class); }
}
