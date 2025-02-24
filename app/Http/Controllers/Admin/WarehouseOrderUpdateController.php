<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderShippedMail;
use App\Models\DeliveryOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WarehouseOrderUpdateController extends Controller
{
    public function edit($delivery_order_id)
    {
        $deliveryOrder = DeliveryOrder::with(['orderMaster.customer', 'details.product'])->find($delivery_order_id);

        if (! $deliveryOrder) {
            return abort(404, 'Delivery order not found.');
        }

        return view('warehouse.update-delivery', compact('deliveryOrder'));
    }

    public function update(Request $request, $delivery_order_id)
    {
        $request->validate([
            'tracking_number' => 'nullable|string|max:255',
            'tracking_url' => 'nullable|string|max:255',
        ]);

        $deliveryOrder = DeliveryOrder::find($delivery_order_id);

        if (! $deliveryOrder) {
            return abort(404, 'Delivery order not found.');
        }

        $oldStatus = $deliveryOrder->status;

        $deliveryOrder->update([
            'status' => 'Shipped',
            'tracking_number' => $request->tracking_number,
            'tracking_url' => $request->tracking_url,
        ]);

        if ($oldStatus !== 'Shipped') {
            Mail::to($deliveryOrder->orderMaster->customer->email)
                ->send(new OrderShippedMail($deliveryOrder, $request->status));
        }

        notyf()->success('Delivery order updated successfully!');

        return redirect()->back()->with('message', 'Delivery order updated successfully!');
    }
}
