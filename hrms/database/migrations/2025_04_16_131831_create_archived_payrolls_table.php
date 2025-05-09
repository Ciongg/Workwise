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
        Schema::create('archived_payrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->softDeletes();
            $table->date('pay_period_start');
            $table->date('pay_period_end');
            $table->decimal('salary');
            $table->decimal('allowance', 10, 2)->default(0);
            $table->decimal('overtime_pay', 10, 2)->default(0);
            $table->decimal('gross_pay', 10, 2);
            $table->decimal('deductions', 10, 2);
            $table->decimal('additional_deductions', 10, 2);
            $table->decimal('net_pay', 10, 2);
            $table->enum('status', ['pending', 'paid', 'approved'])->default('paid');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_payrolls');
    }
};
