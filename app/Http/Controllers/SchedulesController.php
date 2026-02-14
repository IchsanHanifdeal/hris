<?php

namespace App\Http\Controllers;

use App\Models\Schedule; // Pastikan model tunggal
use App\Services\SchedulesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SchedulesController extends Controller
{
    protected $schedulesService;

    public function __construct(SchedulesService $schedulesService)
    {
        $this->schedulesService = $schedulesService;
    }

    /**
     * Display the Matrix View
     */
    public function index(Request $request)
    {
        $data = $this->schedulesService->getMatrixData($request->all());
        $masterData = $this->schedulesService->getMasterDataForForm();
        
        return view('dashboard.schedules', array_merge($data, $masterData));
    }

    /**
     * Store a newly created schedule (Bulk supported)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'shift_id'    => 'required|exists:shifts,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        try {
            $this->schedulesService->bulkCreate($validated);
            return redirect()->back()->with('success', __('actions.success'));
        } catch (\Exception $e) {
            Log::error("Gagal create schedule: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat jadwal, cek log.');
        }
    }
    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'date'     => 'required|date',
        ]);

        try {
            $schedule->update($validated);
            return redirect()->back()->with('success', __('actions.updated', ['name' => 'Jadwal']));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui jadwal.');
        }
    }

    /**
     * Remove the specified resource
     */
    public function destroy(Schedule $schedule)
    {
        try {
            $schedule->delete();
            return redirect()->back()->with('success', __('actions.deleted', ['name' => 'Jadwal']));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus jadwal.');
        }
    }
}