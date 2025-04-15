<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month',
        'total_working_days',
        'present_days',
        'leaves',
        'absents',
        'half_days',
        'base_salary',
        'final_salary',
    ];

    public function employee()
{
    return $this->belongsTo(Employee::class);
}

}
