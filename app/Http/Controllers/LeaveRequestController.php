<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Services\LeaveRequestService;

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
        $requests = $this->leaveRequestService->getPendingRequests();
        
        // Data statistik buat info cards di atas
        $pendingCount = LeaveRequest::where('status', 'pending')->count();
        $approvedCount = LeaveRequest::where('status', 'approved')
            ->whereMonth('created_at', now()->month)->count();
        $leaveTypesCount = \App\Models\LeaveType::count();

        return view('dashboard.leave-request', compact(
            'requests', 'pendingCount', 'approvedCount', 'leaveTypesCount'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
