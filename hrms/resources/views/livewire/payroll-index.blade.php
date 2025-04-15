<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Payroll List</h2>
    <table class="w-full table-auto border">
        <thead class="bg-gray-100">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Allowance</th>
                <th>Overtime Pay</th>
                <th>Gross Pay</th>
                <th>Deductions</th>
                <th>Net Pay</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr class="border-t">
                    <td>{{$employee->id}}</td>
                    <td>{{$employee->first_name}} {{$employee->last_name}}</td>
                    <td>{{$employee->workInfo->department}}</td>
                    <td>{{$employee->workInfo->position}}</td>
                    <td>${{$employee->workInfo->salary}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
