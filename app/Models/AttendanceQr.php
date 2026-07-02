<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceQr extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_data',
        'date',
        'expires_at'
    ];
}
