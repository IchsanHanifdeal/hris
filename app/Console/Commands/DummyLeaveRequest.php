<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DummyLeaveRequest extends Command
{
    protected $signature = 'app:dummy-leave-request {--count=10 : Jumlah request yang ingin dibuat}';
    protected $description = 'Generate data dummy pengajuan cuti untuk testing Admin HR';

    public function handle()
    {
        $count = (int) $this->option('count');
        $employees = Employee::all();
        $leaveTypes = LeaveType::all();

        if ($employees->isEmpty() || $leaveTypes->isEmpty()) {
            $this->error("Buset! Pastiin tabel employees dan leave_types udah ada isinya dulu, cuy.");
            return;
        }

        $this->info("Memulai generate $count data dummy pengajuan cuti...");

        $reasons = [
            'Ada acara keluarga di luar kota.',
            'Ingin istirahat sejenak dari hiruk pikuk koding.',
            'Urusan mendadak terkait dokumen negara.',
            'Menghadiri pernikahan mantan, gila sih ini.',
            'Cek kesehatan rutin ke rumah sakit.',
            'Anak lagi sakit, butuh pendampingan penuh.',
        ];

        for ($i = 0; $i < $count; $i++) {
            $employee = $employees->random();
            $leaveType = $leaveTypes->random();
            
            // Senior Logic: Tanggal mulai random dalam 30 hari ke depan
            $startDate = Carbon::today()->addDays(rand(1, 30));
            $endDate = $startDate->copy()->addDays(rand(1, 5));

            try {
                LeaveRequest::create([
                    'employee_id'   => $employee->id,
                    'leave_type_id' => $leaveType->id,
                    'start_date'    => $startDate->format('Y-m-d'),
                    'end_date'      => $endDate->format('Y-m-d'),
                    'reason'        => $reasons[array_rand($reasons)],
                    'attachment'    => rand(0, 1) ? 'dummies/attachment.pdf' : null, // 50% chance ada lampiran
                    'status'        => 'pending', // Biar masuk ke queue approval HR
                ]);

                $this->line("<info>✔</info> Request created for: {$employee->user->name} ({$leaveType->name})");
            } catch (\Exception $e) {
                $this->error("Gagal generate data ke-$i: " . $e->getMessage());
                Log::error("Dummy Leave Error: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info("Anjay! $count pengajuan cuti dummy berhasil masuk ke antrean HR.");
    }
}