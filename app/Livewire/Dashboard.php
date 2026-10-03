<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;

class Dashboard extends Component
{
    public function render()
    {
        $totalAnggota = User::where('role', 'anggota')->count();
        $totalProker  = Project::count();
        $prokerAktif  = Project::where('status', 'active')->count();
        $recentProjects = Project::with('members.user')->latest()->take(8)->get();
        $anggota = User::whereIn('role', ['anggota', 'sekretaris', 'bendahara'])->get();

        return view('livewire.dashboard', compact(
            'totalAnggota', 'totalProker', 'prokerAktif', 'recentProjects', 'anggota'
        ))->layout('layouts.app');
    }
}
