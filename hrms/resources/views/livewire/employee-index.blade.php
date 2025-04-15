
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="py-3 px-6 text-left">Employee ID</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Phone</th>
                    <th class="py-3 px-6 text-left">Department</th>
                    <th class="py-3 px-6 text-left">Position</th>
                    <th class="py-3 px-6 text-left">Role</th>
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

                            <x-modal :employee="$employee" name="view-employee-{{ $employee->id }}" title="Employee View">
                            
                            </x-modal>
                            
                            <button x-data x-on:click="$dispatch('open-modal', {name: 'view-employee-{{ $employee->id }}'})" class=" p-4 cursor-pointer px-3 py- 1 bg-teal-500 text-white rounded">View/Edit</button>
                              

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
