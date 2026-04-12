<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Ichsan Hanifdeal',
                'password' => 'password',
            ]
        );

        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $karyawans = [
            [
                'name' => 'Scott Calderon',
                'email' => 'karyawan@gmail.com',
                'code' => 'EMP-001',
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@gmail.com',
                'code' => 'EMP-002',
            ],
            [
                'name' => 'John Smith',
                'email' => 'john@gmail.com',
                'code' => 'EMP-003',
            ],
        ];

        foreach ($karyawans as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => 'password',
            ]);

            $user->assignRole('karyawan');

            Employee::create([
                'user_id' => $user->id,
                'department_id' => 1, 
                'position_id' => 1,   
                'employee_code' => $data['code'],
                'gender' => 'male',
                'address' => 'Jakarta, Indonesia',
                'status' => 'active',
            ]);
        }
    }
}
