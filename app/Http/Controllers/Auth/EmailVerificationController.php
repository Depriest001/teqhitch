<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Verified;

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
        // Wrap in DB transaction to ensure atomic operation
        DB::transaction(function () use ($request) {

            // Mark the user as verified
            $request->fulfill();

            // Fire Verified event (optional, triggers listeners)
            event(new Verified($request->user()));

            // Queue welcome email **only after successful commit**
            Mail::to($request->user()->email)
                ->send(new WelcomeMail($request->user()));

        }, 3); // retry 3 times in case of deadlock
        
        activity_log(
            'verify_email',
            'authentication',
            [
                'status' => 'success',
                'description' => 'You verified email address'
            ]
        );

        // Redirect the user based on role
        return $this->redirectByRole($request->user());
    }

    public function resend(Request $request)
    {
        if ($request->user()) {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('success', 'Verification link sent!');
        }

        return redirect('/login');
    }

    protected function redirectByRole($user)
    {
        return $user->role === 'staff'
            ? redirect()->route('staff.dashboard')
            : redirect()->route('user.dashboard');
    }
}