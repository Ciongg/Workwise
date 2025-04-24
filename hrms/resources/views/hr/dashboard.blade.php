<x-layout>
    <div class="p-6 bg-white shadow-md rounded-lg">
        <!-- Welcome Section -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-teal-600 mb-2">Welcome back, {{ auth()->user()->first_name }}!</h1>
            <p class="text-lg text-gray-600">You are logged in as a <span class="font-semibold text-teal-500">{{ ucfirst(auth()->user()->role) }}</span>.</p>
            
            @if (session()->has('success'))
                <div class="mt-4 bg-green-100 text-green-800 p-3 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- Buttons Section -->
        <div class="flex flex-wrap justify-center gap-6 mb-10">
            <a href="{{ route('hr.create-employee') }}" class="bg-teal-500 hover:bg-teal-600 transition text-white font-semibold py-3 px-6 rounded-lg shadow-md">
                Create Employee
            </a>
            <a href="{{ route('hr.show-employees') }}" class="bg-teal-500 hover:bg-teal-600 transition text-white font-semibold py-3 px-6 rounded-lg shadow-md">
                Employees
            </a>
            <a href="{{ route('hr.show-payroll') }}" class="bg-teal-500 hover:bg-teal-600 transition text-white font-semibold py-3 px-6 rounded-lg shadow-md">
                Payroll System
            </a>
            <a href="{{ route('hr.show-requests') }}" class="bg-teal-500 hover:bg-teal-600 transition text-white font-semibold py-3 px-6 rounded-lg shadow-md">
                Employee Requests
            </a>
            <a href="{{ route('hr.show-attendance') }}" class="bg-teal-500 hover:bg-teal-600 transition text-white font-semibold py-3 px-6 rounded-lg shadow-md">
                Employee Attendance
            </a>
        </div>

        <div class="mb-10">
            <livewire:time-in-out />
        </div>

        <!-- Set Time Section -->
        <div>
            <livewire:set-time />
        </div>
    </div>
    
    </div>
</x-layout>
