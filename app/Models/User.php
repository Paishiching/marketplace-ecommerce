<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'email_verified_at',
        'password',
        'password_set_at',
        'avatar',
        'status',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password_set_at'   => 'datetime',
        'password'          => 'hashed',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'user_id');
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'user_id');
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'user_id');
    }

    public function affiliates()
    {
        return $this->hasMany(Affiliate::class, 'user_id');
    }

    public function resellers()
    {
        return $this->hasMany(Reseller::class, 'user_id');
    }

    // One-to-one shortcuts (one user = one profile per role)
    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'user_id');
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'user_id');
    }

    public function affiliate()
    {
        return $this->hasOne(Affiliate::class, 'user_id');
    }

    public function reseller()
    {
        return $this->hasOne(Reseller::class, 'user_id');
    }

    public function dropshipper()
    {
        return $this->hasOne(Dropshipper::class, 'user_id');
    }

    public function wholesaler()
    {
        return $this->hasOne(Wholesaler::class, 'user_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'user_id');
    }

    public function orderNotes()
    {
        return $this->hasMany(OrderNote::class, 'created_by');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'user_id');
    }

    public function address()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class, 'user_id');
    }

    public function supportMessages()
    {
        return $this->hasMany(SupportMessage::class, 'sender_id');
    }

    public function disputes()
    {
        return $this->hasMany(Dispute::class, 'raised_by');
    }

    public function fraudReports()
    {
        return $this->hasMany(FraudReport::class, 'user_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }
}
