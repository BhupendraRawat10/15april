<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-lg">
      <div class="p-6 text-center border-b">
        <h1 class="text-xl font-bold">User Dashboard</h1>
      </div>
      <nav class="mt-4">
        <a href="/" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200">Dashboard</a>
        <a href="salary" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200">Salary Calculation</a>
        <a href="allsalary" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200">Show Reports</a>
     
      </nav>
    </div>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">
      <!-- Topbar -->
      <header class="bg-white shadow p-4 flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Dashboard</h2>
        <div>
          <span class="mr-4 text-gray-600">Welcome, User</span>
        </div>
      </header>

      <!-- Content -->
      <main class="flex-1 overflow-y-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Card 1 -->
          <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-bold mb-2">Total Employees</h3>
            <p class="text-3xl font-semibold">{{ $employeeCount }}</p>
          </div>

          <!-- Card 2 -->
          <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-bold mb-2">Avg Attendance(Present)</h3>
            <p class="text-3xl font-semibold">{{$attendancePercentage}}%</p>
          </div>

          <!-- Card 3 -->
          <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-bold mb-2">Employee of the Month</h3>
            <div class="space-y-4">
              @foreach($employeeOfTheMonthForEachBranch as $branchId => $employees)
                <div>
                  <h4 class="text-lg font-semibold">Branch: {{ $employees[0]['branch_name'] }}</h4>
                  <ul class="list-disc pl-5">
                    @foreach($employees as $employee)
                      <li>
                        <strong>{{ $employee['month'] }}:</strong> Employee: {{ $employee['employee']->name }}
                      </li>
                    @endforeach
                  </ul>
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Employees with > 90% Attendance and Logged In -->
        <div class="bg-white p-4 rounded shadow mt-6">
          <h3 class="text-lg font-bold mb-2">Employees with >90% Attendance and Logged In</h3>
          @if($employeesWithHighAttendance->isEmpty())
            <p>No employees found with more than 90% attendance </p>
          @else
            <ul class="space-y-2">
              @foreach($employeesWithHighAttendance as $employee)
                <li class="flex justify-between items-center">
                  <span class="font-semibold">{{ $employee->name }}</span>
                  <span class="text-sm text-gray-600">{{ $employee->attendance_percentage }}%</span>
                </li>
              @endforeach
            </ul>
          @endif
        </div>

      </main>
    </div>
  </div>
</body>
</html>
