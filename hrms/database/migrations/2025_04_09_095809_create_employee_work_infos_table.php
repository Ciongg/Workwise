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
        Schema::create('employee_work_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->enum('work_status', ['full_time', 'part_time', 'contract']);
            $table->string('department');
            $table->string('position');
            $table->decimal('salary');
            $table->date('hire_date');
            $table->time('work_start_time');
            $table->time('work_end_time');
            $table->time('break_start_time')->nullable();
            $table->time('break_end_time')->nullable();

            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_work_infos');
    }
};
