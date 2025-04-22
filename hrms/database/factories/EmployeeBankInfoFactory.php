<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeBankInfo>
 */
class EmployeeBankInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $banks = [
            'BDO', 'BPI', 'Metrobank', 'Landbank', 'PNB', 
            'Chinabank', 'RCBC', 'UnionBank', 'EastWest', 
            'Security Bank', 'UCPB', 'DBP', 'PSBank'
        ];

        // Assign bank name first
        $bankName = $this->faker->randomElement($banks);

        // Define typical account number lengths per bank
        $accountLengths = [
            'BDO' => [10, 12],
            'BPI' => [10],
            'Metrobank' => [13],
            'Landbank' => [10],
            'PNB' => [12],
            'Chinabank' => [12],
            'RCBC' => [10],
            'UnionBank' => [12],
            'EastWest' => [11, 12],
            'Security Bank' => [13],
            'UCPB' => [12],
            'DBP' => [10],
            'PSBank' => [10],
        ];

        // Pick a random valid length for the selected bank
        $length = $accountLengths[$bankName][array_rand($accountLengths[$bankName])];

        return [
            'employee_id' => null,
            'bank_name' => $bankName,
            'account_number' => $this->faker->unique()->numerify(str_repeat('#', $length)),
            'account_type' => $this->faker->randomElement(['savings', 'checking']),
        ];
    }
}
