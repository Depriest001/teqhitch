<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Notifications\ResetPasswordNotification;

class PasswordResetController extends Controller
{

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email.']);
        }

        // Generate password reset token
        $token = Password::createToken($user);

        // Send the reset notification (immediately)
        $user->notify(new ResetPasswordNotification($token, $user));

        return back()->with('status', 'We have emailed your password reset link!');
    }

    // Show reset form
    public function showResetForm(Request $request, $token)
    {
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        $remainingSeconds = 0;

        if ($record) {

            $expireMinutes = config('auth.passwords.users.expire');

            $created = Carbon::parse($record->created_at);

            $expiresAt = $created->copy()->addMinutes($expireMinutes);

            $remainingSeconds = max(
                0,
                $expiresAt->timestamp - now()->timestamp
            );
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
            'remainingSeconds' => $remainingSeconds
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {

                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                // 🔥 Log the user in immediately
                Auth::login($user);

                $request->session()->regenerate();
            }
        );

        if ($status === Password::PASSWORD_RESET) {

            $user = Auth::user();

            activity_log(
                'password_reset',
                'authentication',
                [
                    'status' => 'success',
                    'description' => 'You reset account password'
                ]
            );
            // Optional: email verification check
            if (! $user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            return $user->role === 'instructor'
                ? redirect()->route('staff.dashboard')
                : redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'email' => [__($status)],
        ]);
    }
}