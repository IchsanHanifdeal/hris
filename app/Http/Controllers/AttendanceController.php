<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Services\AttendanceService;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $service)
    {
        $this->attendanceService = $service;
    }

    public function index(Request $request)
    {
        if(Auth::user()->hasRole('karyawan')) {
            $setting = Setting::first();
            $employee = Auth::user()->employee;
            
            $monthStart = now()->startOfMonth();
            $monthEnd = now()->endOfMonth();

            $stats = [
                'present' => Attendance::where('employee_id', $employee->id)
                    ->whereBetween('date', [$monthStart, $monthEnd])
                    ->count(),
                'late' => Attendance::where('employee_id', $employee->id)
                    ->whereBetween('date', [$monthStart, $monthEnd])
                    ->where('status', 'late')
                    ->count(),
                'month' => now()->translatedFormat('F')
            ];

            $history = Attendance::where('employee_id', $employee->id)
                ->orderBy('date', 'desc')
                ->orderBy('time_in', 'desc')
                ->take(5)
                ->get();

            return view('pwa.attedance', compact('setting', 'stats', 'history'));
        } else {
            $data = $this->attendanceService->getAttendanceData($request->all());
            return view('dashboard.attendance', $data);
        }
    }

    public function store(AttendanceRequest $request)
    {
        try {
            $this->attendanceService->storeAttendance($request->validated(), Auth::user());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Absensi berhasil dicatat.'
                ]);
            }

            return redirect()->back()->with('success', 'Absensi berhasil dicatat.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function mywork(Request $request)
    {
        $employee = Auth::user()->employee;
        $dateFrom = $request->get('from', now()->startOfMonth()->toDateString());
        $dateTo = $request->get('to', now()->endOfMonth()->toDateString());

        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->orderBy('date', 'desc')
            ->get();

        $leaveRequests = LeaveRequest::where('employee_id', $employee->id)
            ->where(function($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('start_date', [$dateFrom, $dateTo])
                  ->orWhereBetween('end_date', [$dateFrom, $dateTo]);
            })
            ->with(['leaveType', 'approver'])
            ->orderBy('start_date', 'desc')
            ->get();

        return view('pwa.mywork', compact('attendances', 'leaveRequests', 'dateFrom', 'dateTo'));
    }
    
}