<div class="p-8">
    <h2>Hello World!</h2>
    <div class="flex flex-col gap-4">
        <div>
            <p>Employee ID: {{$employee->id}}</p>
        </div>
        <div>
            {{$employee->first_name}}

        </div>

        <div>

            {{$employee->last_name}}
        </div>

        <div>

            {{ $employee->email }}
        </div>
    </div>

    <button wire:click="closeModal" class="mt-4 text-red-500">Close</button>
</div>
