<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, EmployeeService $employeeService)
    {
        $data = $employeeService->getDashboardData($request->all());

        return view('dashboard.employee.index', $data);
    }

    public function create(EmployeeService $employeeService)
    {
        $masterData = $employeeService->getMasterDataForForm();

        return view('dashboard.employee.create', $masterData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request, EmployeeService $employeeService)
    {
        $data = $request->validated();
        
        $employee = $employeeService->store($data);
        return redirect()
            ->route('employees.index')
            ->with('success', __('actions.success', ['name' => $employee->user->name]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee, EmployeeService $employeeService)
    {
        $masterData = $employeeService->getMasterDataForForm();

        return view('dashboard.employee.edit', array_merge($masterData, 
            ['employee' => $employee]
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, Employee $employee, EmployeeService $employeeService)
    {
        $data = $request->validated();
        
        $employeeService->update($employee, $data);

        return redirect()
            ->route('employees.index')
            ->with('success', __('actions.update', ['name' => $employee->user->name]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee, EmployeeService $employeeService)
    {
        $employeeName = $employee->user->name;

        $employeeService->delete($employee);

        return redirect()
            ->route('employees.index')
            ->with('success', __('actions.delete', ['name' => $employeeName]));
    }
}
