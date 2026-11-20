<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequst extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name"         => "sometimes|required|string|max:255",
            "ISBN"         => "sometimes|required|string|max:255|unique:books,ISBN",
            "author"       => "sometimes|required|string|max:255",
            "publisher"    => "sometimes|required|string|max:255",
            "publish_date" => "sometimes|required|date",
            "category_id"  => "sometimes|required|exists:categories,id"
        ];
    }
}
