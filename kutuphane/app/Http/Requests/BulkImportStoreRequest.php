<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkImportStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Routes already use 'auth' and 'admin' middleware; keep consistent here
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
            'file' => 'required|file|mimes:csv,xlsx,xls|max:5120',
            'import_type' => 'required|in:author,book',
            'options' => 'sometimes|array',
        ];
    }
}

