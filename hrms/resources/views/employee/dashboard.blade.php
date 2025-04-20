{{-- filepath: c:\Users\sharp\OneDrive\Desktop\Workwise\hrms\resources\views\employee\dashboard.blade.php --}}
<x-layout>
    <div class="p-6 bg-white shadow-md rounded-lg">
        <!-- Welcome Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ auth()->user()->first_name }}!</h1>
            <p class="text-lg text-gray-600">Logged in as: <span class="font-semibold">{{ ucfirst(auth()->user()->role) }}</span></p>
            @if (session()->has('success'))
            <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        </div>

        <!-- Buttons Section -->
        <div class="flex gap-5 justify-center text-center items-center mb-8">
            <a href="{{ route('employee.profile') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold rounded">Manage Own Profile</a>
            <a href="{{ route('employee.payslips') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold rounded">Payslips</a>
            <a href="{{ route('employee.requests') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold rounded">Request HR</a>
            <a href="{{ route('employee.show-request-logs') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold">Request Logs</a>
        </div>

        <!-- Time In/Out Section -->
        <livewire:time-in-out />

        <!-- Set Time Section -->
        <div class="mt-8">
            <livewire:set-time />
        </div>
    </div>
</x-layout>