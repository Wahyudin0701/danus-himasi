<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\User;
use App\Models\Periode;

class Index extends Component
{
    public function delete(User $user)
    {
        if ($user->id !== auth()->id()) {
            $user->delete();
        }
    }

    public function render()
    {
        $activePeriodeId = optional(Periode::active())->id;

        return view('livewire.member.index', [
            'members' => User::where('role', '!=', 'admin')
                             ->where('periode_id', $activePeriodeId)
                             ->latest()
                             ->get()
        ])->layout('layouts.app');
    }
}
