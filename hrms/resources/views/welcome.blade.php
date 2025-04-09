<x-layout>
    <div class="flex flex-col justify-center items-center p-12 gap-4">
        <div>
            <p>Welcome Back!</p>
            <p>Login</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="border border-gray-300 rounded p-2">
                <x-form-error name="email"/>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="text" name="password" id="password" class="border border-gray-300 rounded p-2">
                <x-form-error name="password"/>
            </div>

            <button class="cursor-pointer bg-gray-400 rounded-md py-2 px-8" type="submit">Login</button>
        </form>
    </div>
</x-layout>

<script>
    


</script>