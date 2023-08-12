<?php

namespace App\Http\Livewire\Admin\Manage\Students;

use App\Models\Grade;
use App\Models\Student;
use Livewire\Component;

class Students extends Component
{
    public $showCreateGrade = false;

    public $gradeName;

    protected $rules = [
        'gradeName' => 'required|min:1'
    ];

    public function createGrade() {
        $this->validate();

        $grade = new Grade([
            'name' => $this->gradeName
        ]);

        $grade->save();

        $this->showCreateGradeForm(false);

        $this->fireAlert('success', 'Grade Created Successfully.');
        $this->gradeName = '';
    }

    public function showCreateGradeForm($b) {
        $this->showCreateGrade = $b;
    }

    private function fireAlert($type, $content)
    {
        $this->dispatchBrowserEvent('fire-alert', [
            'type' => $type,
            'content' => $content
        ]);
    }

    public function updated($name)
    {
        $this->validateOnly($name);
    }

    public function render()
    {
        return view('livewire.admin.manage.students.students', [
            'students' => Student::all(),
            'grades' => Grade::all(),
        ]);
    }
}
