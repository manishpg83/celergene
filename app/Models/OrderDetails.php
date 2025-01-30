<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'order_id',     
        'product_id',
        'manual_product_name',
        'unit_price',
        'remaining_quantity',
        'invoice_rem',
        'invoice_rem_sample',
        'sample_quantity',
        'sample_quantity_remaining',
        'quantity',
        'discount',
        'total'
    ];

    public function order()
    {
        return $this->belongsTo(OrderMaster::class, 'order_id', 'id');
    }

    public function orderMaster()
    {
        return $this->belongsTo(OrderMaster::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
