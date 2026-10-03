<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;

class Show extends Component
{
    public Project $project;
    public string $catatan_evaluasi = '';

    public function mount(Project $project)
    {
        $this->project = $project->load(['creator', 'members.user']);
        $this->catatan_evaluasi = $project->catatan_evaluasi ?? '';
    }

    public function saveEvaluasi()
    {
        $isPj = $this->project->members()
            ->where('user_id', auth()->id())
            ->where('is_pic', true)
            ->exists();

        if (!$isPj && !in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv'])) {
            abort(403);
        }

        $this->project->update(['catatan_evaluasi' => $this->catatan_evaluasi]);

        $this->dispatch('evaluasi-saved');
    }

    public function render()
    {
        return view('livewire.project.show')->layout('layouts.app');
    }
}