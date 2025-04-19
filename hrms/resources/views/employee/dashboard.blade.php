{{-- filepath: c:\Users\sharp\OneDrive\Desktop\Workwise\hrms\resources\views\employee\dashboard.blade.php --}}
<x-layout>
    <div class="p-6 bg-white shadow-md rounded-lg">
        <!-- Welcome Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ auth()->user()->first_name }}!</h1>
            <p class="text-lg text-gray-600">Logged in as: <span class="font-semibold">{{ ucfirst(auth()->user()->role) }}</span></p>
        </div>

        <!-- Buttons Section -->
        <div class="flex gap-5 justify-center text-center items-center mb-8">
            <a href="{{ route('employee.profile') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold rounded">Manage Own Profile</a>
            <a href="{{ route('employee.payslips') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold rounded">Payslips</a>
            <a href="{{ route('employee.requests') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold rounded">Requests</a>
        </div>

        <!-- Time In/Out Section -->
        <div class="p-6 bg-gray-100 rounded shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Time In/Out</h2>
            <p class="text-lg text-gray-700">
                <strong>Current Date:</strong> {{ \Carbon\Carbon::now()->format('F j, Y') }}
            </p>
            <p class="text-lg text-gray-700">
                <strong>Current Time:</strong> <span id="current-time"></span>
            </p>
        </div>
    </div>

    <script>
        // JavaScript to update the running clock
        function updateClock() {
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();
            const ampm = hours >= 12 ? 'pm' : 'am';
            const formattedTime = `${hours % 12 || 12}:${minutes.toString().padStart(2, '0')} ${ampm}`;
            document.getElementById('current-time').textContent = formattedTime;
        }

        setInterval(updateClock, 1000); // Update the clock every second
        updateClock(); // Initialize the clock immediately
    </script>
</x-layout>