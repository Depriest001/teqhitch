<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterMail;

class SubscriberController extends Controller
{
    /**
     * Store a new subscriber
     */
    public function store(Request $request)
    {
        // 1. Validate email
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        DB::transaction(function () use ($request) {

            // 2. Create subscriber with verification token (double opt-in)
            $subscriber = Subscriber::create([
                'email' => $request->email,
                'token' => Str::random(40),
                'is_active' => false, // will be activated after verification
            ]);

            // 3. Send verification email
            $verificationLink = route('subscriber.verify', ['token' => $subscriber->token]);

            $subject = 'Confirm Your Newsletter Subscription';

            Mail::to($subscriber->email)
                ->send(new NewsletterMail($subject, $verificationLink));
        });
        return redirect()->back()->with('success', 'Subscription created! Please check your email to confirm your subscription.');
    }

    /**
     * Verify subscriber (activate)
     */
    public function verify($token)
    {
        $subscriber = Subscriber::where('token', $token)->firstOrFail();

        $subscriber->activate();

        return redirect('/thank-you')->with('message', 'Your subscription has been confirmed!');
    }

    /**
     * Unsubscribe
     */
    public function unsubscribe($email)
    {
        $subscriber = Subscriber::where('email', $email)->firstOrFail();
        $subscriber->deactivate();

        return redirect('/unsubscribe')->with('message', 'You have successfully unsubscribed.');
    }
}
