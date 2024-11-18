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
        Schema::create('appearances', function (Blueprint $table) {
            $table->id();
            $table->string('primary')->nullable();
            $table->string('info')->nullable();
            $table->string('error')->nullable();
            $table->string('warning')->nullable();
            $table->string('secondary')->nullable();
            $table->string('success')->nullable();
            $table->string('accent')->nullable();
            $table->string('language')->nullable();
            $table->string('panel')->nullable();
            $table->string('theme')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appearances');
    }
};
