<?php

namespace App\Http\Livewire\Student;

use App\Models\AdminInvitation;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class LoginRegister extends Component
{
    protected $queryString = ['to'];

    public $name, $grade, $email, $password, $password_confirmation;
    public $showRegisterForm = false;
    public $errorMsg = null;

    public $to = null; // for redirect

    protected function rules()
    {
        if ($this->showRegisterForm) {
            return [
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:students,email'],
                'grade' => ['required', 'exists:grades,id'],
                'password' => ['required', 'min:8'],
                'password_confirmation' => 'required_with:password|same:password|min:8'
            ];
        } else {
            return [
                'email' => ['required', 'email', 'exists:students,email'],
                'password' => ['required'],
            ];
        }
    }

    public function login()
    {
        $this->setErrorMsg(null);

        $validated = $this->validate($this->rules());

        if (Auth::guard('student')->attempt($validated)) {
            if (!is_null($this->to)) {
                //return redirect()->route($this->to);
                return redirect()->route('student.home');
            } else {
                return redirect()->route('student.home');
            }
        } else {
            $this->setErrorMsg('Credentials mismatch!');
        }
    }

    public function register()
    {
        $this->setErrorMsg(null);

        $validated = $this->validate($this->rules());

        Student::create([
            'name' => $validated['name'],
            'grade_id' => $validated['grade'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $this->showRegisterForm = false;
    }

    public function logout() {
        Auth::guard('student')->logout();
    }

    public function loginForm()
    {
        $this->setErrorMsg(null);
        $this->showRegisterForm = false;
    }

    public function registerForm()
    {
        $this->setErrorMsg(null);
        $this->showRegisterForm = true;
    }

    private function setErrorMsg($msg)
    {
        $this->errorMsg = $msg;
    }

    public function updated($name)
    {
        if ($name == 'password' || $name == 'password_confirmation') {
            $this->validateOnly('password');
            $this->validateOnly('password_confirmation');
            return;
        }

        $this->validateOnly($name);
    }

    public function render()
    {
        return view('livewire.student.login-register')->with('grades', Grade::all());
    }
}
