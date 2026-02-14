<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeaveTypeRequest extends FormRequest
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
                Rule::unique('leave_types', 'name')->ignore($this->leave_type)
            ],
            'quota' => 'required|integer|min:0|max:12',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('leave-type.modal.label_name'),
            'quota' => __('leave-type.modal.label_days'),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('leave-type.modal.label_name')]),
            'name.unique' => __('validation.unique', ['attribute' => __('leave-type.modal.label_name')]),
            'quota.required' => __('validation.required', ['attribute' => __('leave-type.modal.label_days')]),
            'quota.integer' => __('validation.integer', ['attribute' => __('leave-type.modal.label_days')]),
            'quota.min' => __('validation.min.numeric', [
                'attribute' => __('leave-type.modal.label_days'), 
                'min' => 0
            ]),
        ];
    }
}