<?php

namespace App\Models;

use App\Enums\OrderWorkflowType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Support\Facades\DB;

class OrderMaster extends Model
{
    protected $table = 'order_master';
    protected $primaryKey = 'invoice_id';
    public $incrementing = true;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'customer_id',
        'entity_id',
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
        'payment_mode',
        'payment_terms',
        'remarks',
        'delivery_status',
        'invoice_status',
        'invoice_type',
        'created_by',
        'modified_by'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'invoice_date' => 'datetime',
        'workflow_type' => OrderWorkflowType::class,
        'is_initial_consignment' => 'boolean',
        'total_order_quantity' => 'decimal:2',
        'remaining_quantity' => 'decimal:2',
        'invoice_type' => 'string',
    ];

    // Relationships
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

    public function parentOrder()
    {
        return $this->belongsTo(self::class, 'parent_order_id', 'invoice_id');
    }

    public function childOrders()
    {
        return $this->hasMany(self::class, 'parent_order_id', 'invoice_id');
    }

    // Workflow Type Methods
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

    // Scopes
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

    // Workflow Validation
    public function validateWorkflow()
    {
        switch ($this->workflow_type) {
            case OrderWorkflowType::STANDARD:
                // Standard order validation
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

    // Invoice Number Generation
    public static function generateInvoiceNumber($workflowType = null, $parentOrderId = null)
    {
        $currentDate = now();
        $financialYear = $currentDate->month >= 4 
            ? $currentDate->year 
            : $currentDate->year - 1;
        
        $query = self::where('invoice_number', 'like', $financialYear . '%');
        
        // Consignment sub-invoice logic
        if ($workflowType === OrderWorkflowType::CONSIGNMENT && $parentOrderId) {
            $parentOrder = self::find($parentOrderId);
            if ($parentOrder) {
                $subInvoiceCount = self::where('parent_order_id', $parentOrderId)->count() + 1;
                return $parentOrder->invoice_number . '-' . str_pad($subInvoiceCount, 2, '0', STR_PAD_LEFT);
            }
        }

        $lastOrder = $query->orderBy('invoice_number', 'desc')->first();

        if (!$lastOrder) {          
            return $financialYear . '0001';
        }

        $lastNumber = intval(substr($lastOrder->invoice_number, -4));
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        
        return $financialYear . $newNumber;
    }

    // Quantity Management for Multi-Delivery
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

    // Check if more deliveries can be created
    public function canCreateMoreDeliveries(): bool
    {
        return $this->workflow_type === OrderWorkflowType::MULTI_DELIVERY 
            && $this->remaining_quantity > 0;
    }
}