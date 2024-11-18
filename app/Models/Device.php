<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['device_name', 'location', 'ip_address'];

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class, 'device_id');
    }
}