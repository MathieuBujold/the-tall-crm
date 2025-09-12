<?php

namespace App\Livewire\Pages\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class IndexModal extends Component
{
    public UserForm $user;

    public function render()
    {
        return view('livewire.pages.users.index-modal');
    }

    #[On('editUser')]
    public function editUser($userId)
    {
        $user = User::find($userId);
        $this->authorize('edit', $user);
        //$this->user->setUser($user);
        $this->modal('userModal')->show();
    }

    public function save()
    {
        //
    }

    public function closeModal() {}
}
