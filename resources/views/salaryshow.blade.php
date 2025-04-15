<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <div class="max-w-4xl mx-auto bg-gray-100 p-8 rounded-lg shadow-md">

          <h2 class="text-2xl font-bold mb-6 text-center">Add Salary Entry</h2>

          <form id="salaryForm" action="{{ route('salary.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- Employee -->
            <div>
              <label for="employee_id" class="block font-semibold mb-1">Employee</label>
              <select name="employee_id" id="employee_id" required class="w-full border-gray-300 rounded p-2">
                <option value="" disabled selected>Select Employee</option>
                @foreach ($employees as $employee)
                  <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
              </select>
            </div>

            <!-- Month -->
            <div>
              <label for="month" class="block font-semibold mb-1">Month</label>
              <input type="month" name="month" id="month" required class="w-full border-gray-300 rounded p-2"/>
            </div>

            <!-- Total Working Days -->
            <div>
              <label for="total_working_days" class="block font-semibold mb-1">Total Working Days</label>
              <input type="number" name="total_working_days" id="total_working_days" required min="0" class="w-full border-gray-300 rounded p-2"/>
            </div>

            <!-- Present Days -->
            <div>
              <label for="present_days" class="block font-semibold mb-1">Present Days</label>
              <input type="number" name="present_days" id="present_days" required min="0" class="w-full border-gray-300 rounded p-2"/>
            </div>

            <!-- Leaves -->
            <div>
              <label for="leaves" class="block font-semibold mb-1">Leaves</label>
              <input type="number" name="leaves" id="leaves" required min="0" class="w-full border-gray-300 rounded p-2"/>
            </div>

            <!-- Absents -->
            <div>
              <label for="absents" class="block font-semibold mb-1">Absents</label>
              <input type="number" name="absents" id="absents" required min="0" class="w-full border-gray-300 rounded p-2" oninput="calculateFinalSalary()"/>
            </div>

            <!-- Half Days -->
            <div>
              <label for="half_days" class="block font-semibold mb-1">Half Days</label>
              <input type="number" name="half_days" id="half_days" required min="0" class="w-full border-gray-300 rounded p-2" oninput="calculateFinalSalary()"/>
            </div>

            <!-- Base Salary -->
            <div>
              <label for="base_salary" class="block font-semibold mb-1">Base Salary</label>
              <input type="number" name="base_salary" id="base_salary" required min="0" step="0.01" class="w-full border-gray-300 rounded p-2" oninput="calculateFinalSalary()"/>
            </div>

            <!-- Final Salary -->
            <div>
              <label for="final_salary" class="block font-semibold mb-1">Final Salary</label>
              <input type="number" name="final_salary" id="final_salary" readonly class="w-full border-gray-300 bg-gray-100 cursor-not-allowed rounded p-2"/>
            </div>

            <!-- Submit -->
            <div class="md:col-span-2 text-center mt-4">
              <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">
                Save Salary
              </button>
            </div>
          </form>
        </div>
      </main>

    </div>
  </div>

  <script>
    function calculateFinalSalary() {
      const baseSalary = parseFloat(document.getElementById('base_salary').value) || 0;
      const absents = parseInt(document.getElementById('absents').value) || 0;
      const halfDays = parseInt(document.getElementById('half_days').value) || 0;

      const perDaySalary = baseSalary / 30;
      const deductions = (absents * perDaySalary) + (halfDays * (perDaySalary / 2));
      const finalSalary = baseSalary - deductions;

      document.getElementById('final_salary').value = finalSalary.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('salaryForm');

      form.addEventListener('submit', async function (e) {
        e.preventDefault();  // Prevent default form submission

        const formData = new FormData(form);

        try {
          // Send AJAX request to the Laravel backend
          const response = await fetch("{{ route('salary.store') }}", {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData,
          });

          const data = await response.json(); // Parse the JSON response

          if (response.ok) {
            // Show success SweetAlert2 toast notification
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: data.message,
              toast: true,
              position: 'top-end',
              timer: 3000, // Toast display time
              showConfirmButton: false,
              timerProgressBar: true
            });

            // Redirect to the salary page after the toast disappears (3000ms)
            setTimeout(function() {
              window.location.reload();  // Reload the page
            }, 3000); // Wait for the toast to disappear before redirecting

          } else {
            // Handle validation errors
            if (data.errors) {
              Object.values(data.errors).forEach(errorMsg => {
                Swal.fire({
                  icon: 'error',
                  title: 'Validation Error',
                  text: errorMsg,
                  toast: true,
                  position: 'top-end',
                  timer: 3000,
                  showConfirmButton: false,
                  timerProgressBar: true
                });
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong.',
                toast: true,
                position: 'top-end',
                timer: 3000,
                showConfirmButton: false,
                timerProgressBar: true
              });
            }
          }
        } catch (error) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Server error or network issue.',
            toast: true,
            position: 'top-end',
            timer: 3000,
            showConfirmButton: false,
            timerProgressBar: true
          });
          console.error(error);  // Log any errors to the console
        }
      });
    });
  </script>

</body>
</html>
