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

        return [
            'employee_id' => null,
            'bank_name' => $this->faker->randomElement($banks), // Use only the listed banks
            'account_number' => $this->faker->unique()->numerify('##########'), // 12-digit account number
            'account_type' => $this->faker->randomElement(['savings', 'checking']), // Account type can be savings or checking
        ];
    }
}
