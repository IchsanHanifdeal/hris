<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DepartmentService $departmentService)
    {
        $data = $departmentService->getDashboardData(request()->all());

        return view('dashboard.department', array_merge($data, [
            'title' => __('department.title') 
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
    public function store(StoreDepartmentRequest $request)
    {
        $validated = $request->validated();

        try {
            Department::create($validated);
            $message = __('actions.success', ['name' => __('department.title')]);

            return redirect()
                ->route('departments.index')
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
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDepartmentRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            Department::where('id', $id)->update($validated);
            $message = __('actions.success', ['name' => __('department.title')]);

            return redirect()
                ->route('departments.index')
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
            Department::destroy($id);
            $message = __('actions.success', ['name' => __('department.title')]);

            return redirect()
                ->route('departments.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('actions.failed'));
        }
    }
}
