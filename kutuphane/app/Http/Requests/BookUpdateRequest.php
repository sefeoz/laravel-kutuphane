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
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "kitap_adi" => "required|string|max:255",
            "yazar_id" => "required|exists:yazarlar,id",
            "ISBN" => "required|string|max:255",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "stores" => "nullable|array",
            "stores.*" => "exists:stores,id",
            "prices.*" => "nullable|numeric|min:0",
            "stock.*" => "nullable|integer|min:0",
            "is_active.*" => "nullable|boolean",
        ];
    }
}
