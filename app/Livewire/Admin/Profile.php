<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;
    public $admin;

    public $name;
    public $email;
    public $new_password;
    public $new_password_confirmation;
    public $image;
    public $deleteConfirmation = false;
    public $password_for_deletion;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::guard('web')->id(),
            'image' => 'nullable|image|max:1024', // 1MB Max
            'new_password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function mount()
    {
        $this->admin = Auth::guard('web')->user(); // Assign admin data to $admin
        $this->name = $this->admin->name;
        $this->email = $this->admin->email;
    }

    public function updateProfile()
    {
        $this->validate();

        $admin = Auth::guard('web')->user();
        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->image) {
            $imagePath = $this->image->store('profile_images', 'public');
            if ($imagePath) {
                if ($admin->profile_image) {
                    Storage::disk('public')->delete($admin->profile_image);
                }
                $updateData['profile_image'] = $imagePath;
                notyf()->success('Image uploaded successfully.');
            } else {
                notyf()->error('Failed to upload image.');
                return;
            }
        }

        if ($this->new_password) {
            $updateData['password'] = Hash::make($this->new_password);
        }

        try {
            User::where('id', $admin->id)->update($updateData);
            $this->reset(['new_password', 'new_password_confirmation', 'image']);
            notyf()->success('Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            $this->notify('An error occurred while updating your profile', 'error');
        }
    }

    public function resetImage()
    {
        if ($this->admin->profile_image) {
            Storage::disk('public')->delete($this->admin->profile_image);
            $this->admin->profile_image = null;
            $this->admin->save();
            $this->notify('Profile image removed successfully');
        }
        $this->image = null;
    }

    public function confirmDelete()
    {
        $this->deleteConfirmation = true;
    }

    public function cancelDelete()
    {
        $this->deleteConfirmation = false;
        $this->password_for_deletion = '';
    }

    public function deleteAccount()
    {
        $this->validate([
            'password_for_deletion' => 'required',
        ]);

        $admin = Auth::user();

        if (!Hash::check($this->password_for_deletion, $admin->password)) {
            $this->addError('password_for_deletion', 'The provided password is incorrect.');
            return;
        }

        $admin->delete();
        Auth::logout();

        return redirect()->route('admin.login')->with('success', 'Entity permanently deleted.');
    }

    private function notify($message, $type = 'success')
    {
        $this->dispatch('notify', ['message' => $message, 'type' => $type]);
    }

    public function render()
    {
        return view('livewire.admin.profile');
    }
}
