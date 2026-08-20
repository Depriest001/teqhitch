<?php

namespace App\Http\Requests;

use App\Models\SiwesApplication;
use App\Models\SiwesTrack;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSiwesApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Step 1 — Personal Information
            'full_name'        => ['required', 'string', 'max:150'],
            'gender'           => ['required', Rule::in(['male', 'female'])],
            'date_of_birth'    => ['required', 'date', 'before:today'],
            'phone'            => ['required', 'regex:/^(\+234|0)[789][01]\d{8}$/'],
            'email'            => [
                'required', 'email', 'max:150',
                Rule::unique('siwes_applications', 'email')
                    ->where('level', $this->input('level'))
                    ->where('payment_status', 'paid'),
            ],
            'address'          => ['required', 'string', 'max:255'],

            // Step 2 — Academic Information
            'institution'         => ['required', 'string', 'max:150'],
            'department'          => ['required', 'string', 'max:150'],
            'course_of_study'     => ['required', 'string', 'max:150'],
            'level'               => ['required', 'string', 'max:20'],
            'matric_number'       => [
                'required', 'string', 'max:50',
                Rule::unique('siwes_applications', 'matric_number')
                    ->where('level', $this->input('level'))
                    ->where('payment_status', 'paid'),
            ],
            'siwes_start_date'    => ['required', 'date'],
            'siwes_end_date'      => ['required', 'date', 'after:siwes_start_date'],
            'letter_ref_number'   => ['nullable', 'string', 'max:100'],

            // Step 3 — Placement Preference
            'track_id'              => ['required', 'integer', Rule::exists('siwes_tracks', 'id')],
            'preferred_start_date'  => ['required', 'date', 'after_or_equal:today'],
            'mode'                  => ['required', Rule::in(['physical', 'hybrid'])],
            'amount'                => ['required', 'numeric', 'min:10000'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex'          => 'Enter a valid Nigerian phone number, e.g. 08012345678 or +2348012345678.',
            'email.unique'         => 'You have already submitted an application for this level.',
            'matric_number.unique' => 'An application already exists for this matric number at this level.',
        ];
    }
}