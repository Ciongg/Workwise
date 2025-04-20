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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('date'); // Date of attendance
            $table->time('time_in')->nullable(); // Time in
            $table->time('time_out')->nullable(); // Time out
            $table->decimal('total_hours', 8, 2)->nullable()->after('time_out');
            $table->timestamps();
            $table->enum('status', ['completed', 'auto_timed_out'])->default('completed')->after('total_hours');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
