<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payroll_deduction_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('sss_rate', 5, 4)->default(0.045); // 4.5%
            $table->decimal('philhealth_rate', 5, 4)->default(0.03); // 3%
            $table->decimal('pagibig_fixed', 8, 2)->default(100.00); // fixed amount
            $table->decimal('withholding_tax_rate', 5, 4)->default(0.1); // 10%
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_deduction_settings');
    }
};
