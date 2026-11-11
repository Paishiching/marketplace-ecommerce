<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['nullable', 'string', 'max:150'],
            'phone' => ['required', 'string', 'regex:/^(\+?880|0)1[3-9]\d{8}$/'],
            'email' => ['nullable', 'email', 'max:150'],

            // সেভ করা ঠিকানা সিলেক্ট করলে এটা আসবে
            'shipping_address_id' => ['nullable', 'integer', 'exists:shipping_addresses,id'],

            // সেভ করা ঠিকানা না থাকলে নতুন ঠিকানার ফিল্ড বাধ্যতামূলক
            'address_line1' => ['required_without:shipping_address_id', 'nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city'          => ['required_without:shipping_address_id', 'nullable', 'string', 'max:100'],
            'postal_code'   => ['nullable', 'string', 'max:20'],

            'payment_method' => ['required', 'in:cod,sslcommerz,bank_deposit'],
            'deposit_date' => ['required_if:payment_method,bank_deposit', 'nullable', 'date', 'before_or_equal:today'],
            'depositor_bank' => ['required_if:payment_method,bank_deposit', 'nullable', 'string', 'max:150'],
            'depositor_branch' => ['required_if:payment_method,bank_deposit', 'nullable', 'string', 'max:150'],
            'deposit_type' => ['required_if:payment_method,bank_deposit', 'nullable', 'in:cash,cheque,bank_transfer'],
            'deposit_amount' => ['required_if:payment_method,bank_deposit', 'nullable', 'numeric', 'min:1', 'max:999999999'],
            'deposit_company_account' => ['required_if:payment_method,bank_deposit', 'nullable', 'string', 'max:190'],
            'deposit_bank_name' => ['required_if:payment_method,bank_deposit', 'nullable', 'string', 'max:150'],
            'deposit_company_name' => ['required_if:payment_method,bank_deposit', 'nullable', 'string', 'max:150'],
            'deposit_receipt_id' => ['nullable', 'string', 'max:190'],
            'deposit_attachment' => ['required_if:payment_method,bank_deposit', 'nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
            'deposit_remark' => ['nullable', 'string', 'max:1000'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Phone number is required for delivery.',
            'phone.regex'    => 'Please enter a valid Bangladeshi phone number (e.g. 01712345678).',
            'email.email'    => 'Please enter a valid email address.',

            'address_line1.required_without' => 'Delivery address is required.',
            'city.required_without'          => 'Please select your district.',

            'payment_method.required' => 'Please select a payment method.',
            'payment_method.in'       => 'Please select a valid payment method.',
        ];
    }
}
