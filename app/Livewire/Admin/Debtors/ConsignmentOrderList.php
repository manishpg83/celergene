<?php

namespace App\Livewire\Admin\Debtors;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OrderMaster;

class ConsignmentOrderList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 25;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $consignmentOrders = OrderMaster::with(['customer'])
            ->where('workflow_type', 'consignment')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('order_number', 'like', '%' . $this->search . '%')
                        ->orWhere('order_date', 'like', '%' . $this->search . '%')
                        ->orWhere('total', 'like', '%' . $this->search . '%')
                        ->orWhere('payment_mode', 'like', '%' . $this->search . '%')
                        ->orWhere('order_status', 'like', '%' . $this->search . '%')
                        ->orWhereHas('customer', function ($q) {
                            $q->where('first_name', 'like', '%' . $this->search . '%')
                                ->orWhere('last_name', 'like', '%' . $this->search . '%')
                                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$this->search}%"])
                                ->orWhere('company_name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.debtors.consignment-order-list', [
            'consignmentOrders' => $consignmentOrders,
        ]);
    }
}
