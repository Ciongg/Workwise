<x-layout>
    Dashboard
    

    
        <div class="flex gap-5 justify-center text-center items-center p-12">
            <a href="{{ route('hr.create-employee') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold">Create Employee</a>
        <a href="{{ route('hr.show-employees') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold">Employees</a>
        
        <button class=" cursor-pointer bg-gray-400 shadowm-md p-4 text-white font-bold">Payroll System</button>
        <button class=" cursor-pointer bg-gray-400 shadowm-md p-4 text-white font-bold">Payslip Generation</button>
        <button class=" cursor-pointer bg-gray-400 shadowm-md p-4 text-white font-bold">Employee Requests</button>
    </div>
</x-layout>