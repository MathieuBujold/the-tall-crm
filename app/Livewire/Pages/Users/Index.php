<?php

namespace App\Livewire\Pages\Users;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{

    public $paginate = 10;

    public function getUsersProperty()
    {
        return User::where('enabled', true)->paginate($this->paginate);
    }

    public function render()
    {
        return view('livewire.pages.users.index');
    }
}
