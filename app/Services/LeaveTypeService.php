<?php

namespace App\Services;

use App\Models\LeaveType;

class LeaveTypeService
{
    /**
     * Create a new class instance.
     */
    public function getDashboardData(array $filters = [])
    {
        $query = LeaveType::query();

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return [
            'leave_types' => $query->latest()->paginate(10)->withQueryString(), 
            'total_leave_types' => LeaveType::count(),
            'latest_leave_type' => LeaveType::latest()->first(),
        ];
    }
}
