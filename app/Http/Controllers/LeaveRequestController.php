<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Services\LeaveRequestService;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $leaveRequestService;

    public function __construct(LeaveRequestService $leaveRequestService)
    {
        $this->leaveRequestService = $leaveRequestService;
    }

    public function index()
    {
        if(Auth::user()->hasRole('karyawan')) {
            $data = $this->leaveRequestService->getFormData();
            return view('pwa.leave-request', $data);
        } else {
            $requests = $this->leaveRequestService->getPendingRequests();
            
            $pendingCount = LeaveRequest::where('status', 'pending')->count();
            $approvedCount = LeaveRequest::where('status', 'approved')
                ->whereMonth('created_at', now()->month)->count();
            $leaveTypesCount = \App\Models\LeaveType::count();

            return view('dashboard.leave-request', compact(
                'requests', 'pendingCount', 'approvedCount', 'leaveTypesCount'
            ));
        }
    }

    public function store(\App\Http\Requests\LeaveRequestStoreRequest $request)
    {
        try {
            $this->leaveRequestService->storeLeaveRequest($request->validated(), Auth::user());
            return redirect()->route('attendance.mywork')->with('success', 'Pengajuan cuti berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function getQuota($leaveTypeId)
    {
        $quota = $this->leaveRequestService->getRemainingQuota(Auth::user()->employee->id, $leaveTypeId);
        return response()->json(['quota' => $quota]);
    }

    public function updateStatus(LeaveRequest $leaveRequest, $status, Request $request)
    {
        try {
            $this->leaveRequestService->processStatus($leaveRequest, [
                'status' => $status,
                'rejection_note' => $request->get('rejection_note')
            ]);
            return redirect()->back()->with('success', "Permohonan cuti berhasil di-{$status}.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
