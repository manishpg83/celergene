<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_name',
        'country',
        'remarks',
        'created_by',
        'created_date',
        'modified_date',
    ];

    protected $dates = [
        'created_date',
        'modified_date',
        'deleted_at',
    ];
}
