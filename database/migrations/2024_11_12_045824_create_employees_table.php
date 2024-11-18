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
            $table->bigIncrements('id');
            $table->integer('employee_id');
            $table->string('name');
            $table->string('emp_code')->nullable();
            $table->string('card_number')->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->integer('finger_id')->nullable();
            $table->string('card_id')->nullable();
            $table->string('is_active')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
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
