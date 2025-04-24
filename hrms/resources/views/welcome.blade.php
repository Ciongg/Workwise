<x-layout>
    <div class="bg-white min-h-screen flex items-center justify-center px-4">
        <div class="text-center bg-teal-50 rounded-2xl shadow-xl p-10 max-w-md w-full">
            <h1 class="text-4xl font-bold text-teal-600 mb-4">Welcome to WorkWise</h1>
            <p class="text-gray-700 mb-8 text-lg">Your all-in-one HR and employee management system.</p>
            <a href="{{ route('login') }}">
                <button class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-6 py-2 rounded-xl transition duration-200">
                    Login
                </button>
            </a>
        </div>
    </div>
</x-layout>
