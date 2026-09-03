<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Auth\SiwesOtpController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreSiwesApplicationRequest;
use App\Mail\SiwesWelcomeMail;
use App\Models\SiwesApplication;
use App\Models\SiwesTrack;
use App\Models\Students;
use App\Models\Payment;
use App\Services\StrowalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Throwable;

class SiwesApplicationController extends Controller
{
    /**
     * Show the SIWES landing page.
     */
    public function index()
    {
        return view('siwes.index', [
            'tracks' => SiwesTrack::orderBy('name')->get(['id', 'name', 'price']),
        ]);
    }

    /**
     * Show the multi-step application form.
     */
    public function create()
    {
        return view('siwes.apply', [
            'tracks' => SiwesTrack::orderBy('name')->get(['id', 'name', 'price']),
        ]);
    }

    /**
     * Validate all steps, persist the application, then generate a
     * Strowallet virtual account for the placement fee.
     */
    public function store(StoreSiwesApplicationRequest $request, StrowalletService $strowallet)
    {
        $data = $request->validated();

        // The client's hidden `email_verified=1` input must never be trusted
        // on its own — re-check against the real source of truth here.
        if (! SiwesOtpController::isRecentlyVerified($data['email'])) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Please re-verify your email before submitting.']);
        }

        $track = SiwesTrack::findOrFail($data['track_id']);

        $existing = SiwesApplication::where('email', $data['email'])
            ->where('level', $data['level'])
            ->where('payment_status', '!=', 'paid')
            ->latest()
            ->first();

        if ($existing) {
            $reference = $existing->reference; // keep the same reference across retries
        } else {
            do {
                $reference = 'siwes'.date('Y').'_'.substr(hash('sha256', Str::uuid().microtime()), 0, 16);
            } while (SiwesApplication::where('reference', $reference)->exists());
        }

        $data['reference'] = $reference;

        try {
            $application = DB::transaction(function () use ($data, $strowallet, $existing) {
                $application = $existing
                    ? tap($existing)->update($data)
                    : SiwesApplication::create($data);

                $result = $strowallet->createDynamicVirtualAccount([
                    'email' => $application->email,
                    'customer_name' => $application->full_name,
                    'amount' => $application->amount,
                ]);

                if (empty($result['account_number']) || empty($result['bank_name'])) {
                    Log::error('Strowallet returned an incomplete response', [
                        'email' => $application->email,
                        'result' => $result,
                    ]);

                    throw new \RuntimeException('Strowallet did not return a valid virtual account.');
                }

                $application->update([
                    'virtual_account_number' => $result['account_number'],
                    'virtual_account_bank'   => $result['bank_name'],
                    'virtual_account_name'   => $result['account_name'] ?? $application->full_name,
                    'strowallet_customer_email' => $application->email,
                    'strowallet_raw_response' => $result['raw'] ?? $result,
                    // Persisted so the payment page's countdown ring reflects
                    // the real expiry Strowallet granted, not just an assumed
                    // 30 minutes from row-creation time.
                    'virtual_account_expires_at' => now()->addMinutes($result['expires_in_minutes'] ?? 30),
                ]);

                return $application;
            });
        } catch (Throwable $e) {
            Log::error('Strowallet virtual account creation failed', [
                'email'   => $data['email'],
                'message' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['payment' => 'We could not generate a payment account right now. Please try submitting again in a moment.']);
        }

        // Student + Payment creation share one transaction: if either step
        // fails, both roll back together instead of leaving an orphaned
        // student row with no matching Payment.
        try {
            DB::transaction(function () use ($application, $track) {
                $password = Str::password(12);
                session(['student_password' => $password]);

                // The webhook that confirms payment is a separate,
                // server-to-server request from Strowallet with no access
                // to this session — cache the plaintext password so
                // webhook() can retrieve it once (and only once, via
                // Cache::pull) to send the welcome email at the moment
                // payment is actually confirmed.
                Cache::put(
                    'siwes_pending_credentials:'.$application->reference,
                    $password,
                    now()->addHours(2)
                );

                $student = Students::createFromSiwesApplication($application, $password);

                Payment::updateOrCreate(
                    [
                        'student_id'   => $student->id,
                        'payable_type' => SiwesTrack::class,
                        'payable_id'   => $track->id,
                    ],
                    [
                        'amount'    => $application->amount, // what the applicant actually chose to pay — may exceed $track->price
                        'reference' => $application->reference,
                        'status'    => 'pending', // flipped to 'success' by webhook() once the transfer is confirmed — never set here
                        'meta'      => [
                            'email_verified_at' => now()->toIso8601String(),
                            'strowallet_raw_response' => $application->strowallet_raw_response,
                        ],
                    ]
                );
            });
        } catch (Throwable $e) {
            Log::error('Student/payment record creation failed after SIWES submission', [
                'reference' => $application->reference,
                'message'   => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['payment' => 'Your application was saved but we could not finish setting up your account. Please contact the academy with reference '.$application->reference.'.']);
        }

        return redirect()->route('siwes.payment', $application->reference);
    }

    /**
     * Show the "pay into this account" screen after a successful submission.
     * If payment already landed, skip straight to the success page.
     */
    public function payment(SiwesApplication $application)
    {
        if ($application->payment_status === 'paid') {
            return redirect()->route('siwes.payment.success', $application->reference);
        }

        return view('siwes.payment', compact('application'));
    }

    /**
     * Called once the webhook has confirmed payment. Logs the student in
     * and sends them straight to their dashboard — no intermediate
     * "payment successful" page.
     */
    public function success(SiwesApplication $application)
    {
        if ($application->payment_status !== 'paid') {
            return redirect()->route('siwes.payment', $application->reference);
        }

        // Match the normal login() flow exactly: that uses the default
        // guard (Auth::attempt() / Auth::user()), not a named 'user' guard.
        // Logging into a different guard here satisfied nothing the rest
        // of the app checks, which is why this was bouncing to /login.
        if (! Auth::check()) {
            $student = Students::where('email', $application->email)->first();

            if (! $student) {
                Log::error('SIWES success: payment confirmed but no matching student found', [
                    'reference' => $application->reference,
                    'email'     => $application->email,
                ]);

                return redirect()->route('login')
                    ->withErrors(['email' => 'Your payment was received, but we could not sign you in automatically. Please log in with the credentials that were emailed to you.']);
            }

            // login() additionally requires status === 'active' (via the
            // 'status' credential passed into Auth::attempt) and a verified
            // email before letting someone reach the dashboard. Auth::login()
            // bypasses both of those checks, so make sure
            // Students::createFromSiwesApplication() already sets
            // status = 'active' and email_verified_at (the OTP step already
            // confirmed the email — carry that over) — otherwise this
            // student gets logged in here but can fail equivalent checks
            // anywhere else in the app that gate on those same fields.
            Auth::login($student, true);
            request()->session()->regenerate();

            // activity_log(
            //     'login',
            //     'authentication',
            //     [
            //         'role' => 'User',
            //         'status' => 'success',
            //         'description' => 'User logged in automatically after SIWES payment confirmation',
            //     ]
            // );
        }

        return redirect()->route('student.dashboard');
    }

    /**
     * Refresh the Strowallet dynamic virtual account for an existing,
     * unpaid application whose previous account has expired (Strowallet
     * dynamic accounts are only valid for ~30 minutes). Updates both
     * SiwesApplication and the matching Payment row.
     *
     * Deliberately bypasses StoreSiwesApplicationRequest entirely — the
     * applicant isn't submitting a new application here, just requesting a
     * fresh payment account for one that already exists. Routing this
     * through store() instead is what was triggering the
     * "already submitted"/"already exists for this matric number" errors:
     * that validation is correctly guarding against duplicate applications,
     * it just isn't the right path for "my account expired, give me a new
     * one".
     */
    public function regenerate(SiwesApplication $application, StrowalletService $strowallet)
    {
        if ($application->payment_status === 'paid') {
            return redirect()->route('siwes.payment.success', $application->reference);
        }

        try {
            DB::transaction(function () use ($application, $strowallet) {
                $result = $strowallet->createDynamicVirtualAccount([
                    'email' => $application->email,
                    'customer_name' => $application->full_name,
                    'amount' => $application->amount,
                ]);

                if (empty($result['account_number']) || empty($result['bank_name'])) {
                    Log::error('Strowallet returned an incomplete response while regenerating', [
                        'reference' => $application->reference,
                        'result'    => $result,
                    ]);

                    throw new \RuntimeException('Strowallet did not return a valid virtual account.');
                }

                $application->update([
                    'virtual_account_number' => $result['account_number'],
                    'virtual_account_bank'   => $result['bank_name'],
                    'virtual_account_name'   => $result['account_name'] ?? $application->full_name,
                    'strowallet_raw_response' => $result['raw'] ?? $result,
                    'virtual_account_expires_at' => now()->addMinutes($result['expires_in_minutes'] ?? 30),
                ]);

                // Keep Payment in step with the fresh account rather than
                // leaving it referencing the expired attempt's raw response.
                $payment = Payment::where('reference', $application->reference)->first();

                if ($payment) {
                    $payment->update([
                        'status' => 'pending', // in case it had drifted to anything else; regeneration always resets to awaiting payment
                        'amount' => $application->amount,
                        'meta'   => array_merge($payment->meta ?? [], [
                            'strowallet_raw_response' => $result['raw'] ?? $result,
                            'regenerated_at' => now()->toIso8601String(),
                        ]),
                    ]);
                } else {
                    Log::warning('Regenerate: no matching Payment row found for reference', [
                        'reference' => $application->reference,
                    ]);
                }
            });
        } catch (Throwable $e) {
            Log::error('Strowallet virtual account regeneration failed', [
                'reference' => $application->reference,
                'message'   => $e->getMessage(),
            ]);

            return back()->withErrors(['payment' => 'We could not generate a new payment account right now. Please try again in a moment.']);
        }

        return redirect()->route('siwes.payment', $application->reference);
    }

    /**
     * Polled by the payment page via fetch() to check whether the webhook
     * has confirmed payment yet.
     */
    public function status(SiwesApplication $application)
    {
        return response()->json([
            'status' => $application->payment_status,
        ]);
    }

    /**
     * Strowallet webhook — payment notification for the virtual account.
     * Route MUST be excluded from CSRF verification (see routes/web.php).
     *
     * NOTE: Strowallet's docs don't publish a signature-verification scheme
     * at the time of writing. If they add a signing secret/header, verify it
     * here before trusting the payload.
     */
    public function webhook(Request $request)
    {
        Log::info('Strowallet webhook received', $request->all());

        $accountNumber = $request->input('accountNumber') ?? $request->input('account_number');
        $reference = $request->input('reference') ?? $request->input('narration');

        $application = SiwesApplication::where('virtual_account_number', $accountNumber)->first()
            ?? ($reference ? SiwesApplication::where('reference', $reference)->first() : null);

        if (! $application) {
            Log::warning('Strowallet webhook: no matching application found', $request->all());
            return response()->json(['status' => 'ignored'], 200);
        }

        // Webhooks can arrive more than once for the same event — guard
        // against double-processing rather than assuming exactly-once
        // delivery.
        if ($application->payment_status === 'paid') {
            return response()->json(['status' => 'already_processed']);
        }

        DB::transaction(function () use ($application, $request) {
            $application->update(['payment_status' => 'paid']);

            // This was the actual bug: only SiwesApplication.payment_status
            // was ever being updated here. The Payment row created in
            // store() was left at 'pending' forever, even after the
            // application itself correctly flipped to 'paid'.
            $payment = Payment::where('reference', $application->reference)->first();

            if (! $payment) {
                Log::error('Strowallet webhook: no matching Payment row for reference', [
                    'reference' => $application->reference,
                ]);
                return;
            }

            $payment->update([
                'status'  => 'success',
                'paid_at' => now(),
                'meta'    => array_merge($payment->meta ?? [], [
                    'webhook_payload' => $request->all(),
                    'confirmed_at' => now()->toIso8601String(),
                ]),
            ]);
        });

        // Sent outside the DB transaction so a slow mail server can't hold
        // a database lock open. Cache::pull() atomically fetches-and-deletes
        // the cached password, so this can only succeed once per
        // application no matter how many times the webhook fires — the
        // payment_status guard above is the first line of defense, this is
        // the second, and it's the one that actually prevents a duplicate
        // email even if that guard is ever bypassed by a race condition.
        $password = Cache::pull('siwes_pending_credentials:'.$application->reference);

        if ($password) {
            $student = Students::where('email', $application->email)->first();

            if ($student) {
                try {
                    Mail::to($student->email)->send(new SiwesWelcomeMail($student, $password));
                } catch (Throwable $e) {
                    // Don't fail the webhook over a mail delivery problem —
                    // payment is already confirmed and recorded regardless.
                    Log::error('SIWES welcome email failed to send', [
                        'reference' => $application->reference,
                        'message'   => $e->getMessage(),
                    ]);
                }
            } else {
                Log::error('SIWES webhook: password was cached but no matching student found', [
                    'reference' => $application->reference,
                    'email'     => $application->email,
                ]);
            }
        } else {
            // Expected on a genuine duplicate webhook delivery (password
            // already pulled and sent). If this fires on what should be the
            // *first* successful delivery, the 2-hour cache TTL in store()
            // may have expired before payment landed, or the student typed
            // into a very old, resurfaced payment page.
            Log::warning('SIWES webhook: no cached password found to email', [
                'reference' => $application->reference,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}