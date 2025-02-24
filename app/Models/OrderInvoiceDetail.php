<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderInvoiceDetail extends Model
{
    protected $table = 'order_invoice_details';

    protected $fillable = [
        'order_invoice_id',
        'product_id',
        'unit_price',
        'quantity',
        'delivered_quantity',
        'invoiced_quantity',
        'sample_quantity',
        'discount',
        'total',
        'manual_product_name'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'quantity' => 'integer',
        'delivered_quantity' => 'integer',
        'invoiced_quantity' => 'integer',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function orderInvoice()
    {
        return $this->belongsTo(OrderInvoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getDisplayDescription()
    {
        if (!empty($this->manual_product_name)) {
            return ($this->product->product_name ?? '') . ' - ' . $this->manual_product_name;
        }
        return $this->product->invoice_description ?? '';
    }

}