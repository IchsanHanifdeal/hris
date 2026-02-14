<?php

namespace App\Services;

use App\Models\Shift;

class ShiftService
{
    /**
     * Create a new class instance.
     */
    public function getDashboardData(array $filters = [])
    {
        $query = Shift::query();

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return [
            'shifts' => $query->latest()->paginate(10)->withQueryString(), 
            'total_shifts' => Shift::count(),
            'latest_shift' => Shift::latest()->first(),
        ];
    }
}
