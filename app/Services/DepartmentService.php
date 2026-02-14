<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Employee;

class DepartmentService
{
    public function getDashboardData(array $filters = [])
    {
        $query = Department::query()->withCount('employees');

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return [
            'departments' => $query->latest()->paginate(10)->withQueryString(),
            'total_departments' => Department::count(),
            'latest_department' => Department::latest()->first(),
            'total_all_employees' => Employee::count(),
        ];
    }
}