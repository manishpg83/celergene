<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventory';

    protected $fillable = [
        'product_code',
        'warehouse_id',
        'batch_number',
        'expiry',
        'quantity',
        'consumed',
        'remaining',
        'created_by',
        'modified_by',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_code');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    // In Inventory Model
    public function modifiedBy()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

}
