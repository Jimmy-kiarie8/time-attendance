<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'leave_date', 'leave_type', 'description'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }
}
