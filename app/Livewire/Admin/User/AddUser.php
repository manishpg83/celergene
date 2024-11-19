<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class AddUser extends Component
{
    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $status = 'active';
    public $roles = [];
    public $availableRoles;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'status' => 'required|in:active,inactive',
        'status' => 'required|in:active,inactive',
        'roles' => 'required|array',
        'roles.*' => 'exists:roles,id',
    ];

    public function mount()
    {
        $this->availableRoles = Role::where('guard_name', 'web')->get();
        $this->userId = request()->query('id');

        if ($this->userId) {
            $user = User::find($this->userId);
            if ($user) {
                $this->name = $user->name;
                $this->email = $user->email;
                $this->status = $user->status;
                $this->roles = $user->roles()->pluck('id')->toArray();
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
        if ($this->userId) {
            $this->rules['email'] = 'required|email|max:255|unique:users,email,' . $this->userId;
            $this->rules['password'] = 'nullable|string|min:8|confirmed';
        }

        $this->validate($this->rules);
        $user = $this->userId ? User::find($this->userId) : new User();

        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
        ]);

        if (!$this->userId) {
            $user->password = bcrypt($this->password);
            $user->created_by = Auth::id();
        }

        $user->save();

        if (!empty($this->roles)) {
            $validRoles = Role::whereIn('id', $this->roles)
                ->where('guard_name', 'web')
                ->pluck('id')
                ->toArray();
            if (!empty($validRoles)) {
                $user->syncRoles($validRoles);
                $user->type = $validRoles[0];
                $user->save();
            } else {
                notyf()->error('Invalid role(s) provided.');
                return;
            }
        }

        notyf()->success('User saved successfully.');

        $this->reset(['name', 'email', 'password', 'password_confirmation', 'status', 'roles']);

        return redirect()->route('admin.user.index');
    }

    public function back()
    {
        return redirect()->route('admin.user.index');
    }
}
