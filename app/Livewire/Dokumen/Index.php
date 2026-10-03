<?php

namespace App\Livewire\Dokumen;

use App\Models\Dokumen;
use App\Models\Periode;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class Index extends Component
{
    public $parentId = null;
    public $currentFolder = null;
    
    // Form fields
    public $name;
    public $link;
    public $type = 'folder'; // folder or file
    
    // Modal states
    public $showModal = false;
    public $editId = null;
    public $showDeleteModal = false;
    public $deleteId = null;
    
    public function mount($folder = null)
    {
        $this->parentId = $folder;
        if ($this->parentId) {
            $this->currentFolder = Dokumen::find($this->parentId);
        }
    }
    
    public function getCanEditProperty()
    {
        return in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv', 'sekretaris']);
    }
    
    public function openFolder($id)
    {
        $this->parentId = $id;
        $this->currentFolder = Dokumen::find($id);
    }
    
    public function goBack()
    {
        if ($this->currentFolder && $this->currentFolder->parent_id) {
            $this->parentId = $this->currentFolder->parent_id;
            $this->currentFolder = Dokumen::find($this->parentId);
        } else {
            $this->parentId = null;
            $this->currentFolder = null;
        }
    }
    
    public function createItem($type)
    {
        $this->authorizeEdit();
        $this->resetForm();
        $this->type = $type;
        $this->showModal = true;
    }
    
    public function editItem($id)
    {
        $this->authorizeEdit();
        $this->resetForm();
        
        $item = Dokumen::find($id);
        $this->editId = $item->id;
        $this->name = $item->name;
        $this->link = $item->link;
        $this->type = $item->type;
        $this->showModal = true;
    }
    
    public function confirmDelete($id)
    {
        $this->authorizeEdit();
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }
    
    public function deleteItem()
    {
        $this->authorizeEdit();
        if ($this->deleteId) {
            Dokumen::find($this->deleteId)->delete();
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }
    
    public function save()
    {
        $this->authorizeEdit();
        
        $this->validate([
            'name' => 'required|string|max:255',
            'link' => 'nullable|url',
        ]);
        
        if ($this->editId) {
            Dokumen::find($this->editId)->update([
                'name' => $this->name,
                'link' => $this->link,
            ]);
        } else {
            Dokumen::create([
                'parent_id' => $this->parentId,
                'name' => $this->name,
                'link' => $this->link,
                'type' => $this->type,
                'created_by' => auth()->id(),
            ]);
        }
        
        $this->showModal = false;
        $this->resetForm();
    }
    
    private function resetForm()
    {
        $this->editId = null;
        $this->name = '';
        $this->link = '';
        $this->type = 'folder';
        $this->resetValidation();
    }
    
    private function authorizeEdit()
    {
        if (!$this->canEdit) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah dokumen.');
        }
    }
    
    public function render()
    {
        $items = Dokumen::where('parent_id', $this->parentId)
            ->orderBy('type', 'desc') // folder first, then file
            ->orderBy('name', 'asc')
            ->get();
            
        // Get breadcrumbs
        $breadcrumbs = [];
        $curr = $this->currentFolder;
        while ($curr) {
            array_unshift($breadcrumbs, $curr);
            $curr = $curr->parent;
        }
        
        return view('livewire.dokumen.index', [
            'items' => $items,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}