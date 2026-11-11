<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateClick extends Model
{
    protected $table = 'affiliate_clicks';

    protected $fillable = ['affiliate_link_id', 'ip_address', 'user_agent', 'referrer'];

    public function link()
    {
        return $this->belongsTo(AffiliateLink::class, 'affiliate_link_id');
    }
}


