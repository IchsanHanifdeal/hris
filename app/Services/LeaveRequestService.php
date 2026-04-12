<?php

namespace App\Services;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Repositories\LeaveRequestRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaveRequestService
{
    protected $repository;

    public function __construct(LeaveRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getPendingRequests()
    {
        return LeaveRequest::with(['employee.user', 'leaveType'])
            ->latest()
            ->paginate(15);
    }

    public function processStatus(LeaveRequest $leaveRequest, array $data)
    {
        return DB::transaction(function () use ($leaveRequest, $data) {
            $status = $data['status'];
            
            $leaveRequest->update([
                'status' => $status,
                'approved_by' => auth()->id(),
                'approved_at' => $status === 'approved' ? now() : null,
                'rejection_note' => $status === 'rejected' ? ($data['rejection_note'] ?? null) : null,
            ]);

            return $leaveRequest;
        });
    }

    public function storeLeaveRequest(array $data, $user)
    {
        $employee = $user->employee;
        if (!$employee) throw new \Exception(__('pwa.error.employee_not_found'));

        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $daysRequested = $start->diffInDays($end) + 1;

        $remaining = $this->getRemainingQuota($employee->id, $data['leave_type_id']);
        if ($daysRequested > $remaining) {
            throw new \Exception("Sisa kuota tidak mencukupi. Anda hanya memiliki {$remaining} hari tersisa.");
        }

        $data['employee_id'] = $employee->id;
        $data['status'] = 'pending';

        if (isset($data['attachment']) && $data['attachment'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['attachment']->store('leave-attachments', 'public');
            $data['attachment'] = $path;
        }

        return $this->repository->create($data);
    }

    public function getRemainingQuota($employeeId, $leaveTypeId)
    {
        $leaveType = LeaveType::findOrFail($leaveTypeId);
        
        $usedDays = LeaveRequest::where('employee_id', $employeeId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('status', 'approved')
            ->get()
            ->sum(function($request) {
                return Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date)) + 1;
            });

        return max(0, $leaveType->quota - $usedDays);
    }

    public function getFormData()
    {
        return [
            'leaveTypes' => $this->repository->getActiveLeaveTypes()
        ];
    }
}