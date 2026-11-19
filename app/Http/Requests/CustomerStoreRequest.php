<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name"         => "required|string|max:255",
            "phone_number" => "required|string|max:10|unique:customers,phone_number",
            "address"      => "nullable|string|max:255",
            "password"     => "required|min:8|string"
        ];
    }
}
