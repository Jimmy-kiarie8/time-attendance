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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('currency')->nullable();
            $table->string('dateFormat')->nullable();
            $table->string('timeZone')->nullable();
            $table->string('language')->nullable();
            $table->string('loanDuration')->nullable();
            $table->string('repaymentFrequency')->nullable();
            $table->string('maxLoanAmount')->nullable();
            $table->string('paymentMethods')->nullable();
            $table->string('interestCalcMethod')->nullable();
            $table->string('amortizationSchedule')->nullable();
            $table->string('roleManagement')->nullable();
            $table->string('approvalLevels')->nullable();
            $table->string('requiredDocuments')->nullable();
            $table->string('exportFormat')->nullable();
            $table->string('passwordRequirements')->nullable();
            $table->string('customLoanFields')->nullable();
            $table->string('customUserFields')->nullable();
            $table->string('logLevel')->nullable();
            $table->string('backupFrequency')->nullable();
            $table->string('cloudBackupProvider')->nullable();
            $table->string('communicationMethod')->nullable();
            $table->text('emailSignature')->nullable();
            $table->string('taxIdNumber')->nullable();
            $table->string('complianceDocuments')->nullable();
            $table->enum('late_fee_type', ['Fixed', 'Percentage'])->default('Percentage');

            $table->integer('alertThreshold')->nullable();
            $table->integer('sessionTimeout')->nullable();
            $table->integer('retentionPeriod')->nullable();
            $table->integer('grace_period')->nullable();

            $table->decimal('interestRate')->nullable();
            $table->decimal('taxRate')->nullable();
            $table->decimal('latePaymentPenalty')->nullable();

            $table->boolean('repaymentReminders')->default(0);
            $table->boolean('autoRepayment')->default(0);
            $table->boolean('partialPaymentAllowance')->default(0);
            $table->boolean('compoundingInterest')->default(0);
            $table->boolean('dataAccessControl')->default(0);
            $table->boolean('emailNotifications')->default(0);
            $table->boolean('smsNotifications')->default(0);
            $table->boolean('autoApprovalAmount')->default(0);
            $table->boolean('automatedReports')->default(0);
            $table->boolean('twoFactorAuth')->default(0);
            $table->boolean('enableAuditTrail')->default(0);
            $table->boolean('automaticBackups')->default(0);
            $table->boolean('allowMarketingEmails')->default(0);
            $table->boolean('customReportFields')->default(0);
            $table->boolean('ipRestrictions')->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
