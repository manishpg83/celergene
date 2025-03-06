<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderInvoice extends Model
{
    use SoftDeletes;

    protected $table = 'order_invoice';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'invoice_number',
        'order_id',
        'customer_id',
        'entity_id',
        'shipping_address',
        'remaining_quantity',
        'subtotal',
        'discount',
        'freight',
        'tax',
        'total',
        'remarks',
        'payment_terms',
        'status',
        'created_by',
        'modified_by',
        'invoice_type',
        'invoice_category'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'freight' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(OrderMaster::class, 'order_id', 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifiedBy()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function invoiceDetails()
    {
        return $this->hasMany(OrderInvoiceDetail::class, 'order_invoice_id');
    }
}