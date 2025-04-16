<x-layout>

    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Payroll Deduction Settings</h2>
            <a href="{{ route('hr.show-payroll') }}" class="text-blue-600 hover:underline text-sm">← Back to Payroll</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('hr.update-payroll-deductions') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-medium">SSS Rate (%)</label>
                <input type="number" step="0.0001" name="sss_rate" class="w-full border p-2 rounded" value="{{ $settings->sss_rate * 100 }}">
            </div>

            <div class="mb-4">
                <label class="block font-medium">PhilHealth Rate (%)</label>
                <input type="number" step="0.0001" name="philhealth_rate" class="w-full border p-2 rounded" value="{{ $settings->philhealth_rate * 100 }}">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Pag-IBIG (₱)</label>
                <input type="number" step="0.01" name="pagibig_fixed" class="w-full border p-2 rounded" value="{{ $settings->pagibig_fixed }}">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Withholding Tax Rate (%)</label>
                <input type="number" step="0.0001" name="withholding_tax_rate" class="w-full border p-2 rounded" value="{{ $settings->withholding_tax_rate * 100 }}">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Settings</button>
        </form>
    </div>

</x-layout>
