<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Personal Info -->
    <h2 class="text-2xl font-semibold mb-4">Edit Employee</h2>
    <button
                                wire:click="confirmDelete({{ $employee->id }})"
                                class="ml-2 bg-red-500 text-white px-3 py-2 rounded text-xs hover:bg-red-600"
                                onclick="return confirm('Are you sure you want to delete this employee? This action cannot be undone.')">
                                Delete
                            </button>
    <form wire:submit.prevent="save">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Personal Information</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input id="first_name" wire:model.defer="first_name" type="text" class="border rounded px-3 py-2 w-full" placeholder="First Name">
                @error('first_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input id="last_name" wire:model.defer="last_name" type="text" class="border rounded px-3 py-2 w-full" placeholder="Last Name">
                @error('last_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                <input id="middle_name" wire:model.defer="middle_name" type="text" class="border rounded px-3 py-2 w-full" placeholder="Middle Name">
                @error('middle_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="suffix" class="block text-sm font-medium text-gray-700">Suffix</label>
                <input id="suffix" wire:model.defer="suffix" type="text" class="border rounded px-3 py-2 w-full" placeholder="Suffix">
                @error('suffix') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select id="gender" wire:model.defer="gender" class="border rounded px-3 py-2 w-full">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                @error('gender') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="birthdate" class="block text-sm font-medium text-gray-700">Birthdate</label>
                <input id="birthdate" wire:model.defer="birthdate" type="date" class="border rounded px-3 py-2 w-full">
                @error('birthdate') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input id="phone_number" wire:model.defer="phone_number" type="text" maxlength="11" placeholder="09123456789" class="border rounded px-3 py-2 w-full">
                @error('phone_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="emergency_contact_number" class="block text-sm font-medium text-gray-700">Emergency Contact</label>
                <input id="emergency_contact_number" wire:model.defer="emergency_contact_number" type="text" maxlength="11" placeholder="09987654321" class="border rounded px-3 py-2 w-full">
                @error('emergency_contact_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="marital_status" class="block text-sm font-medium text-gray-700">Marital Status</label>
                <select id="marital_status" wire:model.defer="marital_status" class="border rounded px-3 py-2 w-full">
                    <option value="">Select Marital Status</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="divorced">Divorced</option>
                    <option value="widowed">Widowed</option>
                </select>
                @error('marital_status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input id="address" wire:model.defer="address" type="text" placeholder="Address" class="border rounded px-3 py-2 w-full">
                @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select id="role" wire:model.defer="role" class="border rounded px-3 py-2 w-full">
                    <option value="">Select Role</option>
                    <option value="employee">Employee</option>
                    <option value="hr">HR</option>
                </select>
                @error('role') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Work Info -->
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Work Information</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                <select id="department" wire:model.live="department" class="border rounded px-3 py-2 w-full">
                    <option value="">Select Department</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                    @endforeach
                </select>
                @error('department') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                <select id="position" wire:model.live="position" class="border rounded px-3 py-2 w-full" {{ empty($positions) ? 'disabled' : '' }}>
                    <option value="">Select Position</option> <!-- Default option -->
                    @foreach ($positions as $pos)
                        <option value="{{ $pos }}">{{ $pos }}</option>
                    @endforeach
                </select>
                @error('position') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                <input id="salary" type="number" wire:model.live="salary" class="border rounded px-3 py-2 w-full" placeholder="Enter salary between ₱{{ $min_salary }} and ₱{{ $max_salary }}">
                @error('salary') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                @if ($min_salary && $max_salary)
                    <p class="text-sm text-gray-500 mb-1">
                        Salary Range: ₱{{ number_format($min_salary) }} - ₱{{ number_format($max_salary) }}
                    </p>
                @endif
            </div>
            <div>
                <label for="work_status" class="block text-sm font-medium text-gray-700">Work Status</label>
                <select id="work_status" wire:model.defer="work_status" class="border rounded px-3 py-2 w-full">
                    <option value="">Select Work Status</option>
                    <option value="full_time">Full-Time</option>
                    <option value="part_time">Part-Time</option>
                    <option value="contract">Contract</option>
                </select>
                @error('work_status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date</label>
                <input id="hire_date" wire:model.defer="hire_date" type="date" class="border rounded px-3 py-2 w-full">
                @error('hire_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Work Schedule -->
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Work Schedule</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="work_start_time" class="block text-sm font-medium text-gray-700">Work Start Time</label>
                <input type="time" id="work_start_time" wire:model.defer="work_start_time" class="border rounded px-3 py-2 w-full">
                @error('work_start_time') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="work_end_time" class="block text-sm font-medium text-gray-700">Work End Time</label>
                <input type="time" id="work_end_time" wire:model.defer="work_end_time" class="border rounded px-3 py-2 w-full">
                @error('work_end_time') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="break_start_time" class="block text-sm font-medium text-gray-700">Break Start Time</label>
                <input type="time" id="break_start_time" wire:model.defer="break_start_time" class="border rounded px-3 py-2 w-full">
                @error('break_start_time') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="break_end_time" class="block text-sm font-medium text-gray-700">Break End Time</label>
                <input type="time" id="break_end_time" wire:model.defer="break_end_time" class="border rounded px-3 py-2 w-full">
                @error('break_end_time') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Bank Information -->
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Bank Information</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                <select id="bank_name" wire:model.defer="bank_name" class="border rounded px-3 py-2 w-full">
                    <option value="">Select Bank</option>
                    <option value="BDO">BDO</option>
                    <option value="BPI">BPI</option>
                    <option value="Metrobank">Metrobank</option>
                    <option value="Landbank">Landbank</option>
                    <option value="PNB">PNB</option>
                    <option value="Chinabank">Chinabank</option>
                    <option value="RCBC">RCBC</option>
                    <option value="UnionBank">UnionBank</option>
                    <option value="EastWest">EastWest</option>
                    <option value="SecurityBank">Security Bank</option>
                    <option value="UCPB">UCPB</option>
                    <option value="DBP">DBP</option>
                    <option value="PSBank">PSBank</option>
                </select>
                @error('bank_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="account_number" class="block text-sm font-medium text-gray-700">Account Number</label>
                <input id="account_number" wire:model.defer="account_number" maxlength="13" type="text" class="border rounded px-3 py-2 w-full" placeholder="Account Number 10-13 digits">
                @error('account_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="account_type" class="block text-sm font-medium text-gray-700">Account Type</label>
                <select id="account_type" wire:model.defer="account_type" class="border rounded px-3 py-2 w-full">
                    <option value="">Select Account Type</option>
                    <option value="checking">Checking</option>
                    <option value="savings">Savings</option>
                </select>
                @error('account_type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Identification Numbers -->
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Identification Numbers</h3>
        <div class="grid grid-cols-2 gap-4">
            <div x-data="{ sss_number: @entangle('sss_number') }">
                <label for="sss_number" class="block text-sm font-medium text-gray-700">SSS Number</label>
                <input id="sss_number" x-model="sss_number" type="text" class="border rounded px-3 py-2 w-full" placeholder="34-1234567-8" maxlength="12"
                    @input="sss_number = sss_number.replace(/\D/g, '').replace(/^(\d{2})(\d{0,7})(\d{0,1}).*/, '$1-$2-$3')">
                @error('sss_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div x-data="{ pag_ibig_number: @entangle('pag_ibig_number') }">
                <label for="pag_ibig_number" class="block text-sm font-medium text-gray-700">Pag-IBIG Number</label>
                <input id="pag_ibig_number" x-model="pag_ibig_number" type="text" class="border rounded px-3 py-2 w-full" placeholder="1234-5678-9123" maxlength="14"
                    @input="pag_ibig_number = pag_ibig_number.replace(/\D/g, '').replace(/^(\d{4})(\d{0,4})(\d{0,4}).*/, '$1-$2-$3')">
                @error('pag_ibig_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div x-data="{ philhealth_number: @entangle('philhealth_number') }">
                <label for="philhealth_number" class="block text-sm font-medium text-gray-700">PhilHealth Number</label>
                <input id="philhealth_number" x-model="philhealth_number" type="text" class="border rounded px-3 py-2 w-full" placeholder="1234-56789-00" maxlength="13"
                    @input="philhealth_number = philhealth_number.replace(/\D/g, '').replace(/^(\d{4})(\d{0,5})(\d{0,2}).*/, '$1-$2-$3')">
                @error('philhealth_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div x-data="{ tin_number: @entangle('tin_number') }">
                <label for="tin_number" class="block text-sm font-medium text-gray-700">TIN Number</label>
                <input id="tin_number" x-model="tin_number" type="text" class="border rounded px-3 py-2 w-full" placeholder="123-456-789-000" maxlength="15"
                    @input="tin_number = tin_number.replace(/\D/g, '').replace(/^(\d{3})(\d{0,3})(\d{0,3})(\d{0,3}).*/, '$1-$2-$3-$4')">
                @error('tin_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Save Button -->
        <div class="mt-6">
            <button type="submit" class="w-full sm:w-auto py-2 px-6 bg-teal-500 text-white font-semibold rounded-md shadow-md hover:bg-teal-600 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
                Save Changes
            </button>
        </div>
    </form>
</div>
