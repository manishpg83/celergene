<?php

namespace App\Livewire\Frontend\Account;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Myprofile extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $email;
    public $image;
    public $phone;
    public $password;
    public $temp_profile_photo;
    public $password_confirmation;
    public $customer;

    public function mount()
    {
        $user = Auth::user();
        $this->customer = Customer::where('user_id', $user->id)->first();

        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function resetImage()
    {
        $this->temp_profile_photo = null;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $this->validate([
            'first_name' => 'nullable|string|max:25',
            'last_name' => 'nullable|string|max:50',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|min:8|confirmed',
            'image' => 'nullable|image|max:1024'
        ]);

        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->phone = $this->phone;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $updateData = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile_number' => $this->phone
        ];

        if ($this->image) {
            $imagePath = $this->image->store('', 'custom_profile_images');
            if ($imagePath) {
                if ($this->customer->image && Storage::disk('custom_profile_images')->exists($this->customer->image)) {
                    Storage::disk('custom_profile_images')->delete($this->customer->image);
                }

                $newImagePath = 'admin/assets/img/profile_img/' . basename($imagePath);
                $updateData['image'] = $newImagePath;
            }
        }

        $this->customer->update($updateData);
        $this->reset('image');
        notyf()->success('Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.frontend.account.myprofile');
    }
}
