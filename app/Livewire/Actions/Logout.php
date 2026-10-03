<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): void
    {
        if (Auth::check()) {
            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'LOGOUT',
                'description' => Auth::user()->name . ' keluar (logout) dari sistem.',
                'ip_address' => request()->ip()
            ]);
        }
        
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();
    }
}
