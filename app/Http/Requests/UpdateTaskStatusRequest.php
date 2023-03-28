<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'name' => ['required', 'max:255', "unique:task_statuses,name,{$this->task_status->id}"],
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
