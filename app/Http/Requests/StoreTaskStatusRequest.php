<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskStatusRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255', 'unique:task_statuses,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => __('request.max'),
            'name.unique' => __('request.unique_task_status'),
        ];
    }
}
