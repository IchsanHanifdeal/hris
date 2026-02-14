<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view_dashboard',
            'manage_users',
            'manage_shifts',
            'manage_payroll',
            'approve_leave',
            'view_own_payslip',
            'submit_attendance',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $hrd = Role::create(['name' => 'hrd']);
        $hrd->givePermissionTo([
            'view_dashboard',
            'manage_users',
            'manage_shifts',
            'manage_payroll',
            'approve_leave',
        ]);

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            'view_dashboard',
            'approve_leave',
        ]);

        $karyawan = Role::create(['name' => 'karyawan']);
        $karyawan->givePermissionTo([
            'view_dashboard',
            'view_own_payslip',
            'submit_attendance',
        ]);

        $direktur = Role::create(['name' => 'direktur']);
        $direktur->givePermissionTo([
            'view_dashboard',
        ]);
    }
}