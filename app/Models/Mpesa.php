<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpesa extends Model
{
    use HasFactory;

    protected $fillable = [
        "customer_key",
        "customer_secret",
        "confirmation_url",
        "validation_url",
        "passkey",
        "short_code",
        "account_type",
        "registered",
        "environment",
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse(($value))->format('d M Y H:i');
    }

    public function setValidationUrlAttribute()
    {
        $this->attributes['validation_url'] = env('APP_URL') . '/api/validation';
    }

    public function setConfirmationUrlAttribute()
    {
        $this->attributes['confirmation_url'] = env('APP_URL') . '/api/confirmation';
    }
    public function setCRegisteredAttribute()
    {
        $this->attributes['registed'] = false;
    }
}
