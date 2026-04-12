<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\Employee;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SchedulesService
{
    public function getMatrixData(array $filters = [])
    {
        $month = $filters['month'] ?? now()->format('Y-m');
        $startOfMonth = Carbon::parse($month)->startOfMonth();
        $endOfMonth = Carbon::parse($month)->endOfMonth();

        $daysInMonth = [];
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $daysInMonth[] = $date->copy();
        }

        $employees = Employee::with(['user', 'schedules' => function($q) use ($startOfMonth, $endOfMonth) {
                $q->whereBetween('date', [$startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d')])
                  ->with('shift');
            }])
            ->when($filters['search'] ?? null, function($q, $search) {
                $q->whereHas('user', fn($query) => $query->where('name', 'like', "%{$search}%"))
                  ->orWhere('employee_code', 'like', "%{$search}%");
            })
            ->paginate(15) 
            ->withQueryString();

        return [
            'employees' => $employees,
            'daysInMonth' => $daysInMonth,
            'total_scheduled' => Schedule::whereBetween('date', [$startOfMonth, $endOfMonth])->count(),
            'active_shifts' => Shift::count(),
            'date_range' => [
                'start' => $startOfMonth->format('Y-m-d'),
                'end' => $endOfMonth->format('Y-m-d')
            ]
        ];
    }

    public function getMasterDataForForm()
    {
        return [
            'allEmployees' => Employee::with('user')
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->orderBy('users.name', 'asc')
                ->select('employees.*')
                ->get(),
            'shifts' => Shift::orderBy('name', 'asc')->get(),
        ];
    }

    public function bulkCreate(array $data)
    {
        return DB::transaction(function () use ($data) {
            $start = Carbon::parse($data['start_date']);
            $end = Carbon::parse($data['end_date']);
            $records = [];

            while ($start->lte($end)) {
                $exists = Schedule::where('employee_id', $data['employee_id'])
                    ->where('date', $start->format('Y-m-d'))
                    ->exists();

                if (!$exists) {
                    $records[] = [
                        'employee_id' => $data['employee_id'],
                        'shift_id'    => $data['shift_id'],
                        'date'        => $start->format('Y-m-d'),
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                }
                $start->addDay();
            }

            return count($records) > 0 ? Schedule::insert($records) : true;
        });
    }
}
