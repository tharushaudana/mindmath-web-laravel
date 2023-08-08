<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'mcq_test_id',
        'attempt_id',
        'question',
        'answers',
        'correct_answer',
        'loaded_at',
    ];
}
