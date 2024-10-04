<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('roles')->paginate(10);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function edit(Vendor $vendor)
    {
        $roles = Role::where('guard_name', 'vendor')->get();
        return view('admin.vendors.edit', compact('vendor', 'roles'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $vendor->syncRoles($request->roles);

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor permissions updated successfully');
    }
}
