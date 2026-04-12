<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Setting;
use App\Repositories\AttendanceRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    protected $repository;

    public function __construct(AttendanceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAttendanceData(array $filters)
    {
        $date = $filters['date'] ?? Carbon::today()->format('Y-m-d');

        return [
            'presentToday' => Attendance::whereDate('date', $date)->count(),
            'lateToday'    => Attendance::whereDate('date', $date)->where('status', 'late')->count(),
            'overtimeToday'=> Attendance::whereDate('date', $date)->where('status', 'overtime')->count(),
            'onLeave'      => Employee::where('status', 'leave')->count(),
            'attendances'  => Attendance::with(['employee.user', 'shift', 'schedule'])
                                ->whereDate('date', $date)
                                ->latest('time_in')
                                ->paginate(15)
                                ->withQueryString(),
        ];
    }

    public function storeAttendance(array $payload, $user)
    {
        return DB::transaction(function () use ($payload, $user) {
            $employee = $user->employee;
            if (!$employee) throw new \Exception(__('pwa.error.employee_not_found'));

            $setting = Setting::first();
            $now = now();
            $today = $now->toDateString();

            if (isset($payload['latitude']) && isset($payload['longitude'])) {
                $distance = $this->calculateDistance(
                    $payload['latitude'], $payload['longitude'],
                    $setting->latitude, $setting->longitude
                );

                if ($distance > $setting->radius) {
                    throw new \Exception(__('pwa.error.out_of_radius', ['distance' => round($distance)]));
                }
            }

            $attendance = $this->repository->findByEmployeeAndDate($employee->id, $today);

            $imagePath = null;
            if (isset($payload['image'])) {
                $imageData = $payload['image'];
                $image = str_replace('data:image/png;base64,', '', $imageData);
                $image = str_replace(' ', '+', $image);
                $imageName = $employee->employee_code . '_' . ($attendance ? 'out' : 'in') . '_' . time() . '.png';
                $imagePath = 'attendance/' . $imageName;
                \Illuminate\Support\Facades\Storage::disk('public')->put($imagePath, base64_decode($image));
            }

            if (!$attendance) {
                $status = ($now->format('H:i:s') > $setting->check_in_time) ? 'late' : 'on_time';
                
                return $this->repository->create([
                    'employee_id' => $employee->id,
                    'date' => $today,
                    'time_in' => $now->toTimeString(),
                    'lat_in' => $payload['latitude'] ?? null,
                    'long_in' => $payload['longitude'] ?? null,
                    'photo_in' => $imagePath,
                    'status' => $status,
                ]);
            } else {
                if ($attendance->time_out) {
                    throw new \Exception(__('pwa.error.already_out'));
                }

                return $this->repository->update($attendance, [
                    'time_out' => $now->toTimeString(),
                    'lat_out' => $payload['latitude'] ?? null,
                    'long_out' => $payload['longitude'] ?? null,
                    'photo_out' => $imagePath,
                ]);
            }
        });
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; 
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }
}