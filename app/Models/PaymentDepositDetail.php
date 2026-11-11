<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDepositDetail extends Model
{
    protected $fillable = [
        'payment_id', 'order_id', 'deposit_date', 'depositor_bank', 'depositor_branch',
        'deposit_type', 'amount', 'company_account', 'bank_name', 'company_name',
        'receipt_id', 'receipt_path', 'remark',
    ];

    protected $casts = ['deposit_date' => 'date', 'amount' => 'decimal:2'];

    public function payment() { return $this->belongsTo(Payment::class); }
    public function order() { return $this->belongsTo(Order::class); }
}
