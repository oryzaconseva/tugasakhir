<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',
        'description',
        'attachment_path'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
