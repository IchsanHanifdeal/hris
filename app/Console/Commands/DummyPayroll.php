<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Services\PayrollService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DummyPayroll extends Command
{
    protected $signature = 'app:dummy-payroll {--month= : Bulan (1-12)} {--year= : Tahun (YYYY)}';
    protected $description = 'Generate data payroll dummy berdasarkan attendance dan overtime';

    protected $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        parent::__construct();
        $this->payrollService = $payrollService;
    }

    public function handle()
    {
        $month = $this->option('month') ?? Carbon::now()->month;
        $year = $this->option('year') ?? Carbon::now()->year;

        $employees = Employee::with('position')->where('status', 'active')->get();

        if ($employees->isEmpty()) {
            $this->error("Buset! Karyawan aktif gak ketemu. Isi dulu tabel employees!");
            return;
        }

        $this->info("Generating Payroll for $month/$year...");
        $bar = $this->output->createProgressBar($employees->count());

        foreach ($employees as $employee) {
            try {
                $this->payrollService->calculateMonthlyPayroll($employee, $month, $year);
                $bar->advance();
            } catch (\Exception $e) {
                $this->error("\nGagal generate payroll buat {$employee->user->name}: " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("Anjay! Payroll dummy buat $month/$year berhasil di-sinkronisasi.");
    }
}