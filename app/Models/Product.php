<?php

namespace App\Models;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_code',
        'brand',
        'product_name',
        'product_category',
        'origin',
        'batch_number',
        'expire_date',
        'currency',
        'unit_price',
        'remarks_notes',
        'description',
        'created_by',
        'modified_by',
    ];

    public function inventories()
{
    return $this->hasMany(Inventory::class, 'product_code');
}

}
