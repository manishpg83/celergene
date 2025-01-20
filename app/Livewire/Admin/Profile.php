<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    public $profile_photo_path;
    public $temp_profile_photo;

    public $deleteConfirmation = false;
    public $password_for_deletion;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::guard('web')->id(),
            'profile_photo_path' => 'nullable|image|max:1024',
            'new_password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function mount()
    {
        $this->admin = Auth::guard('web')->user();
        $this->name = $this->admin->name;
        $this->email = $this->admin->email;
    }

    public function updatedProfilePhotoPath()
    {
        $this->temp_profile_photo = $this->profile_photo_path;
    }

    public function updateProfile()
    {
        $this->validate();

        $admin = Auth::guard('web')->user();
        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->profile_photo_path) {
            $imagePath = $this->profile_photo_path->store('', 'custom_profile_images');
            if ($imagePath) {
                // Delete old image if it exists
                if ($admin->profile_photo_path) {
                    Storage::disk('public')->delete($admin->profile_photo_path);
                }
                $newImagePath = 'admin/assets/img/profile_img/' . basename($imagePath);
                $updateData['profile_photo_path'] = $newImagePath;
                
                // Update the admin model and property immediately
                $admin->profile_photo_path = $newImagePath;
                $this->admin->profile_photo_path = $newImagePath;
                
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
            
            // Reset only password-related fields, keep the image data
            $this->reset(['new_password', 'new_password_confirmation']);
            
            // Reset upload-related properties after successful update
            $this->profile_photo_path = null;
            $this->temp_profile_photo = null;
            
            notyf()->success('Profile updated successfully.');
        } catch (\Exception $e) {
            $this->notify('An error occurred while updating your profile', 'error');
        }
    }

    public function resetImage()
    {
        if ($this->admin->profile_photo_path) {
            Storage::disk('public')->delete($this->admin->profile_photo_path);
            $this->admin->profile_photo_path = null;
            $this->admin->save();
            
            // Reset all image-related properties
            $this->profile_photo_path = null;
            $this->temp_profile_photo = null;
            
            $this->notify('Profile image removed successfully');
        }
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

        return redirect()->route('admin.login')->with('success', 'Account permanently deleted.');
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
