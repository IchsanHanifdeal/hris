<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Payroll;
use Carbon\Carbon;

class PayrollService
{
    public function calculateMonthlyPayroll(Employee $employee, $month, $year)
    {
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $basicSalary = $employee->position->basic_salary ?? 0;

        $attendances = Attendance::with('shift')
            ->where('employee_id', $employee->id)
            ->whereBetween('date', [$start, $end])
            ->get();

        $lateDeduction = $attendances->where('status', 'late')->count() * 35000;
        
        $absentCount = max(0, 22 - $attendances->count());
        $absentDeduction = $absentCount * 100000;

        $overtimeBonus = 0;
        foreach ($attendances as $attendance) {
            if ($attendance->time_out && $attendance->shift) {
                $shiftEnd = Carbon::parse($attendance->shift->end_time);
                $actualOut = Carbon::parse($attendance->time_out);

                if ($actualOut->diffInHours($shiftEnd) >= 1) {
                    $totalHours = $actualOut->diffInHours($shiftEnd);
                    $overtimeBonus += ($totalHours * 50000);
                }
            }
        }

        $totalDeductions = $lateDeduction + $absentDeduction;
        $netSalary = ($basicSalary + $overtimeBonus) - $totalDeductions;

        return Payroll::updateOrCreate(
            ['employee_id' => $employee->id, 'period_start' => $start->format('Y-m-d'), 'period_end' => $end->format('Y-m-d')],
            [
                'basic_salary' => $basicSalary,
                'overtime_pay' => $overtimeBonus,
                'deductions'   => $totalDeductions,
                'net_salary'   => $netSalary,
                'status'       => 'draft',
            ]
        );
    }
}