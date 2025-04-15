@props(['employee', 'name', 'title'])

<div
    x-data="{ show: false, name: '{{ $name }}' }"
    x-show="show"
    x-on:open-modal.window="show = ($event.detail.name === name)"
    x-on:close-modal.window="show = false"
    x-on:keydown.escape.window="show = false"
    style="display: none;"
    x-transition.duration.100ms
    class="fixed z-50 inset-0 flex items-center justify-center"
>
    <!-- Overlay -->
    <div x-on:click="show = false" class="fixed inset-0 bg-gray-400 opacity-70"></div>

    <!-- Modal Content -->
    <div class="bg-white rounded-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto p-6 relative z-10">
        <livewire:employee-modal :employee="$employee" />   


    </div>
</div>
        {{-- <!-- Close Button -->
        <button class="absolute top-4 right-4 text-red-600 font-bold text-lg" x-on:click="$dispatch('close-modal')">✖</button>

        <h2 class="text-2xl font-bold mb-4">{{ $title }}</h2>
        <h3 class="font-semibold text-lg mb-2 text-teal-500">Work Information</h3>
        <!-- Personal Info -->
        <div class="grid grid-cols-2 gap-4 mb-6 ">
            <div><strong>First Name:</strong> {{ $employee->first_name }}</div>
            <div><strong>Last Name:</strong> {{ $employee->last_name }}</div>
            <div><strong>Middle Name:</strong> {{ $employee->middle_name }}</div>
            <div><strong>Suffix:</strong> {{ $employee->suffix }}</div>
            <div><strong>Gender:</strong> {{ $employee->gender }}</div>
            <div><strong>Birthdate:</strong> {{ $employee->birthdate }}</div>
            <div><strong>Email:</strong> {{ $employee->email }}</div>
            <div><strong>Phone:</strong> {{ $employee->phone_number }}</div>
            <div><strong>Address:</strong> {{ $employee->address }}</div>
            <div><strong>Marital Status:</strong> {{ $employee->marital_status }}</div>
            <div><strong>Emergency Contact:</strong> {{ $employee->emergency_contact_number }}</div>
            <div><strong>Role:</strong> {{ $employee->role }}</div>
        </div>

        <!-- Work Info -->
        @if($employee->workInfo)
        <h3 class="font-semibold text-lg mb-2 text-teal-500">Work Information</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div><strong>Department:</strong> {{ $employee->workInfo->department }}</div>
            <div><strong>Position:</strong> {{ $employee->workInfo->position }}</div>
            <div><strong>Status:</strong> {{ $employee->workInfo->work_status }}</div>
            <div><strong>Hire Date:</strong> {{ $employee->workInfo->hire_date }}</div>
        </div>
        @endif

        <!-- Bank Info -->
        @if($employee->bankInfo)
        <h3 class="font-semibold text-lg mb-2 text-teal-500">Bank Information</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div><strong>Bank Name:</strong> {{ $employee->bankInfo->bank_name }}</div>
            <div><strong>Account Number:</strong> {{ $employee->bankInfo->account_number }}</div>
            <div><strong>Account Type:</strong> {{ $employee->bankInfo->account_type }}</div>
        </div>
        @endif

        <!-- Identification Info -->
        @if($employee->identificationInfo)
        <h3 class="font-semibold text-lg mb-2 text-teal-500">Identification Numbers</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div><strong>SSS:</strong> {{ $employee->identificationInfo->sss_number }}</div>
            <div><strong>Pag-IBIG:</strong> {{ $employee->identificationInfo->pag_ibig_number }}</div>
            <div><strong>PhilHealth:</strong> {{ $employee->identificationInfo->philhealth_number }}</div>
            <div><strong>TIN:</strong> {{ $employee->identificationInfo->tin_number }}</div>
        </div>
        @endif

        <!-- Loan Info -->
        @if($employee->loanInfo && $employee->loanInfo->count())
        <h3 class="font-semibold text-lg mb-2 text-teal-500">Loans</h3>
        <div class="space-y-2">
            @foreach($employee->loanInfo as $loan)
                <div class="border p-4 rounded bg-gray-100">
                    <p><strong>Type:</strong> {{ $loan->loan_type }}</p>
                    <p><strong>Amount:</strong> ₱{{ number_format($loan->loan_amount, 2) }}</p>
                    <p><strong>Monthly Amortization:</strong> ₱{{ number_format($loan->monthly_amortization, 2) }}</p>
                </div>
            @endforeach
        </div>
        @endif --}}
    
