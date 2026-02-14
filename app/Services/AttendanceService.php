<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;

class AttendanceService
{
    public function getAttendanceData(array $filters)
    {
        $date = $filters['date'] ?? Carbon::today()->format('Y-m-d');

        return [
            'presentToday' => Attendance::whereDate('date', $date)->count(),
            'lateToday'    => Attendance::whereDate('date', $date)->where('status', 'late')->count(),
            'overtimeToday'=> Attendance::whereDate('date', $date)->where('status', 'overtime')->count(),
            'onLeave'      => Employee::where('status', 'leave')->count(),
            'attendances'  => Attendance::with(['employee.user', 'shift', 'schedule'])
                                ->whereDate('date', $date)
                                ->latest('time_in')
                                ->paginate(15)
                                ->withQueryString(),
        ];
    }
}