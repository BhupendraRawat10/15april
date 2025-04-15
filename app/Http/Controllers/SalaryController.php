<?php

namespace App\Http\Controllers;
use App\Models\Salary;
use App\Models\Employee;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
    return view('salaryshow', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|date_format:Y-m',
            'total_working_days' => 'required|integer|min:0',
            'present_days' => 'required|integer|min:0',
            'leaves' => 'required|integer|min:0',
            'absents' => 'required|integer|min:0',
            'half_days' => 'required|integer|min:0',
            'base_salary' => 'required|numeric|min:0',
        ]);

        $perDaySalary = $request->base_salary / 30;
        $deductions = ($request->absents * $perDaySalary) + ($request->half_days * ($perDaySalary / 2));
        $finalSalary = $request->base_salary - $deductions;

        Salary::create([
            'employee_id' => $request->employee_id,
            'month' => $request->month,
            'total_working_days' => $request->total_working_days,
            'present_days' => $request->present_days,
            'leaves' => $request->leaves,
            'absents' => $request->absents,
            'half_days' => $request->half_days,
            'base_salary' => $request->base_salary,
            'final_salary' => $finalSalary,
        ]);
   
        return response()->json(['message' => 'Salary entry saved successfully.'], 200);
        
    }


    public function showsalarydata(Request $request)
    {
        if ($request->ajax()) {
            $salaries = Salary::with('employee.branch'); // Eager load the branch relationship
    
            // Filter by employee name
            if ($request->has('employee_name') && !empty($request->employee_name)) {
                $salaries->whereHas('employee', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->employee_name . '%');
                });
            }
    
            // Filter by employee branch if provided
            if ($request->has('employee_branch') && !empty($request->employee_branch)) {
                $salaries->whereHas('employee', function ($query) use ($request) {
                    $query->whereHas('branch', function ($query) use ($request) {
                        $query->where('branch_name', 'like', '%' . $request->employee_branch . '%');
                    });
                });
            }
    
            // DataTables response
            return DataTables::of($salaries)
                ->addColumn('employee_name', function ($salary) {
                    return $salary->employee->name ?? 'N/A';
                })
                ->addColumn('employee_branch', function ($salary) {
                    return $salary->employee->branch->branch_name ?? 'N/A';  // Access only branch_name from the related branch model
                })
                ->filterColumn('employee_name', function ($query, $keyword) {
                    $query->whereHas('employee', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('employee_branch', function ($query, $keyword) {
                    $query->whereHas('employee', function ($q) use ($keyword) {
                        $q->whereHas('branch', function ($q) use ($keyword) {
                            $q->where('branch_name', 'like', "%{$keyword}%");
                        });
                    });
                })
                ->make(true);
        }
    
        return view('salary.index');
    }
    
    
    
}
