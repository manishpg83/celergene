<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\Vendor;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class AddUser extends Component
{
    public $vendorId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $status = 'active'; // Default status
    public $roles = [];
    public $availableRoles;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:vendors,email', // Temporary validation rule
        'password' => 'required|string|min:8|confirmed',
        'status' => 'required|in:active,inactive', // Validate status
        'roles' => 'required|array',
        'roles.*' => 'exists:roles,id',
    ];

    public function mount()
    {
        // Fetch available roles for vendor guard
        $this->availableRoles = Role::where('guard_name', 'vendor')->get();
        $this->vendorId = request()->query('id');

        if ($this->vendorId) {
            $vendor = Vendor::find($this->vendorId);
            if ($vendor) {
                $this->name = $vendor->name;
                $this->email = $vendor->email;
                $this->status = $vendor->status; // Update status from vendor
                $this->roles = $vendor->roles()->pluck('id')->toArray();
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.user.add-user', [
            'availableRoles' => $this->availableRoles,
        ]);
    }

    public function save()
    {
        // Adjust the unique email validation rule for updates
        if ($this->vendorId) {
            $this->rules['email'] = 'required|email|max:255|unique:vendors,email,' . $this->vendorId;
            $this->rules['password'] = 'nullable|string|min:8|confirmed'; // Make password optional for updates
        }

        $this->validate($this->rules); // Validate using the updated rules

        // Check if we are updating an existing vendor or creating a new one
        $vendor = $this->vendorId ? Vendor::find($this->vendorId) : new Vendor();

        // Fill the vendor with the validated data
        $vendor->fill([
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status, // Set status
        ]);

        if (!$this->vendorId) {
            $vendor->password = bcrypt($this->password);
            $vendor->created_by = Auth::id();
        }

        $vendor->save();

        if (!empty($this->roles)) {
            $validRoles = Role::whereIn('id', $this->roles)
                              ->where('guard_name', 'vendor')
                              ->pluck('id')
                              ->toArray();
            if (!empty($validRoles)) {
                $vendor->syncRoles($validRoles);
            } else {
                notyf()->error('Invalid role(s) provided.');
                return;
            }
        }

        notyf()->success('User saved successfully.');

        // Reset fields after submission
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'status', 'roles']);

        // Redirect or stay on the same page as needed.
        return redirect()->route('admin.vendors.index'); // Uncomment to redirect after save.
    }

    public function back()
    {
        return redirect()->route('admin.vendors.index');
    }
}
