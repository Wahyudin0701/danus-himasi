<?php

namespace App\Livewire\SystemLog;

use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'Hanya Admin yang dapat mengakses halaman ini.');

        $logs = ActivityLog::with('user')
            ->where('description', 'like', '%' . $this->search . '%')
            ->orWhereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(15);

        return view('livewire.system-log.index', [
            'logs' => $logs
        ]);
    }
}