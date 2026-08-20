<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Students;
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

            if (! $user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            activity_log(
                'login',
                'authentication',
                [
                    'role' => 'User',
                    'status' => 'success',
                    'description' => 'User Logged in successfully'
                ]
            );

            return redirect()->route('student.dashboard');
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
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => ['required', 'email', 'max:150', Rule::unique('students', 'email')],
            'phone'     => ['required', 'string', 'max:20', Rule::unique('students', 'phone')],
            'password'  => ['required', 'string', 'min:8', 'confirmed'], // confirms with password_confirmation
        ]);

        $student = DB::transaction(function () use ($validated) {
            return Student::create([
                'student_id' => Student::nextStudentId(),
                'full_name'  => $validated['full_name'],
                'email'      => $validated['email'],
                'phone'      => $validated['phone'],
                'password'   => Hash::make($validated['password']),
                'study_mode' => 'onsite', // swap for a form field if registrants choose onsite/online themselves
                'status'     => 'active',
                'source'     => 'manual',
            ]);
        });

        $student->sendEmailVerificationNotification();

        Auth::guard('student')->login($student);

        activity_log('register', 'authentication', [
            'email'       => $student->email,
            'status'      => 'success',
            'description' => 'Student registered successfully',
        ]);

        return redirect()->route('verification.notice');
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
