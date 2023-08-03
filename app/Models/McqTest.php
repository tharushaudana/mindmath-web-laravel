<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'num_questions',
        'dur_per',
        'nplus',
        'nminus',
        'nmultiply',
        'ndivition',
        'operation_order',
        'digits_order',
        'shuffle_digits_order'
    ];
}
