<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'title',
        'description',
        'due_date',
        'status',
        'progress_notes',
        'priority',
        'task_file',
        'task_proof',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}