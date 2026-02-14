<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Services\AttendanceService;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $service)
    {
        $this->attendanceService = $service;
    }

    public function index(Request $request)
    {
        $data = $this->attendanceService->getAttendanceData($request->all());
        return view('dashboard.attendance', $data);
    }

    public function store(AttendanceRequest $request)
    {
        Attendance::create($request->validated());
        return redirect()->back()->with('success', 'Absensi berhasil dicatat.');
    }
}