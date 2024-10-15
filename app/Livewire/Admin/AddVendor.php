<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Vendor;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AddVendor extends Component
{
    public $name;
    public $email;
    public $password;
    public $roles = [];
    public $availableRoles;
    public $password_confirmation;

    public function mount()
    {
        $this->availableRoles = Role::where('guard_name', 'vendor')->get();
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:vendors',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'password_confirmation' => 'required|string|min:8',
        ]);

        try {
            if (!Auth::check()) {
                notyf()->error('You must be logged in to create an entity.');
                return;
            }

            $vendor = Vendor::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'created_by' => Auth::id(),
            ]);

            if (!empty($this->roles)) {
                $validRoles = Role::whereIn('id', $this->roles)->pluck('id')->toArray();
                if (!empty($validRoles)) {
                    $vendor->syncRoles($validRoles);
                } else {
                    notyf()->error('Invalid role(s) provided.');
                    return;
                }
            }

            $this->reset(['name', 'email', 'password', 'roles', 'password_confirmation']);

            notyf()->success('Vendor added successfully!');
            return redirect()->route('admin.vendors.index');
        } catch (\Exception $e) {
            Log::error('Error creating vendor', ['error' => $e->getMessage()]);
            notyf()->error('There was an error adding the vendor.');
        }
    }

    public function render()
    {
        return view('livewire.admin.add-vendor');
    }
}
