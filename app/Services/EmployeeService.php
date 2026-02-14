<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeService
{
    public function getDashboardData(array $filters = [])
    {
        $query = Employee::query()->with(['user', 'position', 'department']);

        if (!empty($filters['search'])) {
            $query->whereHas('user', function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%');
            })->orWhere('employee_code', 'like', '%' . $filters['search'] . '%');
        }

        return [
            'employees' => $query->latest()->paginate(10)->withQueryString(),
            'total_employees' => Employee::count(),
            'latest_employee' => Employee::with('user')->latest()->first(),
            'pending_leaves' => LeaveRequest::where('status', 'pending')->count(),
        ];
    }

    public function getMasterDataForForm()
    {
        return [
            'positions' => Position::orderBy('name')->get(),
            'departments' => Department::orderBy('name')->get(),
        ];
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('password'),
                'locale'   => $data['locale'] ?? 'id',
            ]);

            $data['employee_code'] = $this->generateEmployeeCode(
                $data['department_id'], 
                $data['position_id']
            );

            return $user->employee()->create([
                'employee_code' => $data['employee_code'],
                'department_id' => $data['department_id'],
                'position_id'   => $data['position_id'],
                'gender'        => $data['gender'],
                'address'       => $data['address'],
            ]);
        });
    }

    /**
     * Update data karyawan (User & Employee)
     */
    public function update(Employee $employee, array $data)
    {
        return DB::transaction(function () use ($employee, $data) {
            $employee->user->update([
                'name'   => $data['name'],
                'email'  => $data['email'],
                'locale' => $data['locale'],
            ]);

            return $employee->update([
                'department_id' => $data['department_id'],
                'position_id'   => $data['position_id'],
                'gender'        => $data['gender'],
                'address'       => $data['address'],
            ]);
        });
    }

    private function generateEmployeeCode($deptId, $posId)
    {
        $datePart = now()->format('Ym'); 
        $prefix = sprintf("EMP-0%s0%s%s", $deptId, $posId, $datePart);

        $lastEmployee = Employee::where('employee_code', 'like', $prefix . '%')
            ->latest('id')
            ->first();

        $increment = 1;
        if ($lastEmployee) {
            $lastIncrement = (int) substr($lastEmployee->employee_code, -4);
            $increment = $lastIncrement + 1;
        }
        return $prefix . str_pad($increment, 4, '0', STR_PAD_LEFT);
    }

    public function delete(Employee $employee)
    {
        return DB::transaction(function () use ($employee) {
            $employee->delete();
            return $employee->user->delete(); 
        });
    }
}