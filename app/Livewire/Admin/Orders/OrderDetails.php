<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\OrderMaster;

class OrderDetails extends Component
{
    public $order;
    public $invoice_id;

    public function mount($invoice_id)
    {
        $this->invoice_id = $invoice_id;
        $this->order = OrderMaster::where('invoice_id', $invoice_id)->firstOrFail();
    }

   /*  public function downloadInvoice($invoice_id)
    {
        // Your existing download logic here
    } */

    public function back()
    {
        return redirect()->route('admin.orders.index');
    }

    public function render()
    {
        return view('livewire.admin.orders.order-details');
    }
}