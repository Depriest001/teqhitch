<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function AdminLoginForm()
    {
        return view('auth.adminlogin');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // ================= LOGIN FOR USERS + INSTRUCTORS =================
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // Add status check
        $credentials['status'] = 'active';

        if (Auth::attempt($credentials, $request->remember)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'instructor') {
                return redirect()->route('staff.dashboard')
                    ->with('success', 'Welcome Instructor');
            }

            return redirect()->route('user.dashboard')
                ->with('success', 'Login successful');
        }

        return back()->withErrors([
            'email' => 'Invalid login credentials or account not active.',
        ])->withInput();
    }

    // ================= ADMIN LOGIN =================
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['status'] = 'active';

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome Administrator');
        }

        return back()->withErrors([
            'email' => 'Invalid admin credentials or account inactive.',
        ])->withInput();
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // confirms with password_confirmation
            'phone' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($request) {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'role' => 'student',                     // default role
                'status' => 'active',                    // default status
                'avatar' => 'user.png',                // static avatar stored in public/images/avatar.png
            ]);

            // Optional: login the user after registration
            Auth::login($user);
            
            // Create Instructor Profile
            StudentProfile::create([
                'user_id' => $user->id,
            ]);

        });


        return redirect()->route('user.dashboard')->with('success', 'Registration successful!');
    
    }


    // ================= LOGOUT =================
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::check() && Auth::user()->role === 'instructor') {
            Auth::logout(); // default web guard logs out instructors
        } elseif (Auth::check()) {
            Auth::logout(); // default web guard logs out normal users
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logged out successfully');
    }
    
}
