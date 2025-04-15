<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'joining_date',
        'branch_id',
        'base_salary',
    ];
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    
public function branch()
{
    return $this->belongsTo(Branch::class, 'branch_id');
}

}
