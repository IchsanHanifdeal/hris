<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'schedule_id',
        'shift_id',
        'date',
        'time_in',
        'time_out',
        'lat_in',
        'long_in',
        'photo_in',
        'lat_out',
        'long_out',
        'photo_out',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'time_in' => 'datetime:H:i:s',
        'time_out' => 'datetime:H:i:s',
        'lat_in' => 'decimal:8',
        'long_in' => 'decimal:8',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}