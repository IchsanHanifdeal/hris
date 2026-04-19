<?php

use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\PayrollController;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Guest Area
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/manifest.json', [\App\Http\Controllers\PwaController::class, 'manifest']);
Route::get('/sw.js', [\App\Http\Controllers\PwaController::class, 'serviceWorker']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
    
    Route::middleware(['role:karyawan'])->prefix('pwa')->group(function () {
        Route::resource('attendance', AttendanceController::class);
        Route::get('/mywork', [AttendanceController::class, 'mywork'])->name('attendance.mywork');
        // Route::resource('payrolls', PayrollController::class);
    });

    Route::middleware(['role:karyawan|admin'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::get('/leave-requests/quota/{leaveTypeId}', [LeaveRequestController::class, 'getQuota'])->name('leave-requests.quota');
        Route::resource('leave-requests', LeaveRequestController::class);
    });

    Route::middleware(['role:admin'])->prefix('dashboard')->group(function () {
        
        Route::resource('departments', DepartmentController::class);
        Route::resource('positions', PositionController::class);
        Route::resource('shifts', ShiftController::class);
        Route::resource('leave-types', LeaveTypeController::class);

        Route::resource('employees', EmployeeController::class);
        Route::resource('schedules', SchedulesController::class);
        Route::resource('attendances', AttendanceController::class);

        Route::patch('leave-requests/{leaveRequest}/{status}', [LeaveRequestController::class, 'updateStatus'])
            ->name('leave-requests.status')
            ->where('status', 'approved|rejected');

        Route::resource('payrolls', PayrollController::class);
        Route::resource('settings', SettingController::class);
        Route::post('payrolls/batch-generate', [PayrollController::class, 'batchGenerate'])
            ->name('payrolls.batch-generate');
        Route::patch('payrolls/{payroll}/pay', [PayrollController::class, 'pay'])
            ->name('payrolls.pay');
    });

});

Route::get('lang/{locale}', [LocalizationController::class, 'switch'])->name('lang.switch');

require __DIR__.'/auth.php';
