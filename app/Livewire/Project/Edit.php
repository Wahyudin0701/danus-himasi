<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;

class Edit extends Component
{
    public Project $project;
    public $name        = '';
    public $description = '';
    public $tujuan      = '';
    public $sasaran     = '';
    public $category    = '';
    
    
    public $start_date  = '';
    public $end_date    = '';
    public $pic_id      = '';

    public function mount(Project $project)
    {
        if (!in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv'])) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit program kerja.');
        }

        $this->project     = $project;
        $this->name        = $project->name;
        $this->description = $project->description;
        $this->tujuan      = $project->tujuan;
        $this->sasaran     = $project->sasaran;
        $this->category    = $project->category;
        
        
        $this->start_date  = $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : '';
        $this->end_date    = $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') : '';
        $pic = $project->members()->where('is_pic', true)->first();
        $this->pic_id = $pic ? $pic->user_id : '';
    }

    public function save()
    {
        $this->validate([
            'name'       => 'required|string|max:255',
            'tujuan'     => 'required|string',
            'sasaran'    => 'required|string',
            'category'   => 'required|in:pembuatan_atribut,penjualan_event,event_danus,konsumsi_kegiatan,penyewaan,usaha_tetap',
            'pic_id'     => 'required|exists:users,id',
            
            
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $this->project->update([
            'name'        => $this->name,
            'description' => $this->description,
            'tujuan'      => $this->tujuan,
            'sasaran'     => $this->sasaran,
            'category'    => $this->category,
            
            
            'start_date'  => $this->start_date ?: null,
            'end_date'    => $this->end_date ?: null,
        ]);

        // Update PJ
        $this->project->members()->where('is_pic', true)->delete();
        ProjectMember::create([
            'project_id' => $this->project->id,
            'user_id'    => $this->pic_id,
            'is_pic'     => true,
        ]);

        return redirect()->route('projects.index');
    }

    public function render()
    {
        return view('livewire.project.edit', [
            'users' => User::whereNotIn('role', ['admin', 'kadiv', 'wakadiv'])->get()
        ])->layout('layouts.app');
    }
}
