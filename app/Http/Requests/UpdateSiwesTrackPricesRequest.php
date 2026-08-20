<?php

namespace App\Http\Requests;

use App\Models\SiwesTrackPrice;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiwesTrackPricesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // wrap this route in your auth/admin middleware — see README
    }

    public function rules(): array
    {
        return [
            'prices'   => ['required', 'array'],
            'prices.*' => ['required', 'numeric', 'min:'.SiwesTrackPrice::MINIMUM_AMOUNT],
        ];
    }

    public function messages(): array
    {
        return [
            'prices.*.min' => 'Each track must cost at least ₦'.number_format(SiwesTrackPrice::MINIMUM_AMOUNT).'.',
        ];
    }
}
