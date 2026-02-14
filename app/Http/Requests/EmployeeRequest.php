<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->employee ? $this->employee->user_id : null;

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'locale' => ['required', Rule::in(['id', 'en'])],
            'gender' => 'required|in:male,female',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'address' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('employee.modal.label_name'),
            'email' => __('employee.modal.label_email'),
            'locale' => 'System Language',
            'gender' => __('employee.modal.label_gender'),
            'department_id' => __('employee.modal.label_dept'),
            'position_id' => __('employee.modal.label_position'),
            'address' => __('employee.modal.label_address'),
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => __('validation.unique', ['attribute' => 'Email']),
            'locale.in' => 'Bahasa yang dipilih tidak tersedia.',
        ];
    }
}