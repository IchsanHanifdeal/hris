<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\Attendance;
use Illuminate\Console\Command;
use Carbon\Carbon;

class AttendanceDummy extends Command
{
    protected $signature = 'app:attendance-dummy {--days=7}';
    protected $description = 'Generate jadwal dan absensi dummy secara otomatis';

    public function handle()
    {
        $days = (int) $this->option('days');
        $employees = Employee::all();
        
        if ($employees->isEmpty()) {
            $this->error("Buset! Karyawan aja belum ada. Isi dulu tabel employees!");
            return;
        }

        // Ambil satu shift buat default jadwal
        $defaultShift = Shift::first();
        if (!$defaultShift) {
            $this->error("Gila sih, tabel shifts kosong! Minimal buat satu shift (ex: Regular Morning) baru jalanin ini.");
            return;
        }

        $this->info("Memulai proses Auto-Schedule & Attendance untuk $days hari ke belakang...");
        
        $attendanceCount = 0;
        $scheduleCount = 0;

        for ($i = 0; $i <= $days; $i++) {
            $date = Carbon::today()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            
            // Lewatin hari Minggu (opsional, tapi biar realistis)
            if ($date->isSunday()) {
                $this->comment("   [SKIP] $dateStr adalah hari Minggu.");
                continue;
            }

            foreach ($employees as $employee) {
                // 1. Cek atau Buat Jadwal (Schedule)
                $schedule = Schedule::firstOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'date' => $dateStr,
                    ],
                    [
                        'shift_id' => $defaultShift->id,
                        // Tambahkan field lain jika migrasi schedule lu butuh
                    ]
                );

                if ($schedule->wasRecentlyCreated) {
                    $scheduleCount++;
                }

                // 2. Simulasi Absensi (Hanya jika jadwal sudah ada/dibuat)
                // Kasih chance 10% buat gak masuk (biar gak terlalu sempurna)
                if (rand(1, 10) === 1) {
                    $this->line("   [OFF] Employee {$employee->id} di tanggal $dateStr");
                    continue;
                }

                $startTime = Carbon::parse($defaultShift->start_time);
                $isLate = rand(1, 10) > 7; // 30% chance telat
                
                $timeIn = $isLate 
                    ? $startTime->copy()->addMinutes(rand(5, 40)) 
                    : $startTime->copy()->subMinutes(rand(5, 20));

                $timeOut = Carbon::parse($defaultShift->end_time)->addMinutes(rand(1, 30));

                Attendance::updateOrCreate(
                    ['employee_id' => $employee->id, 'date' => $dateStr],
                    [
                        'shift_id'    => $defaultShift->id,
                        'schedule_id' => $schedule->id,
                        'time_in'     => $timeIn->format('H:i:s'),
                        'time_out'    => $timeOut->format('H:i:s'),
                        'lat_in'      => -6.175 + (rand(-100, 100) / 100000), 
                        'long_in'     => 106.827 + (rand(-100, 100) / 100000),
                        'status'      => $isLate ? 'late' : 'on_time',
                    ]
                );
                
                $attendanceCount++;
            }
            $this->line("<info>✔</info> Date $dateStr processed.");
        }

        $this->newLine();
        $this->table(
            ['Metric', 'Total'],
            [
                ['Schedules Created', $scheduleCount],
                ['Attendances Created', $attendanceCount],
            ]
        );

        $this->info("Anjay! Sekarang DB lu penuh data. Cek dashboard gih!");
    }
}