<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Vendor;
use Spatie\Permission\Models\Role;

class AddVendor extends Component
{
    public $name;
    public $shop_name;
    public $roles = [];
    public $availableRoles;

    public function mount()
    {
        // Get available roles for vendors
        $this->availableRoles = Role::where('guard_name', 'vendor')->get();
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'shop_name' => 'required|string|max:255',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Create the vendor
        $vendor = Vendor::create([
            'name' => $this->name,
            'shop_name' => $this->shop_name,
        ]);

        // Assign roles to the vendor
        $vendor->syncRoles($this->roles);

        // Reset the input fields
        $this->reset(['name', 'shop_name', 'roles']);

        session()->flash('success', 'Vendor added successfully!');

        return redirect()->route('admin.vendors.index'); // Redirect to vendors index
    }

    public function render()
    {
        return view('livewire.admin.add-vendor');
    }
}
