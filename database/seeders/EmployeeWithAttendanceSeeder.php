<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Employee; // ✅ Add this line

class EmployeeWithAttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::factory()->count(10)->create();

        foreach ($employees as $employee) {
            foreach (['2025-01', '2025-02', '2025-03'] as $month) {
                $startDate = Carbon::parse($month . '-01');
                $endDate = (clone $startDate)->endOfMonth();

                for ($date = $startDate; $date <= $endDate; $date->addDay()) {
                    if ($date->isSunday()) continue;

                    DB::table('attendance')->insert([
                        'employee_id' => $employee->id,
                        'date' => $date->format('Y-m-d'),
                        'status' => collect(['Present', 'Absent', 'Leave', 'Half-day'])->random(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
