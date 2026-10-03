<?php
namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use App\Models\ProjectFinance;
use Carbon\Carbon;

class Finance extends Component
{
    public Project $project;
    public $type; // 'modal' or 'pendapatan'
    
    public $description = '';
    public $amount = '';
    public $date = '';
    
    public $editId = null;

    public function mount(Project $project, $type)
    {
        if (!in_array($type, ['modal', 'pendapatan'])) {
            abort(404);
        }

        $this->project = $project;
        $this->type = $type;
        $this->date = Carbon::now()->format('Y-m-d');
    }

    public function createRecord()
    {
        $this->reset(['description', 'amount', 'editId']);
        $this->date = Carbon::now()->format('Y-m-d');
        $this->dispatch('open-modal');
    }

    public function editRecord($id)
    {
        $record = ProjectFinance::findOrFail($id);
        if ($record->project_id !== $this->project->id) {
            abort(403);
        }

        $this->editId = $record->id;
        $this->description = $record->description;
        $this->amount = (int) $record->amount;
        $this->date = $record->date->format('Y-m-d');
        
        $this->dispatch('open-modal');
    }

    public function save()
    {
        $isPj = $this->project->members()->where('user_id', auth()->id())->where('is_pic', true)->exists();
        if (!$isPj && !in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv'])) {
            abort(403, 'Anda tidak berhak mengedit keuangan.');
        }

        $this->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
        ]);

        if ($this->editId) {
            $record = ProjectFinance::findOrFail($this->editId);
            if ($record->project_id === $this->project->id) {
                $record->update([
                    'description' => $this->description,
                    'amount' => $this->amount,
                    'date' => $this->date,
                ]);
            }
        } else {
            ProjectFinance::create([
                'project_id' => $this->project->id,
                'type' => $this->type,
                'description' => $this->description,
                'amount' => $this->amount,
                'date' => $this->date,
                'created_by' => auth()->id(),
            ]);
        }

        // Sync with Project table aggregates
        $this->syncAggregates();

        $this->reset(['description', 'amount', 'editId']);
        $this->date = Carbon::now()->format('Y-m-d');
        $this->dispatch('close-modal');
    }

    public function deleteRecord($id)
    {
        $isPj = $this->project->members()->where('user_id', auth()->id())->where('is_pic', true)->exists();
        if (!$isPj && !in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv'])) {
            abort(403);
        }

        $record = ProjectFinance::findOrFail($id);
        if ($record->project_id === $this->project->id) {
            $record->delete();
            $this->syncAggregates();
        }
    }

    private function syncAggregates()
    {
        $totalModal = ProjectFinance::where('project_id', $this->project->id)->where('type', 'modal')->sum('amount');
        $totalPendapatan = ProjectFinance::where('project_id', $this->project->id)->where('type', 'pendapatan')->sum('amount');
        
        $this->project->update([
            'modal' => $totalModal,
            'pendapatan' => $totalPendapatan,
        ]);
    }

    public function render()
    {
        $records = ProjectFinance::where('project_id', $this->project->id)
            ->where('type', $this->type)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $isPj = $this->project->members()->where('user_id', auth()->id())->where('is_pic', true)->exists();
        $canEdit = $isPj || in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv']);

        return view('livewire.project.finance', [
            'canEdit' => $canEdit,
            'records' => $records
        ])->layout('layouts.app');
    }
}