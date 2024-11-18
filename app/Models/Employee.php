<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'emp_code',
        'department',
        'designation',
        'finger_id',
        'card_id',
        'password'
    ];



    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class, 'employee_id', 'employee_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $number = Employee::max('id') + 1;
            $model->reference = make_reference_id('EMP', $number);
        });
    }
}
