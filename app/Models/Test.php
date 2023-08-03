<?php

namespace App\Models;

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

    protected $appends = ['type', 'config'];

    public function getTypeAttribute()
    {
        return TestType::find($this->test_type_id);
    }

    public function getConfigAttribute()
    {
        $type = TestType::find($this->test_type_id);

        if (is_null($type)) return null;
        
        if ($type->name == 'mcq') {
            $c = McqTest::find($this->id, 'test_id');
            
            if (is_null($c)) {
                $new = new McqTest();
                $new->test_id = $this->id;
                return $new;
            }

            return $c;
        }
    }

    /*public function type()
    {
        return $this->belongsTo(TestType::class, 'test_type_id');
    }*/

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    /*public function config() {
        if ($this->type->name == 'mcq') {
            $relation = $this->hasOne(McqTest::class, 'test_id');

            if (is_null($relation)) return new McqTest();
            return $relation;
        }
    }*/
}
