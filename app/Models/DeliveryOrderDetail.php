<?php

namespace App\Models;

use App\Models\Product;
use App\Models\DeliveryOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryOrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_order_id',
        'product_id',
        'quantity'
    ];

    public function deliveryOrder(): BelongsTo
    {
        return $this->belongsTo(DeliveryOrder::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
