<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\OrderMaster;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\OrderStatusChanged;
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
    public $perPage = 10;

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

    protected $updatesQueryString = ['search', 'perPage'];

    public function viewOrderDetails($invoiceId)
    {
        try {
            $this->selectedOrder = OrderMaster::with(['customer', 'orderDetails.product'])
                ->where('invoice_id', $invoiceId)
                ->firstOrFail();
            $this->viewOrder = true;
        } catch (\Exception $e) {
            notyf()->error('Order not found.');
        }
    }

    public function updateStatus($invoiceId)
    {
        $this->processingStatus = $invoiceId;
        $currentUserId = Auth::id();
        try {
            $order = OrderMaster::with('customer')->find($invoiceId);

            if ($order) {
                $oldStatus = $order->invoice_status;
                $newStatus = $this->orderStatus[$invoiceId];

                $order->invoice_status = $newStatus;
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

    public function downloadInvoice($invoiceId)
    {
        try {
            $order = OrderMaster::with(['customer', 'orderDetails.product'])
                ->where('invoice_id', $invoiceId)
                ->firstOrFail();

            $pdf = PDF::loadView('admin.order.invoice-pdf', ['order' => $order]);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, 'Invoice-' . $invoiceId . '.pdf');
        } catch (\Exception $e) {
            notyf()->error('Could not generate invoice PDF.');
        }
    }

    public function render()
    {
        $orders = OrderMaster::with(['customer', 'orderDetails.product'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('invoice_id', 'like', '%' . $this->search . '%')
                        ->orWhereHas('customer', function ($customerQuery) {
                            $customerQuery->where('first_name', 'like', '%' . $this->search . '%')
                                ->orWhere('last_name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('total', 'like', '%' . $this->search . '%')
                        ->orWhere('date', 'like', '%' . $this->search . '%')
                        ->orWhere('payment_mode', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $this->orderStatus = [];
        foreach ($orders as $order) {
            $this->orderStatus[$order->invoice_id] = $order->invoice_status;
        }

        return view('livewire.admin.orders.order-list', [
            'orders' => $orders,
            'perpagerecords' => $this->perpagerecords,
        ]);
    }
}
