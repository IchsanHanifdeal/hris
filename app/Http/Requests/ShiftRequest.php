<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShiftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('shifts', 'name')->ignore($this->shift) 
            ],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('shift.modal.label_name'),
            'start_time' => __('shift.modal.label_start'),
            'end_time' => __('shift.modal.label_end'),
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => __('validation.unique', ['attribute' => __('shift.modal.label_name')]),
        ];
    }
}