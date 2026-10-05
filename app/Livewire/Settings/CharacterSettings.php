<?php

namespace App\Livewire\Settings;

use App\Models\CharacterSetting;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

#[Layout('layouts.app')]
class CharacterSettings extends Component
{
    use WithFileUploads;

    public $characters = [];
    public $newPhoto;
    public $editingId = null;
    public $editName = '';

    // For Adding
    public $isAdding = false;
    public $addName = '';
    public $addPhoto;

    public function mount(): void
    {
        $this->loadCharacters();
    }

    public function loadCharacters()
    {
        $this->characters = CharacterSetting::orderBy('sort_order')->get()->toArray();
    }

    public function triggerAdd()
    {
        $this->isAdding = true;
        $this->addName = '';
        $this->addPhoto = null;
        $this->cancelEdit();
    }

    public function cancelAdd()
    {
        $this->isAdding = false;
        $this->addName = '';
        $this->addPhoto = null;
    }

    public function saveNewCharacter()
    {
        $this->validate([
            'addName' => 'required|string|max:255',
            'addPhoto' => 'required|image|max:2048',
        ]);

        $filename = time() . '_' . $this->addPhoto->hashName();
        \Illuminate\Support\Facades\File::move($this->addPhoto->getRealPath(), public_path('Foto_Karikatur_Kepala_Besar/' . $filename));

        $maxSort = CharacterSetting::max('sort_order') ?? 0;

        CharacterSetting::create([
            'filename' => $filename,
            'display_name' => $this->addName,
            'show_on_home' => true,
            'show_on_login' => true,
            'sort_order' => $maxSort + 1,
        ]);

        $this->cancelAdd();
        $this->loadCharacters();
        session()->flash('message', 'Karakter baru berhasil ditambahkan.');
    }

    public function deleteCharacter($id)
    {
        $char = CharacterSetting::findOrFail($id);
        if (file_exists(public_path('Foto_Karikatur_Kepala_Besar/' . $char->filename))) {
            @unlink(public_path('Foto_Karikatur_Kepala_Besar/' . $char->filename));
        }
        $char->delete();
        
        $this->loadCharacters();
        session()->flash('message', 'Karakter berhasil dihapus.');
    }

    public function triggerEdit($id)
    {
        $this->editingId = $id;
        $this->newPhoto = null;
        $char = CharacterSetting::findOrFail($id);
        $this->editName = $char->display_name;
        $this->cancelAdd();
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->newPhoto = null;
        $this->editName = '';
    }

    public function updateCharacter()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'newPhoto' => 'nullable|image|max:2048',
        ]);

        $char = CharacterSetting::findOrFail($this->editingId);

        $updateData = [
            'display_name' => $this->editName,
        ];

        if ($this->newPhoto) {
            $filename = time() . '_' . $this->newPhoto->hashName();
            \Illuminate\Support\Facades\File::move($this->newPhoto->getRealPath(), public_path('Foto_Karikatur_Kepala_Besar/' . $filename));

            if (file_exists(public_path('Foto_Karikatur_Kepala_Besar/' . $char->filename))) {
                @unlink(public_path('Foto_Karikatur_Kepala_Besar/' . $char->filename));
            }

            $updateData['filename'] = $filename;
        }

        $char->update($updateData);

        $this->editingId = null;
        $this->newPhoto = null;
        $this->editName = '';
        $this->loadCharacters();
        session()->flash('message', 'Data karakter berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.settings.character-settings');
    }
}
