<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Services\PayrollService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

    public function index(Request $request)
    {
        if(Auth::user()->hasRole('karyawan')) {
            return view('pwa.payroll');
        } else {
            $month = $request->get('month', Carbon::now()->month);
            $year = $request->get('year', Carbon::now()->year);

            $payrolls = Payroll::with(['employee.user', 'employee.position'])
                ->whereMonth('period_start', $month)
            ->whereYear('period_start', $year)
            ->latest()
            ->paginate(15)
            ->withQueryString();

            $totalPaid = Payroll::whereMonth('period_start', $month)
                ->whereYear('period_start', $year)
                ->where('status', 'paid')
                ->sum('net_salary');

            $draftCount = Payroll::whereMonth('period_start', $month)
                ->whereYear('period_start', $year)
                ->where('status', 'draft')
                ->count();

            return view('dashboard.payroll', compact(
                'payrolls', 
                'totalPaid', 
                'draftCount',
                'month',
                'year'
            ));
        }
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
    public function show(Payroll $payroll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll)
    {
        //
    }
}
