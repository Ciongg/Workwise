
    <div class="overflow-x-auto">

        <div class="flex justify-between items-center mb-4">

            <div class="mb-4 flex items-center gap-4">
                <label class="text-gray-600">Filter by Role:</label>
                <select wire:model.live="searchRole" class="border rounded p-2">
                    <option value="">All</option>
                    <option value="hr">HR</option>
                    <option value="manager">Manager</option>
                    <option value="employee">Employee</option>
                </select>
            </div>
            <div class="mb-4 flex items-center gap-4">
                <label class="text-gray-600">Filter by Role:</label>
                <input type="text" wire:model.live="searchName" placeholder="Search by name" class="border rounded p-2">
            </div>
            
        </div>
        
       
        
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="py-3 px-6 text-left cursor-pointer" wire:click="sortBy('id')">
                        Employee ID
                        @if ($sortField === 'id')
                            @if ($sortDirection === 'asc') ▲ @else ▼ @endif
                        @endif
                    </th>
                    <th class="py-3 px-6 text-left cursor-pointer" wire:click="sortBy('first_name')">
                        Name
                        @if ($sortField === 'first_name')
                            @if ($sortDirection === 'asc') ▲ @else ▼ @endif
                        @endif
                    </th>
                    <th class="py-3 px-6 text-left cursor-pointer" wire:click="sortBy('email')">Email</th>
                    <th class="py-3 px-6 text-left">Phone</th>
                    <th class="py-3 px-6 text-left">Department</th>
                    <th class="py-3 px-6 text-left">Position</th>
                    <th class="py-3 px-6 text-left cursor-pointer" wire:click="sortBy('role')">
                        Role
                        @if ($sortField === 'role')
                            @if ($sortDirection === 'asc') ▲ @else ▼ @endif
                        @endif
                    </th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($employees as $employee)
                    <tr class="border-b">
                        <td class="py-3 px-6">{{ $employee->id }}</td>
                        <td class="py-3 px-6">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td class="py-3 px-6">{{ $employee->email }}</td>
                        <td class="py-3 px-6">{{ $employee->phone_number }}</td>
                        <td class="py-3 px-6">{{ $employee->workInfo->department }}</td>
                        <td class="py-3 px-6">{{ $employee->workInfo->position }}</td>
                        <td class="py-3 px-6">{{ $employee->role }}</td>
                        <td class="py-3 px-6">

                            <button wire:click="selectEmployee({{ $employee->id }})"
                                class="p-2 px-3 bg-teal-500 text-white rounded cursor-pointer hover:bg-teal-600 transition duration-200 ease-in-out">
                            View/Edit
                        </button>

                            {{-- <x-modal :employee="$employee" name="view-employee-{{ $employee->id }}" title="Employee View">
                            
                            </x-modal>
                            
                            <button x-data x-on:click="$dispatch('open-modal', {name: 'view-employee-{{ $employee->id }}'})" class=" p-4 cursor-pointer px-3 py- 1 bg-teal-500 text-white rounded">View/Edit</button>
                               --}}

                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        @if ($selectedEmployee)
        <x-modal :employee="$selectedEmployee" name="view-employee" title="Employee View" />
        @endif

        <div class="py-3">
            {{ $employees->links() }}
        </div>
        
