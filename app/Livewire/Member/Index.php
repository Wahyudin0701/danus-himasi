<?php
namespace App\Livewire\Member;
use Livewire\Component;
use App\Models\User;

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
        return view('livewire.member.index', [
            'members' => User::where('role', '!=', 'admin')->latest()->get()
        ])->layout('layouts.app');
    }
}

