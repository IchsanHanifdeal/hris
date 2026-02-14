<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use App\Services\LeaveTypeService;
use App\Http\Requests\LeaveTypeRequest;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LeaveTypeService $leaveServices)
    {
        $data = $leaveServices->getDashboardData();
        return view('dashboard.leave-type', array_merge($data, [
            'title' => __('leave-type.title'),
            'leaveTypes' => $data['leave_types'],
            'total_leave_types' => $data['total_leave_types'],
            'latest_leave_type' => $data['latest_leave_type'],
        ]));
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
    public function store(LeaveTypeRequest $request)
    {
        $validated = $request->validated();

        try {
            LeaveType::create($validated);
            $message = __('actions.success', ['name' => __('leave-type.title')]);

            return redirect()
                ->route('leave-types.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('actions.failed'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveType $leaveType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveType $leaveType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeaveTypeRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            LeaveType::where('id', $id)->update($validated);
            $message = __('actions.success', ['name' => __('leave-type.title')]);

            return redirect()
                ->route('leave-types.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('actions.failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            LeaveType::destroy($id);
            $message = __('actions.success', ['name' => __('leave-type.title')]);

            return redirect()
                ->route('leave-types.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('actions.failed'));
        }
    }
}
