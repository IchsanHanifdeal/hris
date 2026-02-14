<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Services\PositionService;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PositionService $positionService)
    {
        // Controller tipis, logic sakral ada di Service Layer
        $data = $positionService->getDashboardData($request->all());

        return view('dashboard.positions', array_merge($data, [
            'title' => __('position.title') // Tetap dukung multi-language
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
    public function store(Request $request, PositionRequest $positionRequest)
    {
        $validated = $positionRequest->validated();

        try {
            Position::create($validated);
            $message = __('actions.success', ['name' => __('position.title')]);

            return redirect()
                ->route('positions.index')
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
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PositionRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            Position::where('id', $id)->update($validated);
            $message = __('actions.success', ['name' => __('position.title')]);

            return redirect()
                ->route('positions.index')
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
            Position::where('id', $id)->delete();
            $message = __('actions.success', ['name' => __('position.title')]);

            return redirect()
                ->route('positions.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('actions.failed'));
        }
    }
}
