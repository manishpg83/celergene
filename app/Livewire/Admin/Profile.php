<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

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
            'email' => 'required|string|email|max:255|unique:admins,email,' . Auth::guard('admin')->id(),
            'image' => 'nullable|image|max:1024', // 1MB Max
            'new_password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function mount()
    {
        $admin = Auth::guard('admin')->user();
        $this->name = $admin->name;
        $this->email = $admin->email;
    }

    public function updateProfile()
    {
        $this->validate();

        $admin = Auth::guard('admin')->user();
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
                //$this->notify('Image uploaded successfully');
                notyf()->success('Image uploaded successfully.');
            } else {
                notyf()->success('Entity permanently deleted.');
                return;
            }
        }

        if ($this->new_password) {
            $updateData['password'] = Hash::make($this->new_password);
        }

        try {
            Admin::where('id', $admin->id)->update($updateData);
            $this->reset(['new_password', 'new_password_confirmation', 'image']);
            //$this->notify('Profile updated successfully');
            notyf()->success('Profile updated successfully.');
        } catch (\Exception $e) {
            $this->notify('An error occurred while updating your profile', 'error');
        }
    }

    public function resetImage()
    {
        $admin = Auth::guard('admin')->user();
        if ($admin->profile_image) {
            Storage::disk('public')->delete($admin->profile_image);
            $admin->profile_image = null;
            $admin->save();
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

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($this->password_for_deletion, $admin->password)) {
            $this->addError('password_for_deletion', 'The provided password is incorrect.');
            return;
        }

        // Perform the account deletion
        $admin->delete();

        // Log the user out
        Auth::guard('admin')->logout();

        // Redirect to login page with a message
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