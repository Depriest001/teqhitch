<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    /**
    * redirecting to google Login
    */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Check existing user
        $user = User::where('google_id', $googleUser->id)
                    ->orWhere('email', $googleUser->email)
                    ->first();

        if ($user) {
            // Update google_id if missing
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->id
                ]);
            }
        } else {
            // Create new user
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'role' => 'student', // default
                'status' => 'active',
                'password' => Hash::make(uniqid()),
            ]);
            
            event(new Registered($user));
        }

        // ✅ Ensure student profile exists ONLY if role is student
        if ($user->role === 'student') {
            StudentProfile::firstOrCreate(
                ['user_id' => $user->id], // prevent duplicates
                [
                    'address' => null,
                    'institution' => null,
                ]
            );
        }

        Auth::login($user);

        return $user->role === 'instructor'
            ? redirect()->route('staff.dashboard')
            : redirect()->route('user.dashboard');
    }
}