<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'nullable|string|max:255|unique:users,username',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255|unique:users,email',
            'latest_profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
