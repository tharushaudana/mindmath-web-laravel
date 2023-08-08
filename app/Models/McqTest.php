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
        'dur_extra',
        'struct',
        'shuffle_questions',
    ];

    public function questions() {
        return $this->hasMany(McqQuestion::class, 'mcq_test_id');
    }

    public function totalDurationInSecs() {
        //return $this->dur_per * $this->num_questions + $this->dur_extra;
        return 3600;
    }
}
