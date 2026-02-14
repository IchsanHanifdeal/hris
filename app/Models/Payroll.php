<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'period_start',
        'period_end',
        'basic_salary',
        'allowances',
        'deductions',
        'net_salary',
        'overtime_pay',
        'status',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'overtime_pay' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
