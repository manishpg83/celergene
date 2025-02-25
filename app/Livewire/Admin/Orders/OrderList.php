<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Entity;
use Livewire\Component;
use App\Models\OrderMaster;
use Illuminate\Support\Str;
use App\Models\OrderInvoice;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\OrderWorkflowType;
use App\Mail\OrderStatusChanged;
use App\Models\OrderInvoiceDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderList extends Component
{
    use WithPagination;

    public $processingStatus = null;
    public $orderStatus = [];
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 25;
    public $selectedEntityId = null;
    public $entities;
    public $dateStart = null;
    public $dateEnd = null;
    public $statusFilter = '';
    public $paymentModeFilter = '';
    public $orderTypeFilter = '';
    public $workflow_type = OrderWorkflowType::STANDARD->value;

    public $perpagerecords = [
        10 => '10',
        25 => '25',
        50 => '50',
        100 => '100',
    ];

    public $viewOrder = false;
    public $selectedOrder = null;
    public $selectedOrderId = null;

    protected $listeners = ['closeModal'];

    protected $updatesQueryString = ['search', 'perPage', 'selectedEntityId', 'statusFilter', 'paymentModeFilter'];

    public function mount()
    {
        $this->entities = Entity::active()->get();
    }

    public function viewOrderDetails($order_id)
    {
        try {
            $this->selectedOrder = OrderMaster::with(['customer', 'orderDetails.product', 'entity'])
                ->where('order_id', $order_id)
                ->firstOrFail();
            $this->viewOrder = true;
        } catch (\Exception $e) {
            notyf()->error('Order not found.');
        }
    }

    public function updateStatus($order_id)
    {
        $this->processingStatus = $order_id;
        $currentUserId = Auth::id();
        try {
            $order = OrderMaster::with(['customer', 'entity'])->find($order_id);

            if ($order) {
                $oldStatus = $order->order_status;
                $newStatus = $this->orderStatus[$order_id];

                $order->order_status = $newStatus;
                $order->modified_by = $currentUserId;
                $order->save();

                if ($order->customer && $order->customer->email) {
                    Mail::to($order->customer->email)
                        ->send(new OrderStatusChanged($order, $oldStatus, $newStatus));
                }

                notyf()->success('Order status updated to ' . $newStatus . ' and notification email sent.');
            }
        } catch (\Exception $e) {
            Log::error('Status update failed: ' . $e->getMessage());
            notyf()->error('Failed to update order status.');
        }

        $this->processingStatus = null;
    }

    public function closeModal()
    {
        $this->viewOrder = false;
        $this->selectedOrder = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedEntityId()
    {
        $this->resetPage();
    }

    public function generateInvoice($order_id)
    {
        $order = OrderMaster::with(['customer', 'orderDetails.product', 'entity'])
            ->where('order_id', $order_id)
            ->firstOrFail();

        $this->generateInvoiceWithWorkflow($order_id, $order->workflow_type);
    }

    public function generateInvoiceWithWorkflow($order_id, $workflow_type)
    {
        DB::beginTransaction();
        try {
            $order = OrderMaster::with(['customer', 'orderDetails.product', 'entity'])
                ->where('order_id', $order_id)
                ->firstOrFail();

            $invoiceNumber = $this->generateUniqueInvoiceNumber();
            $workflowType = strtolower($workflow_type->value);
            $invoiceData = [
                'invoice_number' => $invoiceNumber,
                'order_id' => $order->order_id,
                'customer_id' => $order->customer_id,
                'entity_id' => $order->entity_id,
                'shipping_address' => $order->shipping_address,
                'subtotal' => ($workflowType === 'consignment') ? 0 : $order->subtotal,
                'discount' => ($workflowType === 'consignment') ? 0 : $order->discount,
                'freight' => ($workflowType === 'consignment') ? 0 : $order->freight,
                'tax' => ($workflowType === 'consignment') ? 0 : $order->tax,
                'total' => ($workflowType === 'consignment') ? 0 : $order->total,
                'remarks' => $order->remarks,
                'payment_terms' => $order->payment_terms,
                'status' => 'Confirmed',
                'created_by' => Auth::id(),
                'invoice_type' => $this->determineInvoiceType($order)
            ];
            $invoice = OrderInvoice::create($invoiceData);

            $invoiceDetails = [];
            foreach ($order->orderDetails as $orderDetail) {
                $invoiceDetails[] = [
                    'order_invoice_id' => $invoice->id,
                    'product_id' => $orderDetail->product_id,
                    'unit_price' => ($workflow_type === 'consignment') ? 0 : $orderDetail->unit_price,
                    'quantity' => $orderDetail->quantity,
                    'delivered_quantity' => ($workflow_type === 'consignment') ? 0 : $orderDetail->quantity,
                    'invoiced_quantity' => ($workflow_type === 'consignment') ? 0 : $orderDetail->quantity,
                    'discount' => ($workflow_type === 'consignment') ? 0 : $orderDetail->discount,
                    'total' => ($workflow_type === 'consignment') ? 0 : $orderDetail->total,
                    'manual_product_name' => $orderDetail->manual_product_name,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            OrderInvoiceDetail::insert($invoiceDetails);

            $order->update([
                'is_generated' => true,
                'modified_by' => Auth::id()
            ]);

            DB::commit();

            notyf()->success('Invoice generated successfully with number: ' . $invoiceNumber);
            return $invoice;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Invoice generation failed: ' . $e->getMessage());
            notyf()->error('Could not generate invoice: ' . $e->getMessage());
            return null;
        }
    }

    protected function generateUniqueInvoiceNumber()
    {
        do {
            $prefix = 'INV-' . now()->format('Ymd') . '-';
            $randomSuffix = Str::random(4);
            $invoiceNumber = $prefix . $randomSuffix;
        } while (OrderInvoice::where('invoice_number', $invoiceNumber)->exists());

        return $invoiceNumber;
    }

    protected function determineInvoiceType($order)
    {
        if ($order->workflow_type === 'consignment') {
            return 'consignment';
        }

        if ($order->workflow_type === 'multi_delivery') {
            return 'consignment';
        }

        if ($order->parent_order_id !== null) {
            return 'split_delivery';
        }

        return 'regular';
    }

    public function downloadInvoice($order_id)
    {
        try {
            $order = OrderMaster::with(['customer', 'orderDetails.product', 'entity'])
                ->where('order_id', $order_id)
                ->firstOrFail();

            if (!$order->is_generated) {
                notyf()->error('Invoice has not been generated yet.');
                return;
            }

            $workflowType = strtolower($order->workflow_type->value);

            /* if ($workflowType === 'consignment') {
                $order->subtotal = 0;
                $order->discount = 0;
                $order->freight = 0;
                $order->tax = 0;
                $order->total = 0;

                foreach ($order->orderDetails as $detail) {
                    // $detail->unit_price = 0;
                    $detail->delivered_quantity = 0;
                    $detail->invoiced_quantity = 0;
                    $detail->discount = 0;
                    $detail->total = 0;
                }
            } */

            $customer = $order->customer;

            if (!$customer) {
                notyf()->error('Customer details not found.');
                return;
            }

            $customerName = $customer->first_name . '_' . $customer->last_name;
            $fileName = $customerName . '-invoice.pdf';

            $pdf = PDF::loadView('admin.order.invoice-pdf', ['order' => $order]);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $fileName);
        } catch (\Exception $e) {
            Log::error('Invoice download failed: ' . $e->getMessage());
            notyf()->error('Could not download invoice PDF.');
        }
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPaymentModeFilter()
    {
        $this->resetPage();
    }

    public function render()
    {   
        $currentYearStart = now()->startOfYear()->format('Y-m-d');
        $currentYearEnd = now()->endOfYear()->format('Y-m-d');
      
        $orders = OrderMaster::with(['customer', 'orderDetails.product', 'entity'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('order_id', 'like', '%' . $this->search . '%')
                        ->orWhereHas('customer', function ($customerQuery) {
                            $customerQuery->where('first_name', 'like', '%' . $this->search . '%')
                                ->orWhere('last_name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('entity', function ($entityQuery) {
                            $entityQuery->where('company_name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('total', 'like', '%' . $this->search . '%')
                        ->orWhere('order_date', 'like', '%' . $this->search . '%')
                        ->orWhere('payment_mode', 'like', '%' . $this->search . '%')
                        ->orWhere('order_type', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedEntityId, function ($query) {
                $query->where('entity_id', $this->selectedEntityId);
            })
            ->when($this->dateStart && $this->dateEnd, function ($query) {
                $query->whereDate('order_date', '>=', $this->dateStart)
                    ->whereDate('order_date', '<=', $this->dateEnd);
            })
            ->when(!$this->dateStart && !$this->dateEnd, function ($query) use ($currentYearStart, $currentYearEnd) {
                $query->whereDate('order_date', '>=', $currentYearStart)
                    ->whereDate('order_date', '<=', $currentYearEnd);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('order_status', $this->statusFilter);
            })
            ->when($this->paymentModeFilter !== '', function ($query) {
                $query->where('payment_mode', $this->paymentModeFilter);
            })
            ->when($this->orderTypeFilter !== '', function ($query) {
                $query->where('order_type', $this->orderTypeFilter);
            }) 
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $this->orderStatus = [];
        foreach ($orders as $order) {
            $this->orderStatus[$order->order_id] = $order->order_status;
        }

        return view('livewire.admin.orders.order-list', [
            'orders' => $orders,
            'perpagerecords' => $this->perpagerecords,
            'entities' => $this->entities,
        ]);
    }
}
