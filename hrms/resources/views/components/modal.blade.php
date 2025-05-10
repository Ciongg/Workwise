@props(['employee', 'name', 'title', 'modalKey', 'request', 'attendance', 'archivedPayroll'])

<div
    x-data="{ show: false, name: '{{ $name }}' }"
    x-init="
        window.addEventListener('open-modal', e => {
            if (e.detail.name === name) show = true
        });
        window.addEventListener('close-modal', e => show = false);
    "
    x-show="show"
    x-on:keydown.escape.window="show = false"
    style="display: none;"
    x-transition.duration.100ms
    class="fixed z-50 inset-0 flex items-center justify-center"
>
    <!-- Overlay -->
    <div x-on:click="show = false" class="fixed inset-0 bg-gray-400 opacity-70"></div>

    <!-- Modal Content -->
    <div class="bg-white rounded-lg w-full max-w-3xl h-[700px] flex flex-col relative z-10">
        <div class="p-6 flex-shrink-0">
            {{-- Place your modal header/buttons here --}}
            @if(isset($title))
                <h2 class="text-xl font-bold mb-2">{{ $title }}</h2>
            @endif
            {{-- You can add buttons here if needed --}}
        </div>
        <div class="flex-1 overflow-y-auto p-6 pt-0">
            @if($name === 'view-employee')
                <livewire:employee-modal :employee="$employee" :key="$employee->id" />
            @elseif($name === 'view-employee-payroll')
                <livewire:employee-payroll-modal :employee="$employee" :key="$modalKey" />
            @elseif($name === 'view-employee-request')
                <livewire:employee-request-modal :request="$request" :key="$modalKey" />
            @elseif($name === 'view-attendance')
                <livewire:employee-attendance-modal :attendance="$attendance" :key="$modalKey" />
            @elseif($name === 'create-attendance')
                <livewire:attendance-create-modal :key="$modalKey" />
            @elseif($name === 'overtime-log')
                <livewire:overtime-log-modal :request="$request" :key="$modalKey"  />
            @elseif($name === 'view-employee-archived-payroll')
                <livewire:archived-payroll-modal :archivedPayroll="$archivedPayroll" :key="$modalKey" />
            @endif
        </div>
    </div>
</div>
