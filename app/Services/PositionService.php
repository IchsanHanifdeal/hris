<?php

namespace App\Services;

use App\Models\Position;

class PositionService
{
    public function getDashboardData(array $filters = [])
    {
        $query = Position::query();

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return [
            'positions' => $query->latest()->paginate(10)->withQueryString(),
            'total_positions' => Position::count(),
            'avg_salary' => Position::avg('basic_salary'),
        ];
    }
}