<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $userId = $this->route('user'); // Route parameter'dan user ID'sini al
        return [
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email," . $userId,
            "password" => "nullable|string|min:8",
            "role" => "required|string|in:admin,user",
            "created_at" => "nullable|string|max:255",
            "updated_at" => "nullable|string|max:255",
        ];
    }
}
