<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'timestamp', 'status', 'device_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }


    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function getCheckTypeAttribute($value)
    {
        if ($value == 1) {
            return 'Check In';
        } else {
            return 'Check Out';
        }
    }
}
