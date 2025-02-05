<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public $users;
    public $selectedUserId; // To store the ID of the user being edited
    public $selectedRole; // To store the selected role for the user
    public $perPage = 25;
    public $searchTerm = '';
    public $pagination;

    public function mount()
    {
        // Fetch all users with roles
        $this->users = User::with('roles')->paginate($this->perPage);
    }

    public function render()
    {
        $users = User::with('roles')
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->paginate($this->perPage);

        $this->users = $users->items();
        $perpagerecords = perpagerecords();

        return view('livewire.admin.user-manager', [
            'roles' => Role::all(),
            'paginatedUsers' => $users,
            'perpagerecords' => $perpagerecords,
        ]);
    }

    public function editUserRole($userId)
    {
        $this->selectedUserId = $userId;
        $user = User::find($userId);
        $this->selectedRole = $user->roles->first()->id ?? null; // Get the first role of the user
    }

    public function updateUserRole()
    {
        // Check if selectedRole is valid
        logger()->info('Selected Role:', [$this->selectedRole]); // Log selected role
        $user = User::find($this->selectedUserId);

        if ($user) {
            $user->syncRoles([$this->selectedRole]);

            session()->flash('success', 'User role updated successfully.');
            $this->reset(['selectedUserId', 'selectedRole']);
            $this->users = User::with('roles')->get(); // Refresh user list
        } else {
            session()->flash('error', 'User not found.');
        }
    }
}
