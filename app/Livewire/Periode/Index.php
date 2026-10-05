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

    // Automated fields
    public string $nextPeriodeName = '';
    public int $nextYearStart = 0;
    public int $nextYearEnd = 0;

    public function openCreate(): void
    {
        $latestPeriode = Periode::orderBy('year_end', 'desc')->first();
        if ($latestPeriode) {
            $this->nextYearStart = $latestPeriode->year_end;
        } else {
            $this->nextYearStart = (int) date('Y');
        }
        $this->nextYearEnd = $this->nextYearStart + 1;
        $this->nextPeriodeName = $this->nextYearStart . '/' . $this->nextYearEnd;

        $this->showCreateModal = true;
    }

    public function createPeriode(): void
    {
        if (Periode::where('name', $this->nextPeriodeName)->exists()) {
            session()->flash('error', "Periode {$this->nextPeriodeName} sudah ada.");
            return;
        }

        $newPeriode = Periode::create([
            'name'       => $this->nextPeriodeName,
            'year_start' => $this->nextYearStart,
            'year_end'   => $this->nextYearEnd,
            'is_active'  => false,
        ]);
        
        $newPeriode->activate();

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'CREATE_PERIODE',
            'description' => Auth::user()->name . " membuat dan otomatis mengaktifkan periode kepengurusan baru: {$this->nextPeriodeName}.",
            'ip_address'  => request()->ip(),
        ]);

        $this->showCreateModal = false;
        session()->flash('success', "Periode {$this->nextPeriodeName} berhasil dibuat.");
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
