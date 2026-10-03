<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Periode;
use Livewire\Attributes\Layout;
use App\Livewire\Actions\Logout;

#[Layout('layouts.guest')]
class InactivePeriode extends Component
{
    public function logout(Logout $logout)
    {
        $logout();
        $this->redirectRoute('login');
    }

    public function render()
    {
        $userPeriode = Auth::user()->periode;
        $activePeriode = Periode::active();

        return view('livewire.inactive-periode', [
            'userPeriode' => $userPeriode,
            'activePeriode' => $activePeriode
        ]);
    }
}
