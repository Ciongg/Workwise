<x-layout>
    Dashboard
    

    
        <div class="flex gap-5 justify-center text-center items-center p-12">
            <a href="{{ route('hr.create-employee') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold">Create Employee</a>
        <a href="{{ route('hr.show-employees') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold">Employees</a>
        <a href="{{ route('hr.show-payroll') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold">Payroll System</a>
        <a href="{{ route('hr.show-requests') }}" class="cursor-pointer bg-gray-400 shadow-md p-4 text-white font-bold">Employee Requests</a>
       
        
    

    </div>
</x-layout>