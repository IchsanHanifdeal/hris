<?php

use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\PayrollController;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

// Guest Area
Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->hasRole('karyawan') && !Auth::user()->employee) {
            return view('pwa.dashboard');
        } else {
            $today = Carbon::today()->format('Y-m-d');

            $totalEmployees = Employee::count();
            
            $presentToday = Attendance::whereDate('created_at', $today)->count();
            
            $onLeave = Employee::where('status', 'leave')->count();

            $lateToday = Attendance::whereDate('created_at', $today)
                ->whereHas('schedule.shift', function($query) {
                    $query->whereRaw('attendances.time_in > shifts.start_time');
                })->count();
            $recentAttendances = Attendance::with(['employee.user', 'employee.position'])
                ->whereDate('created_at', $today)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return view('dashboard.index', compact(
                'totalEmployees',
                'presentToday',
                'onLeave',
                'lateToday',
                'recentAttendances'
            ));
        }
    })->name('dashboard');

    Route::middleware(['role:admin|hrd'])->prefix('dashboard')->group(function () {
        
        Route::resource('departments', DepartmentController::class);
        Route::resource('positions', PositionController::class);
        Route::resource('shifts', ShiftController::class);
        Route::resource('leave-types', LeaveTypeController::class);

        Route::resource('employees', EmployeeController::class);
        Route::resource('schedules', SchedulesController::class);
        Route::resource('attendances', AttendanceController::class);

        Route::resource('leave-requests', LeaveRequestController::class);
        Route::patch('leave-requests/{leaveRequest}/{status}', [LeaveRequestController::class, 'updateStatus'])
            ->name('leave-requests.status')
            ->where('status', 'approved|rejected');

        Route::resource('payrolls', PayrollController::class);
        Route::post('payrolls/batch-generate', [PayrollController::class, 'batchGenerate'])
            ->name('payrolls.batch-generate');
        Route::patch('payrolls/{payroll}/pay', [PayrollController::class, 'pay'])
            ->name('payrolls.pay');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    Route::middleware(['role:admin|hrd'])->prefix('pwa')->group(function () {
        Route::resource('attendances', AttendanceController::class);
        Route::resource('payrolls', PayrollController::class);
        Route::resource('leave-requests', LeaveRequestController::class);
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
        Route::post('/employees/store-self', [EmployeeController::class, 'storeSelf'])->name('employees.store_self');
    });


});

Route::get('lang/{locale}', [LocalizationController::class, 'switch'])->name('lang.switch');

require __DIR__.'/auth.php';
