<?php

namespace App\Livewire\Periode;

use Livewire\Component;
use App\Models\Periode;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public bool $showCreateModal = false;
    public bool $showActivateModal = false;
    public ?int $confirmActivateId = null;
    public string $confirmActivateName = '';

    // Form fields
    public string $year_start = '';
    public string $year_end = '';

    protected $rules = [
        'year_start' => 'required|integer|min:2020|max:2050',
        'year_end'   => 'required|integer|min:2020|max:2050|gt:year_start',
    ];

    protected $messages = [
        'year_start.required' => 'Tahun mulai wajib diisi.',
        'year_end.required'   => 'Tahun selesai wajib diisi.',
        'year_end.gt'         => 'Tahun selesai harus lebih besar dari tahun mulai.',
    ];

    public function openCreate(): void
    {
        $this->reset('year_start', 'year_end');
        $this->resetValidation();
        $this->showCreateModal = true;
    }

    public function createPeriode(): void
    {
        $this->validate();

        $name = $this->year_start . '/' . $this->year_end;

        if (Periode::where('name', $name)->exists()) {
            $this->addError('year_start', "Periode $name sudah ada.");
            return;
        }

        Periode::create([
            'name'       => $name,
            'year_start' => (int) $this->year_start,
            'year_end'   => (int) $this->year_end,
            'is_active'  => false,
        ]);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'CREATE_PERIODE',
            'description' => Auth::user()->name . " membuat periode kepengurusan baru: $name.",
            'ip_address'  => request()->ip(),
        ]);

        $this->showCreateModal = false;
        session()->flash('success', "Periode $name berhasil dibuat.");
    }

    public function confirmActivate(int $id): void
    {
        $periode = Periode::findOrFail($id);
        $this->confirmActivateId = $id;
        $this->confirmActivateName = $periode->name;
        $this->showActivateModal = true;
    }

    public function activatePeriode(): void
    {
        $periode = Periode::findOrFail($this->confirmActivateId);
        $oldActive = Periode::where('is_active', true)->first();

        $periode->activate();

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'ACTIVATE_PERIODE',
            'description' => Auth::user()->name . " mengaktifkan periode {$periode->name}" .
                             ($oldActive ? " (menggantikan {$oldActive->name})" : '') . '.',
            'ip_address'  => request()->ip(),
        ]);

        $this->showActivateModal = false;
        $this->confirmActivateId = null;
        session()->flash('success', "Periode {$periode->name} berhasil diaktifkan.");
    }

    public function render()
    {
        $periodes = Periode::orderByDesc('year_start')->get();
        $activePeriode = Periode::active();

        return view('livewire.periode.index', compact('periodes', 'activePeriode'))
            ->layout('layouts.app');
    }
}
