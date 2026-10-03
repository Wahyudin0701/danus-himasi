<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public string $filter = 'all';

    public function render()
    {
        $userId = auth()->id();

        $query = Project::with('creator', 'members.user')->latest();

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