<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequst extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name"         => "required|string|max:255",
            "ISBN"         => "required|string|max:255|unique:books,ISBN",
            "author"       => "required|string|max:255",
            "publisher"    => "required|string|max:255",
            "publish_date" => "required|date",
            "category_id"  => "required|exists:categories,id"
        ];
    }
}
