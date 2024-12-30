<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class FrontAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            notyf()->success('Login successful');
            return redirect()->intended('/myaccount');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    
    public function showRegistrationForm()
    {
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        try {
            Log::info('Registration started', $request->all());
    
            // Validate the incoming request
            $request->validate([
                'reg_firstname' => 'required|string|max:25',
                'reg_lastname' => 'required|string|max:50',
                'reg_email' => 'required|email|unique:users,email',
                'reg_pass' => 'required|min:8|confirmed',
                'dob_day' => 'required|numeric|min:1|max:31',
                'dob_month' => 'required|numeric|min:1|max:12',
                'dob_year' => 'required|numeric|min:1900|max:' . date('Y'),
            ]);
    
            // Create date of birth
            $dob = $request->dob_year . '-' . 
                   str_pad($request->dob_month, 2, '0', STR_PAD_LEFT) . '-' . 
                   str_pad($request->dob_day, 2, '0', STR_PAD_LEFT);
    
            // Create the user
            \App\Models\User::create([
                'first_name' => $request->reg_firstname,
                'last_name' => $request->reg_lastname,
                'email' => $request->reg_email,
                'password' => Hash::make($request->reg_pass),
                'name' => 'N/A',
                'phone' => $request->reg_phone ?? null,
                'company' => $request->reg_company ?? null,
                'date_of_birth' => $dob, // Add the DOB field
            ]);
    
            Log::info('Registration completed successfully');
            notyf()->success('Registration completed successfully');
            return redirect()->route('login');
    
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Registration failed!']);
        }
    }
    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('users')->sendResetLink(
            $request->only('email'),
            function ($user, $token) {
                $user->sendPasswordResetNotification($token);
            }
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors([
            'email' => 'The provided email is not registered in our system.',
        ]);
    }


    public function showResetPasswordForm($token)
    {
        return view('admin.auth.reset-password', ['token' => $token, 'email' => request('email')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('users')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('admin.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        // Invalidate and regenerate session to prevent session fixation.
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redirect to the home page with a success message.
        return redirect()->route('home')->with('success', 'You have successfully logged out.');
    }
    
} 