<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShiftRequest;
use App\Models\Shift;
use App\Services\DepartmentService;
use App\Services\ShiftService;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ShiftService $shiftService)
    {
        $data = $shiftService->getDashboardData();

        return view('dashboard.shift', array_merge($data, [
            'title' => __('shift.title'),
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
    public function store(ShiftRequest $request)
    {
        $validated = $request->validated();

        try {
            Shift::create($validated);
            $message = __('actions.success', ['name' => __('shift.title')]);

            return redirect()
                ->route('shifts.index')
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
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShiftRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            Shift::where('id', $id)->update($validated);
            $message = __('actions.success', ['name' => __('shift.title')]);

            return redirect()
                ->route('shifts.index')
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
            Shift::destroy($id);
            $message = __('actions.success', ['name' => __('shift.title')]);

            return redirect()
                ->route('shifts.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('actions.failed'));
        }
    }
}
