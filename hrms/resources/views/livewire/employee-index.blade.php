<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Employee List</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4 mt-4 mx-6">
        <!-- Filter by Role -->
        <div class="mb-4 flex items-center gap-4">
            <label class="text-gray-600">Filter by Role:</label>
            <select wire:model.live="searchRole" class="border rounded p-2">
                <option value="">All</option>
                <option value="hr">HR</option>
                <option value="manager">Manager</option>
                <option value="employee">Employee</option>
            </select>
        </div>
        <!-- Filter by Name -->
        <div class="mb-4 flex items-center gap-4">
            <label class="text-gray-600">Filter by Name:</label>
            <input type="text" wire:model.live="searchName" placeholder="Search by name" class="border rounded p-2">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600 text-center">
                <tr class="bg-gray-200 text-gray-700">
                    <th class="py-3 px-6 text-center border cursor-pointer" wire:click="sortBy('id')">
                        Employee ID
                        <span class="{{ $sortField === 'id' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'id' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    
                    <th class="py-3 px-6 text-center border cursor-pointer" wire:click="sortBy('first_name')">
                        Name
                        <span class="{{ $sortField === 'first_name' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'first_name' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    
                    <th class="py-3 px-6 text-center border cursor-pointer" wire:click="sortBy('email')">
                        Email
                        <span class="{{ $sortField === 'email' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'email' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>
                    <th class="py-3 px-6 text-center border">Phone</th>
                    <th class="py-3 px-6 text-center border">Department</th>
                    <th class="py-3 px-6 text-center border">Position</th>
                    <th class="py-3 px-6 text-center border cursor-pointer" wire:click="sortBy('role')">
                        Role
                        <span class="{{ $sortField === 'role' ? 'text-black' : 'text-gray-400' }}">
                            {{ $sortField === 'role' ? ($sortDirection === 'asc' ? '▲' : '▼') : '⇅' }}
                        </span>
                    </th>                    
                    <th class="py-3 px-6 text-center border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr class="hover:bg-gray-100 transition-colors text-center">
                        <td class="px-4 py-2 border">{{ $employee->id }}</td>
                        <td class="px-4 py-2 border">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td class="px-4 py-2 border">{{ $employee->email }}</td>
                        <td class="px-4 py-2 border">{{ $employee->phone_number }}</td>
                        <td class="px-4 py-2 border">{{ $employee->workInfo->department }}</td>
                        <td class="px-4 py-2 border">{{ $employee->workInfo->position }}</td>
                        <td class="px-4 py-2 border">{{ $employee->role }}</td>
                        <td class="px-4 py-2 border">
                            <a 
                                wire:click="selectEmployee({{ $employee->id }})"
                                x-data 
                                x-on:click="$dispatch('open-modal', {name: 'view-employee'})"
                                class="text-teal-500 hover:underline font-bold cursor-pointer transition duration-200 ease-in-out">
                                View/Edit
                            </a>
                            <button
                                wire:click="confirmDelete({{ $employee->id }})"
                                class="ml-2 bg-red-500 text-white px-3 py-2 rounded text-xs hover:bg-red-600"
                                onclick="return confirm('Are you sure you want to delete this employee? This action cannot be undone.')">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="py-3">
            {{ $employees->links() }}
        </div>


        @if ($selectedEmployee)
        <x-modal :employee="$selectedEmployee" name="view-employee" title="Employee View"  :modalKey="$modalKey"/>
        @endif
    </div>
</div>
