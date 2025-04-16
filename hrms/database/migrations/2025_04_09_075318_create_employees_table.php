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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('gender');
            $table->date('birthdate');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->string('address');
            $table->string('emergency_contact_number');
            $table->string('password');
            $table->rememberToken();
            $table->enum('role', ['employee', 'hr', 'manager']);
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
