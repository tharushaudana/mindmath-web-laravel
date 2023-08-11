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
        $rules = include 'rules.php';
        if ($this->showConfigureTest) return $rules['config'][$this->test->type->name];
        return $rules['test'];
    }

    public function createTest()
    {
        $this->validate();

        $this->test->user_id = Auth::user()->id;
        $this->test->save();

        $this->showCreate(false);

        $this->fireAlert('success', 'Test has been created.');
    }

    public function configureTest() 
    {
        $this->validate();

        $this->config->test_id = $this->test->id;
        $this->config->save();

        $this->showConfigure(false);

        $this->fireAlert('success', 'Test has been configured.');
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

    public function setValue(string $key, $value)
    {
        $keys = explode('.', $key);

        if (count($keys) == 1) {
            if (property_exists($this, $key)) 
                $this->{$key} = $value;
            
            else return;
        } else {
            $property = $keys[0];
            $nestedKey = $keys[1];

            if (property_exists($this, $property))
                $this->{$property}[$nestedKey] = $value;

            else return;
        }

        $this->validateOnly($key);
    }

    public function testCall($struct) 
    {
        $this->config['struct'] = $struct;
        $this->emit('liveerrors', 'test');
    }

    private function fireAlert($type, $content)
    {
        $this->dispatchBrowserEvent('fire-alert', [
            'type' => $type,
            'content' => $content
        ]);
    }

    private function clearAll()
    {
        $this->test = new Test();
        $this->test->max_attempts = 1;
        $this->resetErrorBag();
    }

    public function mount()
    {
        $this->clearAll();
    }

    public function updated($name)
    {
        // Because those set using 'setOpenAt()' & 'setCloseAt()'
        if ($name == 'test.open_at' || $name == 'test.close_at') return;
        $this->validateOnly($name);
    }

    public function render()
    {
        return view('livewire.admin.manage.tests.tests')
            ->with('tests', Test::orderBy('id', 'desc')->get())
            ->with('grades', Grade::all())
            ->with('types', TestType::all());
    }
}
