<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'provider',
        'api_key',
        'username',
        'sender_id',
        'additional_settings',
        'is_default',
    ];

    protected $casts = [
        'additional_settings' => 'array',
        'is_default' => 'boolean',
    ];

    public function setAsDefault()
    {
        $this->where('is_default', true)->update(['is_default' => false]);
        $this->is_default = true;
        $this->save();
    }
}
