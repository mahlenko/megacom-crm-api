<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:\App\Models\User,email'],
            'password' => ['required', 'min:8'],
            'external_user_id' => [env('EXTERNAL_APP') ? 'required' : 'nullable', 'numeric']
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Пользователь с таким email уже есть.'
        ];
    }
}
