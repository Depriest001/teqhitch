<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasswordResetController extends Controller
{

    // Send reset link
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // Show reset form
    // public function showResetForm($token)
    // {
    //     return view('auth.reset-password', [
    //         'token' => $token,
    //         'email' => request('email')
    //     ]);
    // }
    public function showResetForm($token)
    {
        $record = DB::table('password_reset_tokens')
            ->where('token', hash('sha256', $token))
            ->first();

        $expireMinutes = config('auth.passwords.users.expire');

        $remainingSeconds = 0;

        if ($record) {

            // Force UTC because DB timestamps are stored in UTC
            $created = Carbon::parse($record->created_at, 'UTC');

            $expiresAt = $created->addMinutes($expireMinutes);

            $remainingSeconds = now('UTC')->lt($expiresAt)
                ? now('UTC')->diffInSeconds($expiresAt)
                : 0;
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => request('email'),
            'remainingSeconds' => $remainingSeconds
        ]);
    }

    // Handle reset
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

            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')
                ->with('success', 'Password reset successful. Please login.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}