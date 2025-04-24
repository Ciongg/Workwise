<?php

namespace Database\Seeders;
use App\Models\PayrollDeductionSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PayrollDeductionSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PayrollDeductionSetting::firstOrCreate([], [
            'sss_rate' => 0.045,
            'philhealth_rate' => 0.03,
            'pagibig_rate' => 0.01,
            'withholding_tax_rate' => 0.1,
        ]);

    }
}
