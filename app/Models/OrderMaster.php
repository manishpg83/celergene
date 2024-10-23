<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    protected $table = 'order_master';
    
    protected $primaryKey = 'invoice_id';

    protected $fillable = [
        'invoice_date', 
        'customer_id', 
        'shipping_address', 
        'subtotal', 
        'discount', 
        'tax', 
        'total', 
        'remarks', 
        'payment_mode', 
        'invoice_status'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'invoice_date' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'invoice_id', 'invoice_id');
    }
}

