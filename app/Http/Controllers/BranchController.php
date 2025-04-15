<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class BranchController extends Controller
{
    public function index()
    {
      
        $monthsToDisplay = 3;
        $employeeOfTheMonthForEachBranch = [];
        $employeesWithHighAttendance = [];

      
        $branches = Employee::select('branch_id')->distinct()->get();

      
        foreach ($branches as $branch) {
        
            $employeeOfTheMonthForBranch = [];

           
            for ($i = 0; $i < $monthsToDisplay; $i++) {
          
                $startOfMonth = Carbon::now()->subMonths($i)->startOfMonth();
                $endOfMonth = Carbon::now()->subMonths($i)->endOfMonth();

             
                $employeeOfTheMonth = Employee::where('branch_id', $branch->branch_id)
                    ->withCount([
                        'attendances as present_days' => function ($query) use ($startOfMonth, $endOfMonth) {
                            $query->where('status', 'Present')
                                  ->whereBetween('date', [$startOfMonth, $endOfMonth]);
                        },
                        'attendances as absent_days' => function ($query) use ($startOfMonth, $endOfMonth) {
                            $query->where('status', 'Absent')
                                  ->whereBetween('date', [$startOfMonth, $endOfMonth]);
                        }
                    ])
                    ->orderByDesc('present_days') 
                    ->orderBy('absent_days') 
                    ->orderBy('joining_date') 
                    ->first();
                
                $branchName = $employeeOfTheMonth && $employeeOfTheMonth->branch ? $employeeOfTheMonth->branch->branch_name : 'Unknown Branch';

               
                $employeeOfTheMonthForBranch[] = [
                    'employee' => $employeeOfTheMonth,
                    'branch_name' => $branchName,
                    'month' => $startOfMonth->format('F Y'),
                ];
            }

        
            $employeeOfTheMonthForEachBranch[$branch->branch_id] = $employeeOfTheMonthForBranch;
        }

        $employeesWithHighAttendance = Employee::all()->filter(function ($employee) {
         
            $attendances = $employee->attendances;
        
            $totalAttendance = $attendances->count();
        
        
            $presentAttendance = $attendances->where('status', 'Present')->count();
        
          
            $attendancePercentage = $totalAttendance > 0 ? ($presentAttendance / $totalAttendance) * 100 : 0;
        
           
            return $attendancePercentage > 90;
        });
        
        $employeeCount = Employee::count();
        $totalPresent = Attendance::where('status', 'Present')->count();
        $totalAttendance = Attendance::count();

   
        $attendancePercentage = $totalAttendance > 0 ? ($totalPresent / $totalAttendance) * 100 : 0;

  
        $formattedAttendancePercentage = number_format($attendancePercentage, 2);

        return view('dashboard', [
            'employeeCount' => $employeeCount,
            'attendancePercentage' => $formattedAttendancePercentage,
            'employeeOfTheMonthForEachBranch' => $employeeOfTheMonthForEachBranch,
            'employeesWithHighAttendance' => $employeesWithHighAttendance
        ]);
    }
}
