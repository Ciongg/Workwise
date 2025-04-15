
<div class="max-w-4xl mx-auto my-4 p-6 bg-gray-50 rounded shadow-lg space-y-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Create Employee</h2>

    @if (session()->has('success'))
        <div class="p-3 bg-green-100 text-green-800 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
       <!-- Login Credentials -->
<div>
    <h3 class="text-lg font-semibold text-gray-700 mb-2">Login Credentials</h3>
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" wire:model="email" type="email" class="border rounded px-3 py-2 w-full" placeholder="Email">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" wire:model="password" type="password" class="border rounded px-3 py-2 w-full" placeholder="Password">
        </div>
    </div>

    <!-- Personal Information -->
    <h3 class="text-lg font-semibold text-gray-700 mb-2">Personal Information</h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input id="first_name" wire:model="first_name" type="text" class="border rounded px-3 py-2 w-full" placeholder="First Name">
        </div>
        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input id="last_name" wire:model="last_name" type="text" class="border rounded px-3 py-2 w-full" placeholder="Last Name">
        </div>
        <div>
            <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
            <input id="middle_name" wire:model="middle_name" type="text" class="border rounded px-3 py-2 w-full" placeholder="Middle Name">
        </div>
        <div>
            <label for="suffix" class="block text-sm font-medium text-gray-700">Suffix</label>
            <input id="suffix" wire:model="suffix" type="text" class="border rounded px-3 py-2 w-full" placeholder="Suffix">
        </div>
        <div>
            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
            <select id="gender" wire:model="gender" class="border rounded px-3 py-2 w-full">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div>
            <label for="birthdate" class="block text-sm font-medium text-gray-700">Birthdate</label>
            <input id="birthdate" wire:model="birthdate" type="date" class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input id="phone_number" wire:model="phone_number" type="text" maxlength="11" placeholder="09123456789" class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label for="emergency_contact_number" class="block text-sm font-medium text-gray-700">Emergency Contact</label>
            <input id="emergency_contact_number" wire:model="emergency_contact_number" type="text" maxlength="11" placeholder="09987654321" class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label for="marital_status" class="block text-sm font-medium text-gray-700">Marital Status</label>
            <select id="marital_status" wire:model="marital_status" class="border rounded px-3 py-2 w-full">
                <option value="">Select Marital Status</option>
                <option value="single">Single</option>
                <option value="married">Married</option>
                <option value="divorced">Divorced</option>
                <option value="widowed">Widowed</option>
            </select>
        </div>
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <input id="address" wire:model="address" type="text" placeholder="Address" class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select id="role" wire:model="role" class="border rounded px-3 py-2 w-full">
                <option value="">Select Role</option>
                <option value="employee">Employee</option>
                <option value="hr">HR</option>
                <option value="manager">Manager</option>
            </select>
        </div>
    </div>
</div>

<!-- Work Info -->
<div>
    <h3 class="text-lg font-semibold text-gray-700 mb-2">Work Information</h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
            <input id="department" wire:model="department" type="text" placeholder="Department" class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
            <input id="position" wire:model="position" type="text" placeholder="Position" class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label for="work_status" class="block text-sm font-medium text-gray-700">Work Status</label>
            <select id="work_status" wire:model="work_status" class="border rounded px-3 py-2 w-full">
                <option value="">Select Work Status</option>
                <option value="full_time">Full-Time</option>
                <option value="part_time">Part-Time</option>
                <option value="contract">Contract</option>
            </select>
        </div>
        <div>
            <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date</label>
            <input id="hire_date" wire:model="hire_date" type="date" class="border rounded px-3 py-2 w-full">
        </div>
    </div>
</div>

<!-- Bank Info -->
<div>
    <h3 class="text-lg font-semibold text-gray-700 mb-2">Bank Information</h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
            <input id="bank_name" wire:model="bank_name" type="text" placeholder="e.g. BDO" class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label for="account_number" class="block text-sm font-medium text-gray-700">Account Number</label>
            <input id="account_number" wire:model="account_number" type="text" maxlength="12" placeholder="123456789012" class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label for="account_type" class="block text-sm font-medium text-gray-700">Account Type</label>
            <input id="account_type" wire:model="account_type" type="text" placeholder="e.g. Savings" class="border rounded px-3 py-2 w-full">
        </div>
    </div>
</div>

<!-- Identification Info -->
<div>
    <h3 class="text-lg font-semibold text-gray-700 mb-2">Identification Information</h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="sss_number" class="block text-sm font-medium text-gray-700">SSS Number</label>
            <input id="sss_number" wire:model="sss_number" type="text" maxlength="12" placeholder="34-5678901-2" class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label for="pag_ibig_number" class="block text-sm font-medium text-gray-700">Pag-IBIG Number</label>
            <input id="pag_ibig_number" wire:model="pag_ibig_number" type="text" maxlength="14" placeholder="1234-5678-9012" class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label for="philhealth_number" class="block text-sm font-medium text-gray-700">PhilHealth Number</label>
            <input id="philhealth_number" wire:model="philhealth_number" type="text" maxlength="14" placeholder="12-123456789-0" class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label for="tin_number" class="block text-sm font-medium text-gray-700">TIN Number</label>
            <input id="tin_number" wire:model="tin_number" type="text" maxlength="15" placeholder="123-456-789-000" class="border rounded px-3 py-2 w-full">
        </div>
    </div>
</div>

<div class="text-right mt-6">
    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
        Submit
    </button>
</div>

    </form>
</div>
