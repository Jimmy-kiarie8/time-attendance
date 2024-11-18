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
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('timestamp')->nullable();
            $table->dateTime('check_time')->nullable();
            $table->tinyInteger('check_type')->nullable();
            $table->integer('verify_mode')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->tinyInteger('status')->default(1);
            // $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            // $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
