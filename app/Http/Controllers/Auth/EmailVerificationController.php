<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return $this->redirectByRole(auth()->user());
        }

        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return $this->redirectByRole($request->user());
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        // return back()->with('message', 'Verification link sent!');
        return back()->with('success', 'Verification link sent successfully!');
    }

    protected function redirectByRole($user)
    {
        return $user->role === 'staff'
            ? redirect()->route('staff.dashboard')
            : redirect()->route('user.dashboard');
    }
}