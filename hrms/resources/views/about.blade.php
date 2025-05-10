<x-layout>
    <div class="bg-white min-h-screen text-gray-700">
        <!-- About Us Section -->
        <section class="text-center py-16 bg-teal-50">
            <h1 class="text-4xl font-bold text-teal-600 mb-4">About WorkWise</h1>
            <p class="max-w-3xl mx-auto text-lg">
                WorkWise is a modern HR and employee management system designed to bring transparency, accuracy, and automation to your workplace. From real-time attendance to easy access to payslips and payroll summaries, we empower both HR teams and employees alike.
            </p>
            <p class="max-w-3xl mx-auto mt-4 text-lg">
                Whether you're managing employee records or simply checking your daily time-in/out logs, WorkWise provides a secure and efficient platform that reduces manual work while increasing visibility for all.
            </p>
        </section>

        <!-- Services Section -->
        <section class="py-16 bg-white">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-teal-600">Our Services</h2>
                <p class="text-gray-600 mt-2">Empowering HR and employees with modern solutions.</p>
            </div>
            <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
                @php
                    $services = [
                        ['title' => 'Real-Time Attendance Tracking', 'desc' => 'Track employee work hours, late arrivals, and overtime with ease.'],
                        ['title' => 'Payslip Transparency', 'desc' => 'Employees can clearly view their salary breakdown, deductions, bonuses, and net pay.'],
                        ['title' => 'Comprehensive Payroll Management', 'desc' => 'Automated calculations of salaries, overtime, and deductions.'],
                        ['title' => 'Employee Record Management', 'desc' => 'Centralized access to all employee work data and updates.'],
                        ['title' => 'Compliance & Deductions Management', 'desc' => 'Ensure legal compliance and manage benefits and government contributions.'],
                        ['title' => 'Mobile & Web Accessibility', 'desc' => 'Use WorkWise across devices, anytime, anywhere.'],
                    ];
                @endphp

                @foreach ($services as $service)
                    <div class="bg-teal-100 p-6 rounded-xl shadow-md hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold text-teal-700 mb-2">{{ $service['title'] }}</h3>
                        <p class="text-gray-700">{{ $service['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Extra Info -->
        <section class="py-16 bg-teal-50 text-center">
            <div class="max-w-4xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-teal-600 mb-4">Empowering Everyone Through Transparency</h2>
                <p class="text-lg text-gray-700">
                    WorkWise isn't just about easing the HR workload — it's about giving employees clarity over their records, pay, and time logs. We’re building a workplace where data is accessible, processes are automated, and trust is the standard.
                </p>
                <p class="mt-4 text-lg text-gray-700">
                    With built-in automation, audit trails, and secure role-based access, we ensure that every stakeholder has what they need — when they need it.
                </p>
                <p class="mt-4 text-lg text-teal-700 font-semibold">
                    Join us in shaping the future of work, where fairness and transparency are always on time.
                </p>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="bg-white py-16 border-t border-gray-200">
            <div class="max-w-4xl mx-auto text-center px-4">
                <h2 class="text-3xl font-bold text-teal-600 mb-4">Contact Us</h2>
                <p class="text-gray-600 mb-6">We’d love to hear from you! Reach out to us through the following channels:</p>

                <div class="flex flex-col sm:flex-row sm:justify-center gap-6 text-left">
                    <div class="bg-teal-100 p-6 rounded-xl shadow-md w-full sm:w-1/3">
                        <h3 class="text-lg font-semibold text-teal-700 mb-2">Email</h3>
                        <p class="text-gray-700">support@workwise.com</p>
                    </div>
                    <div class="bg-teal-100 p-6 rounded-xl shadow-md w-full sm:w-1/3">
                        <h3 class="text-lg font-semibold text-teal-700 mb-2">Phone</h3>
                        <p class="text-gray-700">+63 912 345 6789</p>
                    </div>
                    <div class="bg-teal-100 p-6 rounded-xl shadow-md w-full sm:w-1/3">
                        <h3 class="text-lg font-semibold text-teal-700 mb-2">Address</h3>
                        <p class="text-gray-700">123 Business Lane, Makati City, Metro Manila, Philippines</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layout>
