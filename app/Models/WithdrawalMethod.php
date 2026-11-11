<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalMethod extends Model
{
    use HasFactory;

    protected $table = 'withdrawal_methods';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'withdrawal_method_id');
    }
}
