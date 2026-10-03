<?php
namespace App\Livewire\Rab;

use Livewire\Component;
use App\Models\Project;
use App\Models\Rab;
use App\Models\RabItem;

class Create extends Component
{
    public Project $project;
    
    public $items = [];

    public function mount(Project $project)
    {
        $this->project = $project;
        
        // Ensure user is the PIC or admin
        $isPj = $project->members()->where('user_id', auth()->id())->where('is_pic', true)->exists();
        if (!$isPj && !in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv'])) {
            abort(403, 'Anda tidak memiliki izin untuk membuat RAB.');
        }

        // Check if RAB already exists
        $existingRab = Rab::where('project_id', $project->id)->first();
        if ($existingRab) {
            // redirect to edit if we had one, but for now just abort
            abort(403, 'RAB sudah dibuat untuk proker ini.');
        }

        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = [
            'description' => '',
            'quantity' => 1,
            'unit' => 'pcs',
            'unit_price' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function save()
    {
        $this->validate([
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $rab = Rab::create([
            'project_id' => $this->project->id,
            'submitted_by' => auth()->id(),
            'status' => 'draft',
        ]);

        foreach ($this->items as $item) {
            RabItem::create([
                'rab_id' => $rab->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit' => $item['unit'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('projects.show', $this->project->id);
    }

    public function render()
    {
        return view('livewire.rab.create')->layout('layouts.app');
    }
}