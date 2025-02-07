<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class WarehouseOrderUpdateController extends Controller
{
    public function edit($delivery_order_id)
    {
        $deliveryOrder = DeliveryOrder::find($delivery_order_id);

        if (!$deliveryOrder) {
            return abort(404, 'Delivery order not found.');
        }

        return view('warehouse.update-delivery', compact('deliveryOrder'));
    }

    public function update(Request $request, $delivery_order_id)
    {
        $request->validate([
            'status' => 'required|string',
            'tracking_number' => 'nullable|string|max:255',
        ]);
        Log::info($request);
        $deliveryOrder = DeliveryOrder::find($delivery_order_id);

        if (!$deliveryOrder) {
            return abort(404, 'Delivery order not found.');
        }

        $deliveryOrder->update([
            'status' => $request->status,
            'tracking_number' => $request->tracking_number,
        ]);
        Log::info($deliveryOrder->toArray());
        return redirect()->back()->with('message', 'Delivery order updated successfully!');
    }
}
