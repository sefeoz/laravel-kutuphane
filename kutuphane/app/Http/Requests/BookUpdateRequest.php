<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === \App\Enums\UserRole::Admin->value;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "book_name" => "required|string|max:255",
            "author_id" => "required|exists:authors,id",
            "ISBN" => "required|string|max:255",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "stores" => "nullable|array",
            "stores.*.attach" => "nullable|boolean",
            "stores.*.price" => "nullable|numeric|min:0",
            "stores.*.stock" => "nullable|integer|min:0",
            "stores.*.is_active" => "nullable|boolean",
        ];
    }
}
