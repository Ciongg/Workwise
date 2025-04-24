{{-- filepath: c:\Users\sharp\OneDrive\Desktop\Workwise\hrms\resources\views\livewire\employee\employee-payslip.blade.php --}}
<x-layout>
    <div class="p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Payslips</h2>

        @php
            // Only show approved payslips
            $approvedPayslips = $payslips->whereIn('status', ['approved', 'paid']);
        @endphp

        @forelse ($approvedPayslips as $payslip)
            <div x-data="{ open: false, showDetails: false }" class="mb-4 border rounded shadow">
                <!-- Payslip Header -->
                <div class="p-4 bg-gray-100 flex justify-between items-center cursor-pointer" x-on:click="open = !open">
                    <div>
                        <p class="font-bold text-gray-800">Payslip ID: {{ $payslip->id }}</p>
                        <p class="text-sm text-gray-600">
                            Period: {{ \Carbon\Carbon::parse($payslip->pay_period_start)->format('F j, Y') }} - 
                            {{ \Carbon\Carbon::parse($payslip->pay_period_end)->format('F j, Y') }}
                        </p>
                    </div>
                    <div>
                        <span x-show="!open" class="text-gray-500">▼</span>
                        <span x-show="open" class="text-gray-500">▲</span>
                    </div>
                </div>

                <!-- Payslip Overview -->
                <div x-show="open" x-transition class="p-4 bg-white">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <strong>Allowance:</strong> ₱{{ number_format($payslip->allowance, 2) }}
                        </div>
                        <div>
                            <strong>Overtime Pay:</strong> ₱{{ number_format($payslip->overtime_pay, 2) }}
                        </div>
                        <div>
                            <strong>Gross Pay:</strong> ₱{{ number_format($payslip->gross_pay, 2) }}
                        </div>
                        <div>
                            <strong>Total Deductions:</strong> ₱{{ number_format($payslip->deductions, 2) }}
                        </div>
                        <div>
                            <strong>Additional Deductions:</strong> ₱{{ number_format($payslip->additional_deductions, 2) }}
                        </div>
                        <div>
                            <strong>Net Pay:</strong> ₱{{ number_format($payslip->net_pay, 2) }}
                        </div>
                        <div>
                            <strong>Status:</strong> {{ ucfirst($payslip->status) }}
                        </div>
                    </div>

                    <!-- Expandable Detailed Breakdown -->
                    <div class="mt-4">
                        <button x-on:click="showDetails = !showDetails" class="text-teal-500 hover:underline font-bold">
                            <span x-show="!showDetails">View Detailed Breakdown</span>
                            <span x-show="showDetails">Hide Detailed Breakdown</span>
                        </button>
                        <div x-show="showDetails" x-transition class="mt-4 bg-gray-50 p-4 rounded shadow">
                            <!-- Deductions Section -->
                            <h3 class="text-lg font-semibold text-teal-500 mb-2">Deductions</h3>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <strong>SSS Deduction:</strong> ₱{{ number_format($payslip->deductions_breakdown['sss'], 2) }}
                                </div>
                                <div>
                                    <strong>PhilHealth Deduction:</strong> ₱{{ number_format($payslip->deductions_breakdown['philhealth'], 2) }}
                                </div>
                                <div>
                                    <strong>Pag-IBIG Deduction:</strong> ₱{{ number_format($payslip->deductions_breakdown['pagibig'], 2) }}
                                </div>
                                <div>
                                    <strong>Withholding Tax:</strong> ₱{{ number_format($payslip->deductions_breakdown['withholding_tax'], 2) }}
                                </div>
                                <div>
                                    <strong>Total Deductions:</strong> ₱{{ number_format($payslip->deductions, 2) }}
                                </div>
                            </div>

                            <!-- Employee Information Section -->
                            <h3 class="text-lg font-semibold text-teal-500 mb-2">Employee Information</h3>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <strong>Department:</strong> {{ $payslip->employee->workInfo->department ?? 'N/A' }}
                                </div>
                                <div>
                                    <strong>Position:</strong> {{ $payslip->employee->workInfo->position ?? 'N/A' }}
                                </div>
                                <div>
                                    <strong>Basic Salary:</strong> ₱{{ number_format($payslip->employee->workInfo->salary ?? 0, 2) }}
                                </div>
                            </div>

                            <!-- Bank Information Section -->
                            <h3 class="text-lg font-semibold text-teal-500 mb-2">Bank Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <strong>Bank Name:</strong> {{ $payslip->employee->bankInfo->bank_name ?? 'N/A' }}
                                </div>
                                <div>
                                    <strong>Account Number:</strong> {{ $payslip->employee->bankInfo->account_number ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-600">No approved payslips available.</p>
        @endforelse
    </div>
</x-layout>