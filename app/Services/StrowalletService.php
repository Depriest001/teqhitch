<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Thin wrapper around Strowallet's Virtual Bank Account API.
 *
 * Docs: https://strowallet.readme.io/reference/create-virtual-bank-account
 *
 * NOTE: Strowallet's public docs confirm the request body but do not publish
 * a fixed response schema. This service normalises a few likely key names
 * (accountNumber/account_number, bankName/bank_name, etc). Log the raw
 * response the first time you call this in sandbox mode and adjust
 * extractAccountDetails() to match exactly what comes back for your account.
 */
class StrowalletService
{
    protected string $baseUrl = 'https://strowallet.com/api/virtual-bank';

    /**
     * Create a dedicated virtual account a customer can pay the SIWES
     * placement fee into.
     *
     * @param array{email:string,account_name:string,phone:string} $data
     * @return array{raw: array, account_number: ?string, bank_name: ?string, account_name: ?string}
     */
    public function createVirtualAccount(array $data): array
    {
        $bank = config('services.strowallet.bank') ?: 'default';
        $endpoint = $bank === 'default'
            ? "{$this->baseUrl}/new-customer/"
            : "{$this->baseUrl}/{$bank}";

        $response = Http::asForm()->post($endpoint, [
            'public_key'   => config('services.strowallet.public_key'),
            'email'        => $data['email'],
            'account_name' => $data['account_name'],
            'phone'        => $data['phone'],
            'webhook_url'  => config('services.strowallet.webhook_url'),
            'mode'         => config('services.strowallet.API_mode', 'sandbox'),
        ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Strowallet virtual account request failed ('.$response->status().'): '.$response->body()
            );
        }

        $body = $response->json() ?? [];

        return array_merge(
            ['raw' => $body],
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
                ?? null,
        ];
    }
}