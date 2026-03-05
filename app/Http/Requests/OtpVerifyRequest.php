<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OtpVerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'otp' => ['required', 'string', 'digits:6'],
        ];
    }


    public function messages(): array
    {
        return [
            'otp.required' => 'OTP Code is required.',
            'otp.string' => 'OTP Code Must be a string.',
            'otp.digits' => 'OTP Code Must be exactly 6 digits.',
        ];
    }
}