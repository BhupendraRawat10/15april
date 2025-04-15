<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';

 
    protected $fillable = ['branch_name']; 


    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
