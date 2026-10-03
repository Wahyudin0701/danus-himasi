<?php
namespace App\Livewire\Rab;

use Livewire\Component;
use App\Models\Project;
use App\Models\Rab;
use App\Models\RabItem;

class Edit extends Component
{
    public Project $project;
    public Rab $rab;
    public $items = [];

    public function mount(Project $project)
    {
        $this->project = $project;

        $isPj = $project->members()->where('user_id', auth()->id())->where('is_pic', true)->exists();
        if (!$isPj && !in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv'])) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit RAB ini.');
        }

        $this->rab = Rab::where('project_id', $project->id)->firstOrFail();

        // Load existing items into editable array
        $this->items = $this->rab->items->map(fn($item) => [
            'id'          => $item->id,
            'description' => $item->description,
            'quantity'    => $item->quantity,
            'unit'        => $item->unit,
            'unit_price'  => $item->unit_price,
        ])->toArray();
    }

    public function addItem()
    {
        $this->items[] = [
            'id'          => null,
            'description' => '',
            'quantity'    => 1,
            'unit'        => 'pcs',
            'unit_price'  => 0,
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
            'items'                 => 'required|array|min:1',
            'items.*.description'   => 'required|string|max:255',
            'items.*.quantity'      => 'required|integer|min:1',
            'items.*.unit'          => 'required|string|max:50',
            'items.*.unit_price'    => 'required|numeric|min:0',
        ]);

        // Delete all old items and re-insert
        $this->rab->items()->delete();

        foreach ($this->items as $item) {
            RabItem::create([
                'rab_id'      => $this->rab->id,
                'description' => $item['description'],
                'quantity'    => $item['quantity'],
                'unit'        => $item['unit'],
                'unit_price'  => $item['unit_price'],
                'total'       => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('projects.show', $this->project->id);
    }

    public function render()
    {
        return view('livewire.rab.edit')->layout('layouts.app');
    }
}
