<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'employee_id' => 'sometimes|exists:employees,id',
            'shift_id'    => 'nullable|exists:shifts,id',
            'schedule_id' => 'nullable|exists:schedules,id', 
            'date'        => 'sometimes|date',
            'time_in'     => 'nullable|date_format:H:i:s',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',
            'accuracy'    => 'nullable|numeric',
            'image'       => 'nullable|string',
            'lat_in'      => 'nullable|numeric|between:-90,90', 
            'long_in'     => 'nullable|numeric|between:-180,180', 
            'status'      => 'sometimes|in:on_time,late,overtime', 
        ];
    }
}