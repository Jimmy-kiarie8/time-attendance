<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ["currency", "dateFormat", "timeZone", "language", "interestRate", "loanDuration", "repaymentFrequency", "latePaymentPenalty", "maxLoanAmount", "repaymentReminders", "autoRepayment", "partialPaymentAllowance", "paymentMethods", "interestCalcMethod", "compoundingInterest", "amortizationSchedule", "roleManagement", "dataAccessControl", "emailNotifications", "smsNotifications", "alertThreshold", "autoApprovalAmount", "approvalLevels", "requiredDocuments", "exportFormat", "automatedReports", "customReportFields", "twoFactorAuth", "passwordRequirements", "sessionTimeout", "ipRestrictions", "customLoanFields", "customUserFields", "enableAuditTrail", "logLevel", "retentionPeriod", "automaticBackups", "backupFrequency", "cloudBackupProvider", "communicationMethod", "allowMarketingEmails", "emailSignature", "taxRate", "taxIdNumber", "complianceDocuments", "grace_period"];


    protected $casts = [
        "repaymentReminders" => "boolean",
        "autoRepayment" => "boolean",
        "partialPaymentAllowance" => "boolean",
        "compoundingInterest" => "boolean",
        "dataAccessControl" => "boolean",
        "emailNotifications" => "boolean",
        "smsNotifications" => "boolean",
        "autoApprovalAmount" => "boolean",
        "automatedReports" => "boolean",
        "twoFactorAuth" => "boolean",
        "enableAuditTrail" => "boolean",
        "automaticBackups" => "boolean",
        "allowMarketingEmails" => "boolean",
        "customReportFields" => "boolean",
        "ipRestrictions" => "boolean"
    ];


    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse(($value))->format('d M Y');
    }
}
