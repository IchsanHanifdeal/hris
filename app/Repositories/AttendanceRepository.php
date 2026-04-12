<?php

namespace App\Repositories;

use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceRepository
{
    public function findByEmployeeAndDate($employeeId, $date)
    {
        return Attendance::where('employee_id', $employeeId)
            ->where('date', $date)
            ->first();
    }

    public function create(array $data)
    {
        return Attendance::create($data);
    }

    public function update(Attendance $attendance, array $data)
    {
        $attendance->update($data);
        return $attendance;
    }
}
