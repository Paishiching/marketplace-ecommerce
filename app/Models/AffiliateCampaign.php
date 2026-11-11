<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateCampaign extends Model
{
    use HasFactory;

    protected $table = 'affiliate_campaigns';

    protected $fillable = [
        'affiliate_id',
        'name',
        'starts_at',
        'ends_at',
        'status',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id');
    }
}
