<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        return view('admin.profile.index', compact('admin'));
    }

    public function edit()
    {
        $admin = Auth::user();
        return view('admin.profile.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::user();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|file|image|max:1024', // Max 1MB size
        ]);
    
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];
    
        if ($request->hasFile('image')) {
            // Store image in custom disk
            $imagePath = $request->file('image')->store('profile_images', 'custom_profile_images');
            
            // Remove the old profile image if it exists
            if ($admin->profile_image && Storage::disk('custom_profile_images')->exists(basename($admin->profile_image))) {
                Storage::disk('custom_profile_images')->delete(basename($admin->profile_image));
            }
    
            // Save the new image path
            $updateData['profile_image'] = 'profile_images/' . basename($imagePath);
            notyf()->success('Image uploaded successfully');
        }
    
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
    
        try {
            User::where('id', $admin->id)->update($updateData);
            notyf()->success('Profile updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());
            notyf()->error('An error occurred while updating your profile');
        }
    
        return redirect()->route('admin.profile.index');
    }
    

    public function destroy()
    {
        $admin = Auth::user();

        try {
            if ($admin->profile_image) {
                Storage::disk('public')->delete($admin->profile_image);
            }

            if ($admin instanceof User) {
                $admin->delete();
                notyf()->success('Account deleted successfully');
            } else {
                notyf()->error('Unable to delete account');
            }
        } catch (\Exception $e) {
            notyf()->error('An error occurred while deleting your account');
        }

        return redirect()->route('admin.login');
    }

}
