<?php

namespace App\Repositories;

use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveRequestRepository
{
    public function create(array $data)
    {
        return LeaveRequest::create($data);
    }

    public function findByEmployee($employeeId)
    {
        return LeaveRequest::with('leaveType')
            ->where('employee_id', $employeeId)
            ->latest()
            ->get();
    }

    public function getActiveLeaveTypes()
    {
        return \App\Models\LeaveType::all();
    }
}
