<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'order_invoice_id',
        'delivery_number',
        'tracking_number',
        'tracking_url',
        'warehouse_id',
        'delivery_date',
        'status',
        'remarks',
        'created_by',
        'modified_by'
    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];

    public function orderMaster(): BelongsTo
    {
        return $this->belongsTo(OrderMaster::class, 'order_id', 'order_id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DeliveryOrderDetail::class);
    }

    public function orderInvoice()
    {
        return $this->belongsTo(OrderInvoice::class, 'order_invoice_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public static function generateDeliveryNumber(): string
    {
        return 'DO-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }
}

