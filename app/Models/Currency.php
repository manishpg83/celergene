<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'currency';

    protected $fillable = [
        'name',
        'code',
        'symbol',
        'rate',
        'status'
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE
    ];
}
