<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <!-- Personal Info -->
    <h2 class="text-2xl font-semibold mb-4">Personal Information</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name:</label>
            <input type="text" id="first_name" wire:model.defer="first_name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name:</label>
            <input type="text" id="last_name" wire:model.defer="last_name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name:</label>
            <input type="text" id="middle_name" wire:model.defer="middle_name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="suffix" class="block text-sm font-medium text-gray-700">Suffix:</label>
            <input type="text" id="suffix" wire:model.defer="suffix" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="gender" class="block text-sm font-medium text-gray-700">Gender:</label>
            <select id="gender" wire:model.defer="gender" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                
                <option value="male" {{ old('gender', $gender) === 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $gender) === 'female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
        <div>
            <label for="birthdate" class="block text-sm font-medium text-gray-700">Birthdate:</label>
            <input type="date" id="birthdate" wire:model.defer="birthdate" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
            <input type="email" id="email" wire:model.defer="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number:</label>
            <input type="text" id="phone_number" wire:model.defer="phone_number" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Address:</label>
            <input type="text" id="address" wire:model.defer="address" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="marital_status" class="block text-sm font-medium text-gray-700">Marital Status:</label>
            <select id="marital_status" wire:model.defer="marital_status" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                <option value="single" {{ old('marital_status', $marital_status) === 'single' ? 'selected' : '' }}>Single</option>
                <option value="married" {{ old('marital_status', $marital_status) === 'married' ? 'selected' : '' }}>Married</option>
                <option value="divorced" {{ old('marital_status', $marital_status) === 'divorced' ? 'selected' : '' }}>Divorced</option>
                <option value="widowed" {{ old('marital_status', $marital_status) === 'widowed' ? 'selected' : '' }}>Widowed</option>
            </select>
        </div>
        <div>
            <label for="emergency_contact_number" class="block text-sm font-medium text-gray-700">Emergency Contact:</label>
            <input type="text" id="emergency_contact_number" wire:model.defer="emergency_contact_number" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
            <select id="role" wire:model.defer="role" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                <option value="employee" {{ old('role', $role) === 'employee' ? 'selected' : '' }}>Employee</option>
                <option value="hr" {{ old('role', $role) === 'hr' ? 'selected' : '' }}>HR</option>
                <option value="manager" {{ old('role', $role) === 'manager' ? 'selected' : '' }}>Manager</option>
            </select>
        </div>
    </div>

    <!-- Work Info -->
    <h3 class="text-lg font-semibold text-teal-500 mt-8 mb-2">Work Information</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="department" class="block text-sm font-medium text-gray-700">Department:</label>
            <input type="text" id="department" wire:model.defer="department" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="position" class="block text-sm font-medium text-gray-700">Position:</label>
            <input type="text" id="position" wire:model.defer="position" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="work_start_time" class="block text-sm font-medium text-gray-700">Work Start Time:</label>
            <input type="time" id="work_start_time" wire:model.defer="work_start_time" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="work_end_time" class="block text-sm font-medium text-gray-700">Work End Time:</label>
            <input type="time" id="work_end_time" wire:model.defer="work_end_time" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="break_start_time" class="block text-sm font-medium text-gray-700">Break Start Time:</label>
            <input type="time" id="break_start_time" wire:model.defer="break_start_time" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="break_end_time" class="block text-sm font-medium text-gray-700">Break End Time:</label>
            <input type="time" id="break_end_time" wire:model.defer="break_end_time" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="work_status" class="block text-sm font-medium text-gray-700">Status:</label>
            <select id="work_status" wire:model.defer="work_status" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                <option value="">Select Work Status</option>
                <option value="full_time">Full-Time</option>
                <option value="part_time">Part-Time</option>
                <option value="contract">Contract</option>
            </select>
        </div>
        <div>
            <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date:</label>
            <input type="date" id="hire_date" wire:model.defer="hire_date" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
    </div>

    <!-- Bank Info -->
    <h3 class="text-lg font-semibold text-teal-500 mt-8 mb-2">Bank Information</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name:</label>
            <input type="text" id="bank_name" wire:model.defer="bank_name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="account_number" class="block text-sm font-medium text-gray-700">Account Number:</label>
            <input type="text" id="account_number" wire:model.defer="account_number" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="account_type" class="block text-sm font-medium text-gray-700">Account Type:</label>
            <select id="account_type" wire:model.defer="account_type" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">

                <option value="savings" {{ old('account_type', $account_type) === 'savings' ? 'selected' : '' }}>Savings</option>
                <option value="checking" {{ old('account_type', $account_type) === 'checking' ? 'selected' : '' }}>Checking</option>
            </select>
        </div>
    </div>

    <!-- Identification Info -->
    <h3 class="text-lg font-semibold text-teal-500 mt-8 mb-2">Identification Numbers</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="sss_number" class="block text-sm font-medium text-gray-700">SSS:</label>
            <input type="text" id="sss_number" wire:model.defer="sss_number" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="pag_ibig_number" class="block text-sm font-medium text-gray-700">Pag-IBIG:</label>
            <input type="text" id="pag_ibig_number" wire:model.defer="pag_ibig_number" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="philhealth_number" class="block text-sm font-medium text-gray-700">PhilHealth:</label>
            <input type="text" id="philhealth_number" wire:model.defer="philhealth_number" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
        <div>
            <label for="tin_number" class="block text-sm font-medium text-gray-700">TIN:</label>
            <input type="text" id="tin_number" wire:model.defer="tin_number" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>
    </div>

  

    <!-- Save Button -->
    <div class="mt-6">
        <button wire:click="save" class="w-full sm:w-auto py-2 px-6 bg-teal-500 text-white font-semibold rounded-md shadow-md hover:bg-teal-600 focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
            Save Changes
        </button>
    </div>
</div>
