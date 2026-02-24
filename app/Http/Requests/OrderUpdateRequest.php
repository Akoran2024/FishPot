<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check(); // Only authenticated users can update orders
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'total' => ['sometimes', 'numeric', 'min:0'], // 'total' is not always updated during shipping
            'status' => ['sometimes', 'string', 'in:pending,accepted,shipped,completed,cancelled'], // 'status' might be updated implicitly
            'items' => ['sometimes', 'array'],
            'items.*.id' => ['required_with:items', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required_with:items', 'integer', 'min:1'],

            // New shipping details fields
            'shipping_address' => ['required', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:255'],
            'shipping_state' => ['required', 'string', 'max:255'],
            'shipping_zip_code' => ['required', 'string', 'max:255'],
            'shipping_country' => ['required', 'string', 'max:255'],
            'tracking_number' => ['nullable', 'string', 'max:255'],
        ];
    }
}
