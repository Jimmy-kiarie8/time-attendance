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
        Schema::create('mpesas', function (Blueprint $table) {
            $table->id();
            $table->string('customer_key');
            $table->string('customer_secret');
            $table->string('confirmation_url');
            $table->string('validation_url');
            $table->string('passkey');
            $table->string('short_code');
            $table->string('account_type');
            $table->boolean('registered')->default(false);
            $table->string('environment')->default('local');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mpesas');
    }
};
