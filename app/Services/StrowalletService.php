<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use RuntimeException;

/**
 * Thin wrapper around Strowallet's Dynamic Virtual Account API.
 *
 * Docs: https://strowallet.readme.io/reference/dynamic-virtual-acct
 *
 * Unlike the static/reusable virtual-bank-account endpoint, a dynamic
 * account is scoped to a single amount and expires 30 minutes after
 * creation — the right shape for "pay this exact placement fee", since
 * the account itself enforces the amount rather than relying on the
 * payer to type the right figure into a reusable account.
 *
 * NOTE: Strowallet's public docs confirm the request params but do not
 * publish a fixed response schema. This service normalises a few likely
 * key names (accountNumber/account_number, bankName/bank_name, etc). Log
 * the raw response the first time you call this in sandbox mode and
 * adjust extractAccountDetails() to match exactly what comes back for
 * your account.
 */
class StrowalletService
{
    protected string $dynamicAccountUrl = 'https://strowallet.com/api/virtual-bank/dynamic-account/';

    /** How long Strowallet says a dynamic account stays valid for. */
    protected int $expiresInMinutes = 30;

    /**
     * Create a one-time virtual account scoped to a specific amount —
     * e.g. the SIWES placement fee the applicant chose to pay. The
     * account expires automatically after ~30 minutes.
     *
     * @param array{email:string,customer_name:string,amount:int|float|string} $data
     * @return array{raw: array, account_number: ?string, bank_name: ?string, account_name: ?string, amount: string, expires_in_minutes: int}
     */
    public function createDynamicVirtualAccount(array $data): array
    {
        foreach (['email', 'customer_name', 'amount'] as $required) {
            if (empty($data[$required])) {
                throw new InvalidArgumentException("StrowalletService::createDynamicVirtualAccount requires '{$required}'.");
            }
        }

        // Strowallet's docs list these as query params on the POST request
        // (matching the pattern used elsewhere in their API), so they're
        // sent as a query string rather than a form/JSON body.
        $response = Http::post($this->dynamicAccountUrl, [
            'public_key'   => config('services.strowallet.public_key'),
            'email'        => $data['email'],
            'customerName' => $data['customer_name'],
            'amount'       => (string) $data['amount'],
            'mode'         => config('services.strowallet.API_mode', 'sandbox'),
        ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Strowallet dynamic virtual account request failed ('.$response->status().'): '.$response->body()
            );
        }

        $body = $response->json() ?? [];

        return array_merge(
            [
                'raw' => $body,
                'amount' => (string) $data['amount'],
                'expires_in_minutes' => $this->expiresInMinutes,
            ],
            $this->extractAccountDetails($body)
        );
    }

    /**
     * Pull account number / bank name / account name out of whatever shape
     * Strowallet returns. Adjust the candidate keys once you've seen a real
     * response in your Strowallet dashboard logs.
     */
    protected function extractAccountDetails(array $body): array
    {
        $payload = $body['response'] ?? $body['data'] ?? $body;

        return [
            'account_number' => $payload['accountNumber']
                ?? $payload['account_number']
                ?? null,
            'bank_name' => $payload['bankName']
                ?? $payload['bank_name']
                ?? $payload['bank']
                ?? null,
            'account_name' => $payload['accountName']
                ?? $payload['account_name']
                ?? $payload['customerName']
                ?? null,
        ];
    }
}