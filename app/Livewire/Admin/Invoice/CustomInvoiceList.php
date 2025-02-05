<?php

namespace App\Livewire\Admin\Invoice;

use Livewire\Component;
use App\Models\OrderMaster;
use App\Models\Entity;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\OrderStatusChanged;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CustomInvoiceList extends Component
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

    protected $updatesQueryString = ['search', 'perPage', 'selectedEntityId'];

    public function mount()
    {
        $this->entities = Entity::active()->get();
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

    public function downloadInvoice($invoiceId)
    {
        try {
            $order = OrderMaster::with(['customer', 'orderDetails.product', 'entity'])
                ->where('order_id', $invoiceId)
                ->firstOrFail();

            if (!$order->is_generated) {
                notyf()->error('Invoice has not been generated yet.');
                return;
            }

            $customer = $order->customer;

            if (!$customer) {
                notyf()->error('Customer details not found.');
                return;
            }

            $customerName = $customer->first_name . '_' . $customer->last_name;
            $fileName = 'Invoice-' . $customerName . '.pdf';

            $pdf = PDF::loadView('admin.order.invoice-pdf', ['order' => $order]);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $fileName);
        } catch (\Exception $e) {
            Log::error('Invoice generation failed: ' . $e->getMessage());
            notyf()->error('Could not generate invoice PDF.');
        }
    }

    public function render()
    {
        $orders = OrderMaster::with(['customer', 'orderDetails.product', 'entity'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('order_number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('customer', function ($customerQuery) {
                            $customerQuery->where('first_name', 'like', '%' . $this->search . '%')
                                ->orWhere('last_name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('entity', function ($entityQuery) {
                            $entityQuery->where('company_name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('total', 'like', '%' . $this->search . '%')
                        ->orWhere('order_date', 'like', '%' . $this->search . '%')
                        ->orWhere('payment_mode', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedEntityId, function ($query) {
                $query->where('entity_id', $this->selectedEntityId);
            })
            ->when($this->dateStart && $this->dateEnd, function ($query) {
                $query->whereDate('order_date', '>=', date('Y-m-d', strtotime($this->dateStart)))
                    ->whereDate('order_date', '<=', date('Y-m-d', strtotime($this->dateEnd)));
            })
            ->where('is_generated', true)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $this->orderStatus = [];
        foreach ($orders as $order) {
            $this->orderStatus[$order->order_id] = $order->order_status;
        }

        return view('livewire.admin.invoice.custom-invoice-list', [
            'orders' => $orders,
            'perpagerecords' => $this->perpagerecords,
            'entities' => $this->entities,
        ]);
    }
}
