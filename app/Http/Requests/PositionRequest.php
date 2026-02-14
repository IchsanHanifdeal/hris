<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:positions,name',
            'basic_salary' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('position.name')]),
            'basic_salary.required' => __('validation.required', ['attribute' => __('position.basic_salary')]),
            'name.unique' => __('validation.unique', ['attribute' => __('position.name')]),
            'basic_salary.numeric' => __('validation.numeric', ['attribute' => __('position.basic_salary')]),
        ];
    }
}
