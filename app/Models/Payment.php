<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method',
        'amount',
        'currency',
        'status',
        'transaction_id',
        'order_id',
        'payment_date',
        'payment_details',
        'bank_charge',
    ];

    public function order()
    {
        return $this->belongsTo(OrderMaster::class, 'order_id', 'order_id');
    }
}
