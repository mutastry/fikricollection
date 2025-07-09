<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->cartItems()->count() > 0;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name'     => 'required|string|max:255',
            'customer_email'    => 'required|email|max:255',
            'customer_phone'    => 'required|string|max:20',
            'customer_address'  => 'required|string|max:500',
            'notes'             => 'nullable|string|max:500',
        ];
    }
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Full name is required.',
            'customer_email.required' => 'Email address is required.',
            'customer_email.email' => 'Please enter a valid email address.',
            'customer_phone.required' => 'Phone number is required.',
            'customer_address.required' => 'Address is required for pickup coordination.',
        ];
    }
}
