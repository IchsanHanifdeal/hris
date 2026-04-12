<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('karyawan')) {
            $employee = $user->employee;
            if (!$employee) return view('pwa.dashboard', ['error' => 'Karyawan record missing']);

            $todayAttendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('date', now()->toDateString())
                ->first();

            $monthStart = now()->startOfMonth();
            $monthEnd = now()->endOfMonth();
            
            $stats = [
                'present' => Attendance::where('employee_id', $employee->id)
                    ->whereBetween('date', [$monthStart, $monthEnd])
                    ->count(),
                'leave_used' => \App\Models\LeaveRequest::where('employee_id', $employee->id)
                    ->where('status', 'approved')
                    ->get()
                    ->sum(fn($r) => Carbon::parse($r->start_date)->diffInDays(Carbon::parse($r->end_date)) + 1),
            ];

            return view('pwa.dashboard', compact('employee', 'todayAttendance', 'stats'));
        }


        $todayStart = Carbon::today();
        $todayEnd = Carbon::today()->endOfDay();

        $totalEmployees = Employee::count();
        $onLeave = Employee::where('status', 'leave')->count();

        $presentToday = Attendance::whereBetween('created_at', [$todayStart, $todayEnd])->count();

        $lateToday = Attendance::whereBetween('created_at', [$todayStart, $todayEnd])
            ->whereHas('schedule.shift', function ($query) {
                $query->whereColumn('attendances.time_in', '>', 'shifts.start_time');
            })->count();

        $recentAttendances = Attendance::with(['employee.user', 'employee.position'])
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->latest() 
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalEmployees',
            'presentToday',
            'onLeave',
            'lateToday',
            'recentAttendances'
        ));
    }
}