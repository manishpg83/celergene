<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserList extends Component
{
    use WithPagination;

    public $userId;
    public $name, $email, $role;
    public $status = 'active', $search = '', $perPage = 5, $isEditing = false;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $statusFilter = 'all';
    public $confirmingDeletion = false;
    public $roles;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'role' => 'required|string',
        'status' => 'required|in:active,inactive',
    ];

    public function mount()
    {
        $this->roles = Role::all(); // Fetch all roles
    }

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        $user->status = 'active'; // Restore status to active
        $user->save();
        notyf()->success('User restored successfully.');
    }

    public function delete()
    {
        $user = User::withTrashed()->find($this->userId);

        if ($user->trashed()) {
            $user->forceDelete();
            notyf()->success('User permanently deleted.');
        } else {
            $user->status = 'inactive'; // Update status to inactive
            $user->save();
            $user->delete();
            notyf()->success('Customer type suspended. Click delete again to permanently remove.');
        }

        $this->confirmingDeletion = false;
    }

    public function confirmDelete($id)
    {
        $this->userId = $id;
        $user = User::withTrashed()->find($id);

        if ($user->trashed()) {
            $this->confirmingDeletion = true;
        } else {
            $this->delete();
        }
    }
    public function render()
    {
        $query = User::query()
            ->with('roles')
            ->when($this->search, function ($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->withTrashed()
            ->orderBy($this->sortField, $this->sortDirection);

        $users = $query->paginate($this->perPage);

        return view('livewire.admin.user.user-list', [
            'users' => $users,
            'roles' => $this->roles,
        ]);
    }

    public function edit(User $user)
    {
        return redirect()->route('admin.vendors.add', ['id' => $user->id]);
    }

    public function toggleActive(Vendor $user)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        if ($user->trashed() && $user->status === 'active') {
            $user->restore();
        } elseif (!$user->trashed() && $user->status === 'inactive') {
            $user->delete();
        }

        notyf()->success('User status updated successfully.');
    }

    public function save()
    {
        $this->validate();

        $user = $this->userId ? User::find($this->userId) : new User();
        $user->fill($this->only(['name', 'email', 'status']));
        $user->save();

        // Sync the role
        $user->syncRoles([$this->role]);

        $this->isEditing = false;
        notyf()->success('User saved successfully.');
    }
}
