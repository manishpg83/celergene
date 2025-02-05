<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;

class RoleManager extends Component
{
    use WithPagination;

    public $roles;
    public $permissions;
    public $roleName;
    public $selectedPermissions = [];
    public $editingRole = null;
    public $confirmingDeletion = false;
    public $searchTerm = '';
    public $perPage = 25;

    public function mount()
    {
        $this->roles = Role::with('permissions')->get();
        $this->permissions = Permission::all();
    }

    public function createRole()
    {
        $this->validate([
            'roleName' => 'required|unique:roles,name',
            'selectedPermissions' => 'required|array',
        ]);

        // Validate that selected permissions exist
        $validPermissions = Permission::whereIn('id', $this->selectedPermissions)->pluck('id')->toArray();

        if (count($validPermissions) !== count($this->selectedPermissions)) {
            session()->flash('error', 'One or more selected permissions do not exist.');
            return;
        }

        $role = Role::create(['name' => $this->roleName]);
        $role->syncPermissions($validPermissions);

        $this->reset(['roleName', 'selectedPermissions']);
        $this->roles = Role::with('permissions')->get();

        session()->flash('success', 'Role created successfully');
    }

    public function editRole(Role $role)
    {
        $this->editingRole = $role;
        $this->roleName = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    }

    public function updateRole()
    {
        $this->validate([
            'roleName' => 'required|unique:roles,name,' . $this->editingRole->id,
            'selectedPermissions' => 'required|array',
        ]);

        $validPermissions = Permission::whereIn('id', $this->selectedPermissions)->pluck('id')->toArray();

        if (count($validPermissions) !== count($this->selectedPermissions)) {
            session()->flash('error', 'One or more selected permissions do not exist.');
            return;
        }

        $this->editingRole->name = $this->roleName;
        $this->editingRole->save();
        $this->editingRole->syncPermissions($validPermissions);

        $this->reset(['roleName', 'selectedPermissions', 'editingRole']);
        $this->roles = Role::with('permissions')->get();

        session()->flash('success', 'Role updated successfully');
    }

    public function deleteRole(Role $role)
    {
        if ($role->name === 'super-admin') {
            session()->flash('error', 'Cannot delete super-admin role');
            return;
        }

        $role->delete();
        $this->roles = Role::with('permissions')->get();

        session()->flash('success', 'Role deleted successfully');
    }

    public function render()
    {
        $paginator = Role::with('permissions')
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->paginate($this->perPage);

        $this->roles = $paginator->items();
        $perpagerecords = perpagerecords();

        return view('livewire.admin.role-manager', [
            'paginator' => $paginator,
            'perpagerecords' => $perpagerecords,
        ]);
    }
}
