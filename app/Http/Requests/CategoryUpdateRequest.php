<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name"    => "sometimes|required|string|max:255",
            "details" => "sometimes|required|string|min:10"
        ];
    }
}
