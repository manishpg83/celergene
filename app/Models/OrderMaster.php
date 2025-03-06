<?php

namespace App\Models;

use App\Enums\OrderWorkflowType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    protected $table = 'order_master';
    protected $primaryKey = 'order_id'; 
    public $incrementing = true;

    protected $fillable = [
        'order_date', 
        'order_number',
        'customer_id',
        'entity_id',
        'currency_id',
        'shipping_address',
        'subtotal',
        'discount',
        'freight',
        'tax',
        'total',
        'workflow_type',
        'parent_order_id',
        'is_initial_consignment',
        'total_order_quantity',
        'remaining_quantity',
        'actual_freight',
        'payment_mode',
        'payment_terms',
        'remarks',
        'is_generated',
        'delivery_status',
        'order_status',
        'order_type',  
        'created_by',
        'modified_by',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'order_date' => 'datetime', 
        'workflow_type' => OrderWorkflowType::class,
        'is_initial_consignment' => 'boolean',
        'total_order_quantity' => 'decimal:2',
        'remaining_quantity' => 'decimal:2',
        'order_type' => 'string', 
    ];
    public function deliveryOrders()
    {
        return $this->hasMany(DeliveryOrder::class, 'order_id');
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'order_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function parentOrder()
    {
        return $this->belongsTo(self::class, 'parent_order_id', 'order_id');
    }

    public function childOrders()
    {
        return $this->hasMany(self::class, 'parent_order_id', 'order_id');
    }

    public function isStandardWorkflow(): bool
    {
        return $this->workflow_type === OrderWorkflowType::STANDARD;
    }

    public function isMultiDeliveryWorkflow(): bool
    {
        return $this->workflow_type === OrderWorkflowType::MULTI_DELIVERY;
    }

    public function isConsignmentWorkflow(): bool
    {
        return $this->workflow_type === OrderWorkflowType::CONSIGNMENT;
    }

    public function scopeStandardWorkflow($query)
    {
        return $query->where('workflow_type', OrderWorkflowType::STANDARD);
    }

    public function scopeMultiDeliveryWorkflow($query)
    {
        return $query->where('workflow_type', OrderWorkflowType::MULTI_DELIVERY);
    }

    public function scopeConsignmentWorkflow($query)
    {
        return $query->where('workflow_type', OrderWorkflowType::CONSIGNMENT);
    }

    public function validateWorkflow()
    {
        switch ($this->workflow_type) {
            case OrderWorkflowType::STANDARD:
                break;
            
            case OrderWorkflowType::MULTI_DELIVERY:
                if (!$this->total_order_quantity) {
                    throw new \InvalidArgumentException('Total order quantity must be set for multi-delivery workflow');
                }
                break;
            
            case OrderWorkflowType::CONSIGNMENT:
                if (!$this->is_initial_consignment && !$this->parent_order_id) {
                    throw new \InvalidArgumentException('Consignment orders must have a parent order or be marked as initial');
                }
                break;
        }
    }

    public static function generateOrderNumber($workflowType = null, $parentOrderId = null)
    {
        $currentDate = now();
        $financialYear = $currentDate->month >= 4 
            ? $currentDate->year 
            : $currentDate->year - 1;


        $query = self::where('order_number', 'like', $financialYear . '%');

        if ($workflowType === OrderWorkflowType::CONSIGNMENT && $parentOrderId) {
            $parentOrder = self::find($parentOrderId);

            if ($parentOrder) {
                $subOrderCount = self::where('parent_order_id', $parentOrderId)->count() + 1;
                $generatedOrderNumber = $parentOrder->order_number . '-' . str_pad($subOrderCount, 2, '0', STR_PAD_LEFT);
                return $generatedOrderNumber;
            }
        }

        $lastOrder = $query->orderBy('order_number', 'desc')->first();

        if (!$lastOrder) {          
            $generatedOrderNumber = $financialYear . '0001';
            return $generatedOrderNumber;
        }

        $lastNumber = intval(substr($lastOrder->order_number, -4));
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        $generatedOrderNumber = $financialYear . $newNumber;
        return $generatedOrderNumber;
    }

    public static function generateCustomerOrderNumber($workflowType = null, $parentOrderId = null)
    {
        $currentDate = now();
        $financialYear = $currentDate->month >= 4 
            ? $currentDate->year 
            : $currentDate->year - 1;


        $query = self::where('order_number', 'like', $financialYear . '%');

        if ($workflowType === OrderWorkflowType::CONSIGNMENT && $parentOrderId) {
            $parentOrder = self::find($parentOrderId);

            if ($parentOrder) {
                $subOrderCount = self::where('parent_order_id', $parentOrderId)->count() + 1;
                $generatedOrderNumber = $parentOrder->order_number . '-' . str_pad($subOrderCount, 2, '0', STR_PAD_LEFT);
                return $generatedOrderNumber;
            }
        }

        $lastOrder = $query->orderBy('order_number', 'desc')->first();

        if (!$lastOrder) {          
            $generatedOrderNumber = $financialYear . '0001';
            return $generatedOrderNumber;
        }

        $lastNumber = intval(substr($lastOrder->order_number, -4));
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        $generatedOrderNumber = 'ORD-' . $newNumber;
        return $generatedOrderNumber;
    }

    public function updateRemainingQuantity()
    {
        if ($this->workflow_type === OrderWorkflowType::MULTI_DELIVERY) {
            $deliveredQuantity = $this->orderDetails()
                ->whereHas('delivery', function ($query) {
                    $query->where('status', 'Delivered');
                })
                ->sum('quantity');

            $this->remaining_quantity = $this->total_order_quantity - $deliveredQuantity;
            $this->save();
        }
    }

    public function items()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'order_id');
    }

    public function canCreateMoreDeliveries(): bool
    {
        return $this->workflow_type === OrderWorkflowType::MULTI_DELIVERY 
            && $this->remaining_quantity > 0;
    }

    public function getStatusColorAttribute()
    {
        return match ($this->order_status) {
            'Pending' => 'warning',
            'Paid' => 'success',
            'Cancelled' => 'danger',
            default => 'secondary',
        };
    }

}
