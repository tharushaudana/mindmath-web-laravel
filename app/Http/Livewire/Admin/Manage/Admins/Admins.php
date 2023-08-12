<?php

namespace App\Http\Livewire\Admin\Manage\Admins;

use App\Models\AdminInvitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Admins extends Component
{
    public $showCreateInvitation = false;

    public $inviteEmail = "";

    protected $rules = [
        'inviteEmail' => 'required|email',
    ];

    public function createInvitation() {
        $this->validate();
        
        $invitation = new AdminInvitation([
            'user_id' => Auth::user()->id,
            'email' => $this->inviteEmail,
        ]);

        $invitation->save();

        $this->fireAlert('success', 'Invitation Created Successfully.');
        $this->inviteEmail = '';
    }

    public function deleteInvitation($id) {
        $invitation = AdminInvitation::find($id);
        if (is_null($invitation)) return;
        $invitation->delete();
        $this->fireAlert('success', 'Invitation Deleted Successfully.');
    }

    public function showCreateInvitationForm($b) {
        $this->showCreateInvitation = $b;
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
        return view('livewire.admin.manage.admins.admins', [
            'admins' => User::all(),
            'invitations' => AdminInvitation::all(),
            'me' => Auth::user(),
        ]);
    }
}
