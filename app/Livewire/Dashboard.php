<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use App\Models\Periode;

class Dashboard extends Component
{
    public function render()
    {
        $activePeriodeId = optional(Periode::active())->id;

        $totalAnggota = User::where('role', '!=', 'admin')
                            ->where('periode_id', $activePeriodeId)
                            ->count();
        
        $totalProker  = Project::where('periode_id', $activePeriodeId)->count();
        
        $totalModal = Project::where('periode_id', $activePeriodeId)->sum('modal');
        $totalPendapatan = Project::where('periode_id', $activePeriodeId)->sum('pendapatan');
        $totalKeuntungan = $totalPendapatan - $totalModal;
        
        $prokerAktif  = Project::where('status', 'active')
                               ->where('periode_id', $activePeriodeId)
                               ->count();
                               
        $recentProjects = Project::with('members.user')
                                 ->where('periode_id', $activePeriodeId)
                                 ->latest()
                                 ->take(8)
                                 ->get();
                                 
        $anggota = User::whereIn('role', ['anggota', 'sekretaris', 'bendahara'])
                       ->where('periode_id', $activePeriodeId)
                       ->get();

        return view('livewire.dashboard', compact(
            'totalAnggota', 'totalProker', 'prokerAktif', 'recentProjects', 'anggota', 'totalModal', 'totalPendapatan', 'totalKeuntungan'
        ))->layout('layouts.app');
    }
}
