<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Define your fillable attributes, relationships, etc.
    protected $fillable = [
        'brand',
        'product_name',
        'product_category',
        'origin',
        'batch_number',
        'expire_date',
        'currency',
        'unit_price',
        'remarks',
        'created_by',
        'modified_by',
    ];
}
