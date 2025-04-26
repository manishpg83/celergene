<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithPagination;

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

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'role' => 'required|string',
        'status' => 'required|in:active,inactive',
    ];

    public function mount()
    {
        $this->resetFields();
    }

    public function render()
    {
        $query = User::query()
            ->where('users.type', '!=', 'customer')
            ->when($this->search, function ($query) {
                $query->where('users.name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('users.email', 'LIKE', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->withTrashed()
            ->orderBy($this->sortField, $this->sortDirection);

        $users = $query->paginate($this->perPage);
        $perpagerecords = perpagerecords();
        return view('livewire.admin.user.user-list', [
            'users' => $users,
            'perpagerecords' => $perpagerecords,
        ]);
    }


    public function updatedPerPage($value)
    {
        $this->perPage = $value;
        $this->resetPage();
    }

    public function updatedStatusFilter($value)
    {
        $this->statusFilter = $value;
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->reset([
            'userId',
            'name',
            'email',
            'role',
            'status'
        ]);
        $this->status = 'active';
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function create()
    {
        $this->resetFields();
        $this->isEditing = true;
    }

    public function edit($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user->trashed()) {
            notyf()->error('User is suspended. Please restore the user first.');
        } else {
            return redirect()->route('admin.user.add', ['id' => $user->id]);
        }
    }

    public function save()
    {
        $this->validate();

        $user = $this->userId ? User::find($this->userId) : new User();

        $user->fill($this->only(['name', 'email', 'role', 'status']));
        $user->save();

        $this->isEditing = false;
        notyf()->success('User saved successfully.');
    }

    public function delete()
    {
        $user = User::withTrashed()->find($this->userId);

        if ($user->trashed()) {
            $user->forceDelete();
            notyf()->success('User permanently deleted.');
        } else {
            $user->status = 'inactive';
            $user->save();
            $user->delete();
            notyf()->success('User suspended. Click delete again to permanently remove.');
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

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        $user->status = 'active';
        $user->save();
        notyf()->success('User restored successfully.');
    }

    public function toggleActive(User $user)
    {
        if (!$user->trashed()) {
            $user->status = $user->status === 'active' ? 'inactive' : 'active';
            $user->save();
            notyf()->success('User status updated successfully.');
        }
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->resetFields();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }
}
