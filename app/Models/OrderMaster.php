<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    protected $table = 'order_master';

    protected $primaryKey = 'invoice_id';

    protected $fillable = [
        'invoice_date',
        'invoice_number',
        'is_generated',
        'customer_id',
        'entity_id',
        'shipping_address',
        'subtotal',
        'discount',
        'freight',
        'tax',
        'total',
        'remarks',
        'payment_mode',
        'invoice_status',
        'payment_terms',
        'delivery_status',
        'created_by',
        'modified_by'
    ];


    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'invoice_date' => 'datetime',
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'invoice_id', 'invoice_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public static function generateInvoiceNumber()
    {
        $currentDate = now();
        $financialYear = $currentDate->month >= 4 
            ? $currentDate->year 
            : $currentDate->year - 1;
        
        $lastOrder = self::where('invoice_number', 'like', $financialYear . '%')
            ->orderBy('invoice_number', 'desc')
            ->first();

        if (!$lastOrder) {          
            return $financialYear . '0001';
        }

        // Extract the numeric part and increment
        $lastNumber = intval(substr($lastOrder->invoice_number, -4));
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        
        return $financialYear . $newNumber;
    }
}
