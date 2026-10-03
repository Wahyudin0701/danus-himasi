<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use App\Models\Periode;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public string $filter = 'all';

        public function deleteProject($id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv'])) {
            abort(403);
        }
        
        $project = Project::findOrFail($id);
        $projectName = $project->name;
        $project->delete();
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'DELETE_PROJECT',
            'description' => auth()->user()->name . ' membatalkan dan menghapus program kerja: ' . $projectName,
            'ip_address' => request()->ip()
        ]);
    }
    
    public function render()
    {
        $userId = auth()->id();

        $activePeriodeId = optional(Periode::active())->id;
        $query = Project::with('creator', 'members.user')->where('periode_id', $activePeriodeId)->latest();

        if ($this->filter === 'mine') {
            $query->whereHas('members', function ($q) use ($userId) {
                $q->where('user_id', $userId)->where('is_pic', true);
            });
        }

        // Hitung total keuntungan keseluruhan menggunakan database aggregation
        $totalKeuntungan = (clone $query)->sum(DB::raw('COALESCE(pendapatan, 0) - COALESCE(modal, 0)'));

        $projects = $query->get();

        return view('livewire.project.index', [
            'projects' => $projects,
            'totalKeuntungan' => (float) $totalKeuntungan
        ])->layout('layouts.app');
    }
}