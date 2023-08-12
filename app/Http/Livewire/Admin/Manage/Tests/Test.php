<?php

namespace App\Http\Livewire\Admin\Manage\Tests;

use App\Models\Test as TestModel;
use Livewire\Component;

class Test extends Component
{
    public TestModel $test; 

    public $selectedStudentId = null;

    public function render()
    {
        return view('livewire.admin.manage.tests.test', [
            'test' => $this->test
        ]);
    }
}
