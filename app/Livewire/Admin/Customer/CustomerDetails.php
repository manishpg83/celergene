<?php

namespace App\Livewire\Admin\Customer;

use App\Models\Order;
use Livewire\Component;
use App\Models\Customer;
use App\Models\OrderDetails;

class CustomerDetails extends Component
{
    public $customer;
    public $activeTab = 'overview';
    public $selectedAddress = 'billing';

    public function mount($id)
    {
        $this->customer = Customer::withTrashed()
            ->withCount('orders')
            ->withSum('orders', 'total')
            ->findOrFail($id);
    }
    public function details()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function setAddress($addressType)
    {
        $this->selectedAddress = $addressType;
    }

    public function render()
    {
        return view('livewire.admin.customer.customer-details', [
            'orders' => $this->customer->orders()->get(),
            'addresses' => $this->getAddresses(),
        ]);
    }

    protected function getAddresses()
    {
        return [
            'billing' => [
                'address' => $this->customer->billing_address,
                'country' => $this->customer->billing_country,
                'postal_code' => $this->customer->billing_postal_code,
            ],
            'shipping_1' => [
                'address' => $this->customer->shipping_address_1,
                'country' => $this->customer->shipping_country_1,
                'postal_code' => $this->customer->shipping_postal_code_1,
            ],
            'shipping_2' => [
                'address' => $this->customer->shipping_address_2,
                'country' => $this->customer->shipping_country_2,
                'postal_code' => $this->customer->shipping_postal_code_2,
            ],
        ];
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function restore()
    {
        if ($this->customer->trashed()) {
            $this->customer->restore();
            notyf()->success('Customer restored successfully.');
        }
    }

    public function delete()
    {
        if ($this->customer->trashed()) {
            $this->customer->forceDelete();
            notyf()->success('Customer permanently deleted.');
        } else {
            $this->customer->delete();
            notyf()->success('Customer suspended. Click delete again to permanently remove.');
        }

        return redirect()->route('admin.customer.index');
    }
}