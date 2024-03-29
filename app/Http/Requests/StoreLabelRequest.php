<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabelRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'unique:labels,name'],
            'description' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => __('request.unique_label'),
            'name.max' => __('request.max'),
        ];
    }
}
