<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'order_number',
        'customer_id',
        'name',
        'phone',
        'email',
        'subtotal',
        'discount',
        'shipping_cost',
        'extra_charge',
        'tax',
        'total',
        'status',
        'payment_status',
        'coupon_id',
        'shipping_address_id',
        'shipping_zone_id',
        'affiliate_id',
        'notes',
        'source',
        'created_by',
    ];

    protected $casts = [
        'subtotal'      => 'decimal:2',
        'discount'      => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'extra_charge'  => 'decimal:2',
        'tax'           => 'decimal:2',
        'total'         => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address_id');
    }

    public function shippingZone()
    {
        return $this->belongsTo(ShippingZone::class, 'shipping_zone_id');
    }

    public function dropshippingOrders()
    {
        return $this->hasMany(DropshippingOrder::class, 'order_id');
    }

    public function resellerOrders()
    {
        return $this->hasMany(ResellerOrder::class, 'order_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function vendorOrders()
    {
        return $this->hasMany(VendorOrder::class, 'order_id');
    }

    public function supplierOrders()
    {
        return $this->hasMany(SupplierOrder::class, 'order_id');
    }

    public function orderNotes()
    {
        return $this->hasMany(OrderNote::class, 'order_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'order_id');
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class, 'order_id');
    }

    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class, 'order_id');
    }

    public function affiliateSales()
    {
        return $this->hasMany(AffiliateSale::class, 'order_id');
    }

    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class, 'order_id');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'order_id');
    }

    public function disputes()
    {
        return $this->hasMany(Dispute::class, 'order_id');
    }

    public function fraudReports()
    {
        return $this->hasMany(FraudReport::class, 'order_id');
    }
}