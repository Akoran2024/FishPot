<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check(); // Only authenticated users can create orders
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'total' => ['required', 'numeric', 'min:0'],
            'status' => ['sometimes', 'string', 'in:pending,accepted,shipped,completed,cancelled'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'string', 'in:online_payment,cash_on_delivery'],

            // Shipping details fields from frontend (always required for now)
            'shipping_address' => ['required', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:255'],
            'shipping_state' => ['required', 'string', 'max:255'],
            'shipping_zip_code' => ['required', 'string', 'max:255'],
            'shipping_country' => ['required', 'string', 'max:255'],

            // Simulated credit card details (required only if payment_method is online_payment)
            'card_number' => ['required_if:payment_method,online_payment', 'string', 'digits_between:13,16'],
            'card_expiry' => ['required_if:payment_method,online_payment', 'string', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'], // MM/YY format
            'card_cvc' => ['required_if:payment_method,online_payment', 'string', 'digits_between:3,4'],
        ];
    }
}
