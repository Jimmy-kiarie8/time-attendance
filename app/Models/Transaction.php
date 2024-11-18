<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [ "transaction", "TransactionType", "TransID", "TransTime", "TransAmount", "BusinessShortCode", "BillRefNumber", "InvoiceNumber", "OrgAccountBalance", "ThirdPartyTransID", "MSISDN", "FirstName", "MiddleName", "LastName", "code_used", "loan_id", "overpayment_amount"];

    protected $appends = [
        'name'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse(($value))->format('d M Y H:i:s');
    }

    /**
     * Get the sale that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }


    public function getNameAttribute()
    {
        return $this->attributes['FirstName'] . ' ' . $this->attributes['MiddleName'] . ' ' . $this->attributes['LastName'];
    }

}
