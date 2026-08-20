<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreSiwesApplicationRequest;
use App\Models\SiwesApplication;
use App\Models\SiwesTrack;
use App\Models\Students;
use App\Services\StrowalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class SiwesApplicationController extends Controller
{
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
    // public function store(StoreSiwesApplicationRequest $request, StrowalletService $strowallet)
    // {
    //     $data = $request->validated();

    //     $track = SiwesTrack::findOrFail($data['track_id']);

    //     do {
    //         $reference = 'siwes'.date('Y').'_'.substr(hash('sha256', Str::uuid().microtime()), 0, 16);
    //     } while (SiwesApplication::where('reference', $reference)->exists());

    //     $data['reference'] = $reference;

    //     try {
    //         $application = DB::transaction(function () use ($data, $strowallet) {
    //             $application = SiwesApplication::create($data);

    //             $result = $strowallet->createVirtualAccount([
    //                 'email'        => $application->email,
    //                 'account_name' => $application->full_name,
    //                 'phone'        => $application->phone,
    //             ]);

    //             $application->update([
    //                 'virtual_account_number'    => $result['account_number'],
    //                 'virtual_account_bank'      => $result['bank_name'],
    //                 'virtual_account_name'      => $result['account_name'] ?? $application->full_name,
    //                 'strowallet_customer_email' => $application->email,
    //                 'strowallet_raw_response'   => $result['raw'],
    //             ]);

    //             return $application;
    //         });
    //     } catch (Throwable $e) {
    //         Log::error('Strowallet virtual account creation failed', [
    //             'email'   => $data['email'],
    //             'message' => $e->getMessage(),
    //         ]);

    //         return back()
    //             ->withInput()
    //             ->withErrors(['payment' => 'We could not generate a payment account right now. Please try submitting again in a moment.']);
    //     }

    //     // Deliberately outside the transaction above, in its own try/catch.
    //     // The application + payment account are the critical path and are
    //     // already committed by this point. If student account provisioning
    //     // fails here, the applicant should still reach their payment page —
    //     // a missing Student row is recoverable later; an orphaned Strowallet
    //     // virtual account with a rolled-back application is not.
    //     try {
    //         $student = Students::createFromSiwesApplication($application);

    //         if ($student->wasRecentlyCreated) {
    //             $student->sendEmailVerificationNotification();
    //         }
    //     } catch (Throwable $e) {
    //         Log::error('Student account creation failed after SIWES submission', [
    //             'reference' => $application->reference,
    //             'message'   => $e->getMessage(),
    //         ]);
    //     }

    //     return redirect()->route('siwes.payment', $application->reference);
    // }
    public function store(StoreSiwesApplicationRequest $request, StrowalletService $strowallet)
    {
        $data = $request->validated();

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

                $result = $strowallet->createVirtualAccount([
                    'email'        => $application->email,
                    'account_name' => $application->full_name,
                    'phone'        => $application->phone,
                ]);

                $application->update([
                    'virtual_account_number'    => $result['account_number'],
                    'virtual_account_bank'      => $result['bank_name'],
                    'virtual_account_name'      => $result['account_name'] ?? $application->full_name,
                    'strowallet_customer_email' => $application->email,
                    'strowallet_raw_response'   => $result['raw'],
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

        try {
            $student = Students::createFromSiwesApplication($application);

            if ($student->wasRecentlyCreated) {
                $student->sendEmailVerificationNotification();
            }
        } catch (Throwable $e) {
            Log::error('Student account creation failed after SIWES submission', [
                'reference' => $application->reference,
                'message'   => $e->getMessage(),
            ]);
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
     * Confirmation screen shown once the webhook marks payment as received.
     */
    public function success(SiwesApplication $application)
    {
        if ($application->payment_status !== 'paid') {
            return redirect()->route('siwes.payment', $application->reference);
        }

        return view('siwes.payment-success', compact('application'));
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

        $application->update(['payment_status' => 'paid']);

        return response()->json(['status' => 'ok']);
    }
}