<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;

class TaskCreateRequest extends FormRequest
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
            'title' => ['required', 'max:120'],
            'description' => ['required', 'max:1000'],
            'date_begin' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:date_end'],
            'date_end' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:date_begin'],
            'group_id' => ['required_without_all:group_id,users_id', 'numeric'],
            'users_id' => ['required_without_all:group_id,users_id', 'exists:App\Models\Users\User,id'],
            'require_report' => ['nullable', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'users_id.exists' => 'Одно или несколько значений для :attribute некорректно.'
        ];
    }
}
