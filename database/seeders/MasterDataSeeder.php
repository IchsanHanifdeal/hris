<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Models\Employee;
use App\Models\Shift;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $departments = [
                ['name' => 'Information Technology'],
                ['name' => 'Human Resources'],
                ['name' => 'Finance & Accounting'],
                ['name' => 'Operations'],
            ];
            foreach ($departments as $dept) {
                Department::create($dept);
            }

            $positions = [
                ['name' => 'Senior Backend Engineer', 'basic_salary' => 15000000],
                ['name' => 'HR Manager', 'basic_salary' => 12000000],
                ['name' => 'Finance Staff', 'basic_salary' => 7000000],
                ['name' => 'IT Support', 'basic_salary' => 6000000],
            ];
            foreach ($positions as $pos) {
                Position::create($pos);
            }

            $shifts = [
                [
                    'name' => 'Morning Shift',
                    'start_time' => '08:00:00',
                    'end_time' => '17:00:00',
                ],
                [
                    'name' => 'Middle Shift',
                    'start_time' => '12:00:00',
                    'end_time' => '21:00:00',
                ],
                [
                    'name' => 'Night Shift',
                    'start_time' => '22:00:00',
                    'end_time' => '07:00:00',
                ],
            ];
            foreach ($shifts as $shift) {
                Shift::create($shift);
            }

            $leaveTypes = [
                ['name' => 'Annual Leave', 'quota' => 12],
                ['name' => 'Sick Leave', 'quota' => 12],
                ['name' => 'Maternity Leave', 'quota' => 12],
                ['name' => 'Paternity Leave', 'quota' => 12],
                ['name' => 'Bereavement Leave', 'quota' => 12],
                ['name' => 'Unpaid Leave', 'quota' => 12],
            ];
            foreach ($leaveTypes as $leaveType) {
                LeaveType::create($leaveType);
            }

            $user = User::create([
                'name' => 'Ichsan Hanifdeal',
                'email' => 'admin@gmail.com',
                'password' => 'password',
            ]);

            $user->assignRole('admin');

            Employee::create([
                'user_id' => $user->id,
                'department_id' => 1,
                'position_id' => 1,
                'employee_code' => 'EMP-01012026020001',
                'gender' => 'male',
                'address' => 'West Jakarta, Jakarta, Indonesia',
            ]);

            \App\Models\Setting::create([
                'app_name' => 'HRIS PRO',
                'pwa_name' => 'HRIS PRO',
                'check_in_time' => '08:00:00',
                'check_out_time' => '17:00:00',
                'address' => 'Jakarta, Indonesia',
                'latitude' => '-6.175392',
                'longitude' => '106.827153',
                'radius' => 100,
            ]);
        });
    }
}