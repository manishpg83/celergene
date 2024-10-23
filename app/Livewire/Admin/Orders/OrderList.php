<?php

namespace App\Livewire\Admin\Orders;

use App\Models\OrderMaster;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

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

    public function render()
    {
        $orders = OrderMaster::with(['customer', 'orderDetails.product'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('invoice_id', 'like', '%' . $this->search . '%')
                      ->orWhereHas('customer', function($customerQuery) {
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

        return view('livewire.admin.orders.order-list', [
            'orders' => $orders,
            'perpagerecords' => $this->perpagerecords,
        ]);
    }
}
