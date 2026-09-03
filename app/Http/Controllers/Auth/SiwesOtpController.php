<?php

namespace App\Http\Controllers\Auth;

use App\Mail\OtpMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SiwesOtpController extends Controller
{
    /** How long a code stays valid. */
    protected int $codeTtlMinutes = 4320;

    /** Minimum gap between two sends for the same email. */
    protected int $resendCooldownSeconds = 30;

    /** How many wrong guesses are allowed before the code is invalidated. */
    protected int $maxAttempts = 5;

    /**
     * How long a successful verification is considered valid, server-side.
     * Must match (or exceed) whatever window the frontend advertises to
     * the user (currently 24h) — if these drift apart, a user can see
     * "verified" in the UI while store() silently rejects them.
     */
    protected int $verifiedTtlHours = 24;

    /**
     * Generate a code, cache its hash, and email it.
     * POST /siwes/otp/send  { email }
     */
    public function send(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first('email'),
            ], 422);
        }

        $email = strtolower(trim($request->input('email')));

        $cooldownKey = $this->cooldownCacheKey($email);
        if (Cache::has($cooldownKey)) {
            $retryAfter = Cache::get($cooldownKey) - now()->timestamp;

            return response()->json([
                'message' => 'Please wait before requesting another code.',
                'retry_after' => max($retryAfter, 0),
            ], 429);
        }

        $code = (string) random_int(100000, 999999);

        Cache::put($this->otpCacheKey($email), [
            'code_hash' => Hash::make($code),
            'attempts' => 0,
        ], now()->addMinutes($this->codeTtlMinutes));

        Cache::put($cooldownKey, now()->addSeconds($this->resendCooldownSeconds)->timestamp, $this->resendCooldownSeconds);

        try {
            Mail::to($email)->send(new \App\Mail\OtpMail(
                code: $code,
                expiresInMinutes: $this->codeTtlMinutes,
                subject: 'Your SIWES application verification code',
                heading: 'Verify your email',
                intro: 'Use the code below to confirm we can reach you for your SIWES / IT Placement application.'
            ));
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'We could not send the code. Please try again shortly.',
            ], 500);
        }

        return response()->json([
            'message' => 'Verification code sent.',
        ]);
    }

    /**
     * Compare a submitted code against the cached hash.
     * POST /siwes/otp/verify  { email, code }
     */
    public function verify(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
            'code' => ['required', 'digits:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $email = strtolower(trim($request->input('email')));
        $code = $request->input('code');

        $key = $this->otpCacheKey($email);
        $entry = Cache::get($key);

        if (! $entry) {
            return response()->json([
                'message' => 'That code has expired. Request a new one.',
            ], 422);
        }

        if ($entry['attempts'] >= $this->maxAttempts) {
            Cache::forget($key);

            return response()->json([
                'message' => 'Too many incorrect attempts. Request a new code.',
            ], 422);
        }

        if (! Hash::check($code, $entry['code_hash'])) {
            $entry['attempts']++;
            Cache::put($key, $entry, now()->addMinutes($this->codeTtlMinutes));

            return response()->json([
                'message' => 'That code doesn\'t match. Check it and try again.',
            ], 422);
        }

        Cache::forget($key);
        Cache::forget($this->cooldownCacheKey($email));

        // Mark this email verified for the full window (default 24h) so:
        //  - the store() endpoint can re-check it server-side before
        //    accepting the application (belt-and-braces alongside the
        //    client-side flag), and
        //  - a page reload after a failed submission (e.g. server-side
        //    validation errors on other fields) can restore "verified"
        //    from source of truth via status(), not just localStorage.
        Cache::put($this->verifiedCacheKey($email), now()->timestamp, now()->addHours($this->verifiedTtlHours));

        return response()->json([
            'message' => 'Email verified.',
        ]);
    }

    /**
     * Let the frontend (or a Blade controller) ask "is this email still
     * verified?" without re-sending or re-checking a code. Used to restore
     * verification state after a page reload — e.g. when the SIWES form
     * is redisplayed with validation errors and the in-progress draft in
     * localStorage may have been cleared or gone stale.
     * GET /siwes/otp/status?email=...
     */
    public function status(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'verified' => false,
                'message' => $validator->errors()->first('email'),
            ], 422);
        }

        $email = strtolower(trim($request->input('email')));

        return response()->json([
            'verified' => static::isRecentlyVerified($email),
        ]);
    }

    /**
     * Helper for the SIWES store() controller: check whether an email
     * was verified within the configured window before accepting the
     * application. Always re-check this server-side in store() — never
     * trust the client's hidden `email_verified` input on its own.
     */
    public static function isRecentlyVerified(string $email): bool
    {
        return Cache::has('siwes_otp_verified:' . strtolower(trim($email)));
    }

    protected function otpCacheKey(string $email): string
    {
        return 'siwes_otp:' . $email;
    }

    protected function cooldownCacheKey(string $email): string
    {
        return 'siwes_otp_cooldown:' . $email;
    }

    protected function verifiedCacheKey(string $email): string
    {
        return 'siwes_otp_verified:' . $email;
    }
}