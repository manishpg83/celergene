<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'order_id',            // Updated from order_id
        'product_id',
        'manual_product_name',
        'unit_price',
        'quantity',
        'discount',
        'total'
    ];

    public function orderMaster()
    {
        return $this->belongsTo(OrderMaster::class, 'order_id'); // Updated from order_id to order_id
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
