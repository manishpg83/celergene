<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        return view('admin.warehouses.index');
    }

    public function add()
    {
        return view('admin.warehouses.add');
    }

    public function showAddWarehouseForm($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return view('livewire.admin.warehouses.add-warehouse', compact('warehouse'));
    }
}
