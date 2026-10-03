<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;

class Create extends Component
{
    public $name        = '';
    public $description = '';
    public $tujuan      = '';
    public $sasaran     = '';
    public $category    = 'pembuatan_atribut';
    
    
    public $start_date  = '';
    public $end_date    = '';
    public $pic_id      = '';

    public function save()
    {
        $this->validate([
            'name'       => 'required|string|max:255',
            'tujuan'     => 'required|string',
            'sasaran'    => 'required|string',
            'category'   => 'required|in:pembuatan_atribut,penjualan_event,event_danus,konsumsi_kegiatan,penyewaan,usaha_tetap',
            'pic_id'     => 'required|exists:users,id',
            
            
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $project = Project::create([
            'name'        => $this->name,
            'description' => $this->description,
            'tujuan'      => $this->tujuan,
            'sasaran'     => $this->sasaran,
            'category'    => $this->category,
            
            
            'start_date'  => $this->start_date ?: null,
            'end_date'    => $this->end_date ?: null,
            'created_by'  => auth()->id(),
            'status'      => 'draft',
        ]);

        ProjectMember::create([
            'project_id' => $project->id,
            'user_id'    => $this->pic_id,
            'is_pic'     => true,
        ]);

        return redirect()->route('projects.index');
    }

    public function render()
    {
        return view('livewire.project.create', [
            'users' => User::where('role', '!=', 'admin')->get()
        ])->layout('layouts.app');
    }
}
