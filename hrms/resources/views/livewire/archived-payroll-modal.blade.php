<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold mb-4">Edit Archived Payroll</h2>

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Pay Period Start</label>
                <input type="date" wire:model.defer="pay_period_start" class="border rounded p-2 w-full">
                @error('pay_period_start') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Pay Period End</label>
                <input type="date" wire:model.defer="pay_period_end" class="border rounded p-2 w-full">
                @error('pay_period_end') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Allowance</label>
                <input type="number" wire:model.defer="allowance" class="border rounded p-2 w-full">
                @error('allowance') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Overtime Pay</label>
                <input type="number" wire:model.defer="overtime_pay" class="border rounded p-2 w-full">
                @error('overtime_pay') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Gross Pay</label>
                <input type="number" wire:model.defer="gross_pay" class="border rounded p-2 w-full">
                @error('gross_pay') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Deductions</label>
                <input type="number" wire:model.defer="deductions" class="border rounded p-2 w-full">
                @error('deductions') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Additional Deductions</label>
                <input type="number" wire:model.defer="additional_deductions" class="border rounded p-2 w-full">
                @error('additional_deductions') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Net Pay</label>
                <input type="number" wire:model.defer="net_pay" class="border rounded p-2 w-full">
                @error('net_pay') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model.defer="status" class="border rounded p-2 w-full">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                </select>
                @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-6 flex gap-2">
            <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">Save</button>
            <button type="button" wire:click="$dispatch('close-modal')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
        </div>
    </form>
</div>
