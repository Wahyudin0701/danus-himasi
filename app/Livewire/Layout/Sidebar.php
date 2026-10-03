<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use App\Livewire\Actions\Logout;

class Sidebar extends Component
{
    public function logout(Logout $logout)
    {
        $logout();
        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.layout.sidebar');
    }
}
