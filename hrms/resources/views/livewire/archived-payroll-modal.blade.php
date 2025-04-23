<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold mb-4">Edit Archived Payroll</h2>

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="pay_period_start" class="block text-sm font-medium text-gray-700">Pay Period Start:</label>
                <input disabled type="date" id="pay_period_start" wire:model.defer="pay_period_start" class="cursor-not-allowed mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div>
                <label for="pay_period_end" class="block text-sm font-medium text-gray-700">Pay Period End:</label>
                <input disabled type="date" id="pay_period_end" wire:model.defer="pay_period_end" class="cursor-not-allowed mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div>
                <label for="salary" class="block text-sm font-medium text-gray-700">Basic Salary:</label>
                <input type="number" id="salary" wire:model.defer="salary" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div>
                <label for="allowance" class="block text-sm font-medium text-gray-700">Allowance:</label>
                <input type="number" id="allowance" wire:model.defer="allowance" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div>
                <label for="overtime_pay" class="block text-sm font-medium text-gray-700">Overtime Pay:</label>
                <input type="number" id="overtime_pay" wire:model.defer="overtime_pay" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div>
                <label for="gross_pay" class="block text-sm font-medium text-gray-700">Gross Pay:</label>
                <input type="number" id="gross_pay" wire:model.defer="gross_pay" disabled class="cursor-not-allowed mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                <label for="gross_pay" class="block text-[0.8rem] font-medium text-gray-700">(Basic Salary + Allowance + Overtime Pay):</label>
            </div>
            <div>
                <label for="deductions" class="block text-sm font-medium text-gray-700">Deductions:</label>
                <input type="number" id="deductions" wire:model.defer="deductions" disabled class="cursor-not-allowed mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                <label for="deductions" class="block text-[0.8rem] font-medium text-gray-700">(Mandated SSS + PhilHealth + PagIBIG + Withholding Tax + Extra Deductions):</label>
            </div>
            <div>
                <label for="additional_deductions" class="block text-sm font-medium text-gray-700">Additional Deductions:</label>
                <input type="number" id="additional_deductions" wire:model.defer="additional_deductions" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div>
                <label for="net_pay" class="block text-sm font-medium text-gray-700">Net Pay:</label>
                <input type="number" id="net_pay" wire:model.defer="net_pay" disabled class="cursor-not-allowed mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                <select id="status" wire:model.defer="status" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex gap-2">
            <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">Save</button>
            <button type="button" wire:click="$dispatch('close-modal')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
        </div>
    </form>
</div>
