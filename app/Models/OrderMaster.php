<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    protected $table = 'order_master';

    protected $primaryKey = 'invoice_id';

    protected $fillable = [
        'invoice_date',
        'customer_id',
        'entity_id',
        'shipping_address',
        'subtotal',
        'discount',
        'tax',
        'total',
        'remarks',
        'payment_mode',
        'invoice_status',
        'payment_terms',
        'delivery_status',
        'created_by',
        'modified_by'
    ];


    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'invoice_date' => 'datetime',
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'invoice_id', 'invoice_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}
