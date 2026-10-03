<?php

namespace App\Livewire\Kas;

use Livewire\Component;
use App\Models\KasDanus;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $date;
    public $type = 'pemasukan';
    public $amount;
    public $description;
    
    public $showModal = false;
    public $editId = null;

    protected $rules = [
        'date' => 'required|date',
        'type' => 'required|in:pemasukan,pengeluaran',
        'amount' => 'required|numeric|min:0',
        'description' => 'required|string|max:255',
    ];

    public function mount()
    {
        // Akses view dibuka untuk semua anggota
        $this->date = date('Y-m-d');
    }
    
    private function checkPermission()
    {
        if (!in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv', 'bendahara'])) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengubah data kas.');
        }
    }

    public function createRecord()
    {
        $this->checkPermission();
        $this->reset(['amount', 'description', 'editId']);
        $this->date = date('Y-m-d');
        $this->type = 'pemasukan';
        $this->showModal = true;
    }

    public function editRecord($id)
    {
        $this->checkPermission();
        $record = KasDanus::findOrFail($id);
        $this->editId = $record->id;
        $this->date = $record->date->format('Y-m-d');
        $this->type = $record->type;
        $this->amount = (int) $record->amount; // Remove decimals for input
        $this->description = $record->description;
        $this->showModal = true;
    }

    public function saveRecord()
    {
        $this->checkPermission();
        $this->validate();

        if ($this->editId) {
            $record = KasDanus::findOrFail($this->editId);
            $record->update([
                'date' => $this->date,
                'type' => $this->type,
                'amount' => $this->amount,
                'description' => $this->description,
            ]);
        } else {
            KasDanus::create([
                'created_by' => auth()->id(),
                'date' => $this->date,
                'type' => $this->type,
                'amount' => $this->amount,
                'description' => $this->description,
            ]);
        }

        $this->reset(['amount', 'description', 'editId']);
        $this->showModal = false;
        
        $this->dispatch('kas-saved');
    }

    public function deleteRecord($id)
    {
        $this->checkPermission();
        KasDanus::findOrFail($id)->delete();
    }

    public function render()
    {
        $totalPemasukan = KasDanus::where('type', 'pemasukan')->sum('amount');
        $totalPengeluaran = KasDanus::where('type', 'pengeluaran')->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $records = KasDanus::with('creator')->latest('date')->latest('id')->paginate(15);
        $canEdit = in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv', 'bendahara']);

        return view('livewire.kas.index', [
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldo' => $saldo,
            'records' => $records,
            'canEdit' => $canEdit,
        ])->layout('layouts.app');
    }
}