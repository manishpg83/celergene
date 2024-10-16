<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCatagory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_catagories';

    protected $fillable = [
        'category_name',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
