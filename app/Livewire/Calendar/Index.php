<?php

namespace App\Livewire\Calendar;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render()
    {
        // Fetch all projects for the calendar
        $projects = Project::whereNotNull('start_date')->get();
        
        $events = $projects->map(function ($project) {
            return [
                'id' => $project->id,
                'title' => $project->name,
                'start' => $project->start_date,
                // FullCalendar end dates are exclusive, so we add 1 day if end_date exists to cover the whole last day
                'end' => $project->end_date ? \Carbon\Carbon::parse($project->end_date)->addDay()->format('Y-m-d') : $project->start_date,
                'url' => route('projects.show', $project->id),
                'backgroundColor' => $this->getColorForStatus($project->status),
                'borderColor' => 'transparent',
                'allDay' => true,
            ];
        });

        return view('livewire.calendar.index', [
            'events' => $events
        ]);
    }
    
    private function getColorForStatus($status)
    {
        return match($status) {
            'planning' => '#64748b', // slate-500
            'active' => '#22c55e',   // green-500
            'completed' => '#6366f1', // indigo-500
            default => '#3b82f6',     // blue-500
        };
    }
}