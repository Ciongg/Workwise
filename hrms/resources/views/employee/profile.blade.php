{{-- filepath: c:\Users\sharp\OneDrive\Desktop\Workwise\hrms\resources\views\employee\profile.blade.php --}}
<x-layout>
    <div class="p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Manage Profile</h2>

        <!-- Personal Information -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Personal Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <strong>First Name:</strong> {{ $employee->first_name }}
                </div>
                <div>
                    <strong>Last Name:</strong> {{ $employee->last_name }}
                </div>
                <div>
                    <strong>Middle Name:</strong> {{ $employee->middle_name ?? 'N/A' }}
                </div>
                <div>
                    <strong>Gender:</strong> {{ $employee->gender }}
                </div>
                <div>
                    <strong>Birthdate:</strong> {{ \Carbon\Carbon::parse($employee->birthdate)->format('F j, Y') }}
                </div>
                <div>
                    <strong>Email:</strong> {{ $employee->email }}
                </div>
                <div>
                    <strong>Phone Number:</strong> {{ $employee->phone_number }}
                </div>
                <div>
                    <strong>Address:</strong> {{ $employee->address }}
                </div>
                <div>
                    <strong>Marital Status:</strong> {{ ucfirst($employee->marital_status) }}
                </div>
                <div>
                    <strong>Emergency Contact:</strong> {{ $employee->emergency_contact_number }}
                </div>
            </div>
        </div>

        <!-- Work Information -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Work Information</h3>
            @if ($employee->workInfo)
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <strong>Department:</strong> {{ $employee->workInfo->department }}
                    </div>
                    <div>
                        <strong>Position:</strong> {{ $employee->workInfo->position }}
                    </div>
                    <div>
                        <strong>Work Status:</strong> {{ ucfirst($employee->workInfo->work_status) }}
                    </div>
                    <div>
                        <strong>Hire Date:</strong> {{ \Carbon\Carbon::parse($employee->workInfo->hire_date)->format('F j, Y') }}
                    </div>
                    <div>
                        <strong>Work Start Time:</strong> {{ \Carbon\Carbon::parse($employee->workInfo->work_start_time)->format('h:i A') }}
                    </div>
                    <div>
                        <strong>Work End Time:</strong> {{ \Carbon\Carbon::parse($employee->workInfo->work_end_time)->format('h:i A') }}
                    </div>
                    <div>
                        <strong>Break Start Time:</strong> {{ $employee->workInfo->break_start_time ? \Carbon\Carbon::parse($employee->workInfo->break_start_time)->format('h:i A') : 'N/A' }}
                    </div>
                    <div>
                        <strong>Break End Time:</strong> {{ $employee->workInfo->break_end_time ? \Carbon\Carbon::parse($employee->workInfo->break_end_time)->format('h:i A') : 'N/A' }}
                    </div>
                </div>
            @else
                <p class="text-gray-600">No work information available.</p>
            @endif
        </div>

        <!-- Identification Information -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Identification Information</h3>
            @if ($employee->identificationInfo)
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <strong>SSS Number:</strong> {{ $employee->identificationInfo->sss_number }}
                    </div>
                    <div>
                        <strong>Pag-IBIG Number:</strong> {{ $employee->identificationInfo->pag_ibig_number }}
                    </div>
                    <div>
                        <strong>PhilHealth Number:</strong> {{ $employee->identificationInfo->philhealth_number }}
                    </div>
                    <div>
                        <strong>TIN Number:</strong> {{ $employee->identificationInfo->tin_number }}
                    </div>
                </div>
            @else
                <p class="text-gray-600">No identification information available.</p>
            @endif
        </div>

        <!-- Bank Information -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Bank Information</h3>
            @if ($employee->bankInfo)
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <strong>Bank Name:</strong> {{ $employee->bankInfo->bank_name }}
                    </div>
                    <div>
                        <strong>Account Number:</strong> {{ $employee->bankInfo->account_number }}
                    </div>
                    <div>
                        <strong>Account Type:</strong> {{ ucfirst($employee->bankInfo->account_type) }}
                    </div>
                </div>
            @else
                <p class="text-gray-600">No bank information available.</p>
            @endif
        </div>
    </div>
</x-layout>