<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'test_type_id',
        'user_id',
        'grade_id',
        'max_attempts',
        'opened',
        'open_at',
        'close_at',
    ];

    protected $appends = ['type', 'grade', 'config'];

    public function getTypeAttribute()
    {
        return TestType::find($this->test_type_id);
    }

    public function getConfigAttribute()
    {
        $type = TestType::find($this->test_type_id);

        if (is_null($type)) return null;
        
        //### AUTOMCQ
        if ($type->name == 'mcq') {
            $c = McqTest::where('test_id', $this->id)->first();
            
            if (is_null($c)) {
                $new = new McqTest();
                $new->dur_extra = 0;
                $new->shuffle_questions = 0;
                $new->struct = '[]';
                return $new;
            }

            return $c;
        }
    }

    public function getGradeAttribute()
    {
        return Grade::find($this->grade_id);
    }

    public function isOpen() {
        return Carbon::parse($this->open_at)->isPast() && Carbon::parse($this->close_at)->isFuture();
    }
}
