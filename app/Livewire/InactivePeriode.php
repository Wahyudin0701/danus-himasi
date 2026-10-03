<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Periode;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')]
class InactivePeriode extends Component
{
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
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
