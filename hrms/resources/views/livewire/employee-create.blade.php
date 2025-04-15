<!-- Gender & Loan Update in Form -->
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
                <input wire:model="email" type="email" placeholder="Email" class="border rounded px-3 py-2 w-full">
                <input wire:model="password" type="password" placeholder="Password" class="border rounded px-3 py-2 w-full">
            </div>

            <!-- Personal Information -->
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Personal Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <input wire:model="first_name" type="text" placeholder="First Name" class="border rounded px-3 py-2 w-full">
                <input wire:model="last_name" type="text" placeholder="Last Name" class="border rounded px-3 py-2 w-full">
                <input wire:model="middle_name" type="text" placeholder="Middle Name" class="border rounded px-3 py-2 w-full">
                <input wire:model="suffix" type="text" placeholder="Suffix" class="border rounded px-3 py-2 w-full">

                <select wire:model="gender" class="border rounded px-3 py-2 w-full">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

                <input wire:model="birthdate" type="date" class="border rounded px-3 py-2 w-full">
                <input wire:model="phone_number" type="text" placeholder="Phone Number" class="border rounded px-3 py-2 w-full">

                <select wire:model="marital_status" class="border rounded px-3 py-2 w-full">
                    <option value="">Select Marital Status</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="divorced">Divorced</option>
                    <option value="widowed">Widowed</option>
                </select>

                <input wire:model="address" type="text" placeholder="Address" class="border rounded px-3 py-2 w-full">
                <input wire:model="emergency_contact_number" type="text" placeholder="Emergency Contact" class="border rounded px-3 py-2 w-full">

                <select wire:model="role" class="border rounded px-3 py-2 w-full">
                    <option value="">Select Role</option>
                    <option value="employee">Employee</option>
                    <option value="hr">HR</option>
                    <option value="manager">Manager</option>
                </select>
            </div>
        </div>

        <!-- Work Info -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Work Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <input wire:model="department" type="text" placeholder="Department" class="border rounded px-3 py-2 w-full">
                <input wire:model="position" type="text" placeholder="Position" class="border rounded px-3 py-2 w-full">

                <select wire:model="work_status" class="border rounded px-3 py-2 w-full">
                    <option value="">Select Work Status</option>
                    <option value="full_time">Full-Time</option>
                    <option value="part_time">Part-Time</option>
                    <option value="contract">Contract</option>
                </select>

                <input wire:model="hire_date" type="date" class="border rounded px-3 py-2 w-full">
            </div>
        </div>

        <!-- Bank Info -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Bank Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <input wire:model="bank_name" type="text" placeholder="Bank Name" class="border rounded px-3 py-2 w-full">
                <input wire:model="account_number" type="text" placeholder="Account Number" class="border rounded px-3 py-2 w-full">
                <input wire:model="account_type" type="text" placeholder="Account Type" class="border rounded px-3 py-2 w-full">
            </div>
        </div>

        <!-- Loan Info -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Loan Information</h3>
            <div class="space-y-4">
                @foreach (['philhealth', 'sss', 'pagibig'] as $type)
                    <div class="grid grid-cols-3 gap-4 items-center">
                        <label class="capitalize text-gray-700">{{ ucfirst($type) }}</label>
                        <input wire:model="loan_amounts.{{ $type }}" type="number" placeholder="Loan Amount" class="border rounded px-3 py-2 w-full">
                        <input wire:model="monthly_amortizations.{{ $type }}" type="number" placeholder="Monthly Amortization" class="border rounded px-3 py-2 w-full">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Identification Info -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Identification Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <input wire:model="sss_number" type="text" placeholder="SSS Number" class="border rounded px-3 py-2 w-full">
                <input wire:model="pag_ibig_number" type="text" placeholder="Pag-IBIG Number" class="border rounded px-3 py-2 w-full">
                <input wire:model="philhealth_number" type="text" placeholder="PhilHealth Number" class="border rounded px-3 py-2 w-full">
                <input wire:model="tin_number" type="text" placeholder="TIN Number" class="border rounded px-3 py-2 w-full">
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Submit
            </button>
        </div>
    </form>
</div>
