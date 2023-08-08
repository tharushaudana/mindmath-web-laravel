<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'student_id',
        'finished_at',
        'corrects',
        'expire_at'
    ];
}
