<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table = 'order_details';

    protected $fillable = ['invoice_id', 'product_id', 'unit_price', 'quantity', 'discount', 'total'];

    public function orderMaster()
    {
        return $this->belongsTo(OrderMaster::class, 'invoice_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

