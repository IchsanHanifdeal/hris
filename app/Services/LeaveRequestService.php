<?php

namespace App\Services;

use App\Models\LeaveRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaveRequestService
{
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
            
            // Senior Logic: Update status & auditor
            $leaveRequest->update([
                'status' => $status,
                'approved_by' => auth()->id(),
                'approved_at' => $status === 'approved' ? now() : null,
                'rejection_note' => $status === 'rejected' ? $data['rejection_note'] : null,
            ]);

            // Kalau diapprove, lu bisa tambahin logic pemotongan kuota di sini
            // if ($status === 'approved') { ... logic quota ... }

            return $leaveRequest;
        });
    }
}