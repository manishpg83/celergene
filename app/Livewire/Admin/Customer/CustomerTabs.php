<?php

namespace App\Livewire\Admin\Customer;

use Livewire\Component;
use Livewire\WithPagination;

class CustomerTabs extends Component
{
    use WithPagination;
    
    protected $queryString = [];
    
    protected $paginationTheme = 'bootstrap';
    
    public $customer;
    public $activeTab = 'overview';
    
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($customer)
    {
        $this->customer = $customer;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function render()
    {
        $orders = $this->customer->orders()
            ->orderBy('order_date', 'desc')
            ->paginate(10);
            
        return view('livewire.admin.customer.customer-tabs', [
            'orders' => $orders
        ]);
    }
}
