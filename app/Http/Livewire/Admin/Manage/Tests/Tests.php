<?php

namespace App\Http\Livewire\Admin\Manage\Tests;

use App\Models\Grade;
use App\Models\Test;
use App\Models\TestType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Tests extends Component
{
    public Test $test;
    public $config;
    public $showCreateTest = false;
    public $showConfigureTest = false;

    protected function rules()
    {
        $default = [
            'test.name' => ['required', 'string'],
            'test.test_type_id' => ['required', 'integer', 'exists:test_types,id'],
            'test.grade_id' => ['nullable', 'integer', 'exists:grades,id'],
            'test.max_attempts' => ['required', 'integer', 'min:1'],
            'test.open_at' => ['nullable', 'date_format:Y-m-d H:i:s', 'after_or_equal:now'],
            'test.close_at' => ['required', 'date_format:Y-m-d H:i:s', 'after:test.open_at', 'after:now'],
        ];

        if (!is_null($this->test->type)) {
            if ($this->test->type->name == 'mcq') {
                return array_merge($default, [
                    'config.num_questions' => ['required', 'integer', 'min:1'],
                ]);
            }
        }

        return $default;
    }

    public function createTest()
    {
        $this->validate();
        
        $this->test->user_id = Auth::user()->id;
        $this->test->save();
        
        $this->clearAll();

        $this->showCreate(false);

        $this->fireAlert('success', 'Test has been created.');
    }

    public function showCreate($show)
    {
        $this->clearAll();

        if ($show) {
            $this->showCreateTest = true;
            $this->showConfigureTest = false;
        } else {
            $this->showCreateTest = false;
        }
    }

    public function showConfigure($show, $test_id = null)
    {
        if ($show) {
            $this->test = Test::find($test_id);
            //----
            $this->config = $this->test->config;
            //---
            $this->showConfigureTest = true;
            $this->showCreateTest = false;
        } else {
            $this->clearAll();
            $this->showConfigureTest = false;
        }
    }

    public function setOpenAt($value)
    {
        $this->test->open_at = $value;
        $this->validateOnly('test.open_at');
    }

    public function setCloseAt($value)
    {
        $this->test->close_at = $value;
        $this->validateOnly('test.close_at');
    }

    private function fireAlert($type, $content) {
        $this->dispatchBrowserEvent('fire-alert', [
            'type' => $type, 
            'content' => $content
        ]);
    }

    private function clearAll() {
        $this->test = new Test();
        $this->test->max_attempts = 1;        
    }

    public function mount()
    {
        $this->clearAll();
    }

    public function updated($name)
    {
        if ($name == 'test.open_at' || $name == 'test.close_at') return;

        $this->validateOnly($name);
    }

    public function render()
    {
        return view('livewire.admin.manage.tests.tests')
            ->with('tests', Test::all())
            ->with('grades', Grade::all())
            ->with('types', TestType::all());
    }
}
