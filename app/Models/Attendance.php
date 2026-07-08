<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id',
        'date',
        'check_in_time',
        'check_in_latitude',
        'check_in_longitude',
        'check_out_time',
        'check_out_latitude',
        'check_out_longitude',
        'status',
        'is_late',
        'is_early_checkout'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
