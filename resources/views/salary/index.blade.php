<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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
        <!-- Filters -->
        <div class="flex space-x-4 mb-4">
          <input type="text" id="employeeFilter" placeholder="Filter by Employee Name" class="p-2 border rounded" />
          <input type="text" id="branchFilter" placeholder="Filter by Branch" class="p-2 border rounded" />
        </div>

        <!-- Data Table -->
        <table class="display" id="salaryTable" style="width: 100%;">
          <thead>
            <tr>
                <th>ID</th>
                <th>Employee Name</th>
                <th>Branch</th>
                <th>Month</th>
                <th>Total Working Days</th>
                <th>Present</th>
                <th>Leaves</th>
                <th>Absents</th>
                <th>Half Days</th>
                <th>Base Salary</th>
                <th>Final Salary</th>
            </tr>
          </thead>
        </table>
      </main>
    </div>
  </div>

</body>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- DataTables JS + Buttons -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script>
 $(document).ready(function () {
    var table = $('#salaryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('salary.index') }}",
            data: function (d) {
                // Get values for filters
                d.employee_name = $('#employeeFilter').val();
                d.employee_branch = $('#employeeBranchFilter').val();  // Add employee branch filter
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'employee_name', name: 'employee_name' },
            { data: 'employee_branch', name: 'employee_branch' },  // Ensure this matches the backend column
            { data: 'month', name: 'month' },
            { data: 'total_working_days', name: 'total_working_days' },
            { data: 'present_days', name: 'present_days' },
            { data: 'leaves', name: 'leaves' },
            { data: 'absents', name: 'absents' },
            { data: 'half_days', name: 'half_days' },
            { data: 'base_salary', name: 'base_salary' },
            { data: 'final_salary', name: 'final_salary' }
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Apply the filter for employee name
    $('#employeeFilter').keyup(function () {
        table.draw();
    });

    // Apply the filter for employee branch
    $('#employeeBranchFilter').keyup(function () {
        table.draw();
    });
});
  
</script>
</html>
