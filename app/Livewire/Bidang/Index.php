<?php

namespace App\Livewire\Bidang;

use App\Models\Bidang;
use Livewire\Component;

class Index extends Component
{
    public $name = '';
    
    public $confirmingDeletion = false;
    public $bidangToDeleteId = null;
    public $bidangToDeleteName = '';
    public $memberCountToDelete = 0;

    public $showAddForm = false;
    
    public $showEditForm = false;
    public $editBidangId = null;
    public $editName = '';

    public function mount()
    {
        abort_if(auth()->user()->role !== 'admin', 403);
    }

    public function openAddForm()
    {
        $this->name = '';
        $this->resetValidation();
        $this->showAddForm = true;
    }

    public function closeAddForm()
    {
        $this->showAddForm = false;
    }

    public function editBidang($id)
    {
        $bidang = Bidang::findOrFail($id);
        $this->editBidangId = $bidang->id;
        $this->editName = $bidang->name;
        $this->resetValidation();
        $this->showEditForm = true;
    }

    public function closeEditForm()
    {
        $this->showEditForm = false;
        $this->editBidangId = null;
        $this->editName = '';
    }

    public function update()
    {
        $this->validate([
            'editName' => 'required|string|max:255|unique:bidangs,name,' . $this->editBidangId,
        ], [
            'editName.required' => 'Nama bidang wajib diisi.',
            'editName.unique' => 'Nama bidang ini sudah ada.'
        ]);

        $bidang = Bidang::with('members')->findOrFail($this->editBidangId);
        
        $oldName = $bidang->name;
        $newName = $this->editName;

        // Cascade update ke string jabatan milik user/anggota bidang ini (karena jabatan mengandung nama bidang)
        if ($oldName !== $newName) {
            foreach ($bidang->members as $member) {
                if (str_contains($member->jabatan, $oldName)) {
                    $member->jabatan = str_replace($oldName, $newName, $member->jabatan);
                    $member->save();
                }
            }
        }

        $bidang->update(['name' => $newName]);
        
        $this->closeEditForm();
        session()->flash('message', 'Bidang beserta jabatannya berhasil diperbarui.');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:bidangs,name',
        ], [
            'name.required' => 'Nama bidang wajib diisi.',
            'name.unique' => 'Nama bidang ini sudah ada.'
        ]);

        $bidang = Bidang::create(['name' => $this->name]);
        $this->name = '';
        $this->showAddForm = false;
        
        session()->flash('message', 'Bidang berhasil ditambahkan.');
    }

    public function confirmDelete($id)
    {
        $bidang = Bidang::withCount('members')->findOrFail($id);
        $this->bidangToDeleteId = $bidang->id;
        $this->bidangToDeleteName = $bidang->name;
        $this->memberCountToDelete = $bidang->members_count;
        $this->confirmingDeletion = true;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->bidangToDeleteId = null;
        $this->bidangToDeleteName = '';
        $this->memberCountToDelete = 0;
    }

    public function delete()
    {
        if ($this->bidangToDeleteId) {
            $bidang = Bidang::findOrFail($this->bidangToDeleteId);
            
            if ($this->memberCountToDelete > 0) {
                $bidang->members()->delete();
            }

            $bidang->delete();
            
            $this->cancelDelete();
            session()->flash('message', 'Bidang beserta datanya berhasil dihapus.');
        }
    }

    public function render()
    {
        // Pemuatan data dilakukan sekaligus di awal agar Alpine.js bisa beralih tab SECARA INSTAN tanpa AJAX
        return view('livewire.bidang.index', [
            'bidangs' => Bidang::with('members')->get()
        ])->layout('layouts.app');
    }
}
